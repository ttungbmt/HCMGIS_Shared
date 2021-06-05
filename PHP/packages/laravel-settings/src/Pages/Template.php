<?php
namespace Larabase\Setting\Pages;

use Closure;
use Laravel\Nova\Fields\FieldCollection;
use Laravel\Nova\Http\Requests\NovaRequest;

class Template
{
    public static $displayInNavigation = true;
    public $reloadOnSave = true;

    public $settingClass;

    public static function label(){
        return static::label();
    }

    public function resolveFields(NovaRequest $request, FieldCollection &$fields){
        $addResolveCallback = function (&$field) use($request) {
            $field->resolveUsingDefaultValue($request);

            if (!empty($field->attribute)) {
                $setting = app($this->settingClass);
                $field->resolve([$field->attribute => property_exists($setting, $field->attribute) ? $setting->{$field->attribute} : '']);
            }

            if (!empty($field->meta['fields'])) {
                foreach ($field->meta['fields'] as $_field) {
                    $setting = app($this->settingClass);
                    $_field->resolve([$_field->attribute => property_exists($setting, $field->attribute) ? $setting->{$field->attribute} : '']);
                }
            }
        };

        $fields->each(function (&$field) use ($addResolveCallback) {
            $addResolveCallback($field);
        });
    }

    protected function resolveWithDefaultValue(NovaRequest $request, $field)
    {
        if($field->value) return $field->value;

        $defaultCallback = $field->getDefaultCallback();

        if (is_null($field->value) && $defaultCallback instanceof Closure) {
            return call_user_func($defaultCallback, $request);
        }

        return $defaultCallback;
    }

    public function asController(NovaRequest $request, FieldCollection $fields, $resource){
        $setting = app($this->settingClass);

        collect((array)$resource)->each(function ($value, $attribute) use($setting){
            if(property_exists($setting, $attribute)) $setting->{$attribute} = $value;
        });

        $setting->save();
//        dd($resource);
//        if ($this->reloadOnSave === true) {
//            return response()->json(['reload' => true]);
//        }

        return response('', 204);
    }
}
