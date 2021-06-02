<?php
namespace Larabase\NovaPage\Http\Controllers;

use Illuminate\Http\Resources\ConditionallyLoadsAttributes;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\Validator;
use Larabase\NovaPage\NovaPage;
use Laravel\Nova\Contracts\Resolvable;
use Laravel\Nova\Http\Requests\NovaRequest;
use Laravel\Nova\ResolvesFields;
use Illuminate\Http\Request;

class PageController extends Controller
{
    use ResolvesFields, ConditionallyLoadsAttributes;

    public function get(NovaRequest $request){
        $path = $request->get('path');
        $label = NovaPage::getLabel($path);
        $template = NovaPage::getTemplate($path);
        $fields = $this->assignToPanels($label, $this->availableFields($request));
        $panels = $this->panelsWithDefaultLabel($label, $request);

        $template->resolveFields($request, $fields);

        return response()->json([
            'cards' => [],
            'panels' => $panels,
            'fields' => $fields,
        ], 200);
    }

    public function post(NovaRequest $request)
    {
        $path = $request->post('path');
        $template = NovaPage::getTemplate($path);
        $fields = $this->availableFields($request);

        // NovaDependencyContainer support
        $fields = $fields->map(function ($field) {
            if (!empty($field->attribute)) return $field;
            if (!empty($field->meta['fields'])) return $field->meta['fields'];
            return null;
        })->filter()->flatten();

        $rules = [];
        foreach ($fields as $field) {
            $fakeResource = new \stdClass;
            $fakeResource->{$field->attribute} = $request->post($field->attribute);
            $field->resolve($fakeResource, $field->attribute); // For nova-translatable support
            $rules = array_merge($rules, $field->getUpdateRules($request));
        }

        Validator::make($request->all(), $rules)->validate();

        $tempResource =  new \stdClass;
        $fields->whereInstanceOf(Resolvable::class)->each(function ($field) use ($request, $tempResource) {
            if (empty($field->attribute)) return;
            if ($field->isReadonly(app(NovaRequest::class))) return;

            // For nova-translatable support
            if (!empty($field->meta['translatable']['original_attribute'])) $field->attribute = $field->meta['translatable']['original_attribute'];

            $field->fill($request, $tempResource);

            if (!property_exists($tempResource, $field->attribute)) return;

        });

        return $template->asController($request, $fields, $tempResource);
    }

    protected function fields(Request $request)
    {
        return NovaPage::getFields($request->get('path'));
    }
}
