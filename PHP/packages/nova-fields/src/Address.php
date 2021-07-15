<?php
namespace Larabase\NovaFields;

use Illuminate\Support\Collection;
use Laravel\Nova\Fields\Field;
use Exception;
use RuntimeException;

class Address extends Field
{
    use Configurable;

    public $component = 'nova-address-field';

    public $showOnIndex = false;

    public $showOnDetail = false;

    public function asyncResource($resourceClass)
    {
        $apiUrl = "/nova-api/{$resourceClass::uriKey()}";
        return $this->api($apiUrl, $resourceClass);
    }

    public function api($path, $resourceClass)
    {
        if (empty($resourceClass)) throw new Exception('Address requires resourceClass, none provided.');
        if (empty($path)) throw new Exception('Address requires apiUrl, none provided.');

        $this->resolveUsing(function ($value) use ($resourceClass) {
            $this->options([]);
            $value = array_values((array)$value);

            if (empty($value)) return $value;

            // Handle translatable/collection where values are an array of arrays
            if (is_array($value) && is_array($value[0] ?? null)) {
                $value = collect($value)->flatten(1)->toArray();
            }

            try {
                $modelObj = $resourceClass::newModel();
                $models = $modelObj::whereIn($modelObj->getKeyName(), $value)->get();

                $this->setOptionsFromModels($models, $resourceClass);
            } catch (Exception $e) {
            }

            return $value;
        });

        return $this->withMeta(['apiUrl' => $path]);
    }

    /**
     * Set the options from a collection of models.
     *
     * @param  \Illuminate\Database\Eloquent\Collection  $models
     * @param  string  $resourceClass
     * @return void
     */
    public function setOptionsFromModels(Collection $models, $resourceClass)
    {
        $options = $models->mapInto($resourceClass)->mapWithKeys(function ($associatedResource) {
            return [$associatedResource->getKey() => $associatedResource->title()];
        });
        $this->options($options);
    }


    /**
     * Sets the options available for select.
     * @param  array|callable
     **/
    public function options($options = [])
    {
        if (is_callable($options)) $options = call_user_func($options);
        $options = collect($options ?? []);

        return $this->withMeta([
            'options' => $options->map(function ($label, $value) {
                return ['label' => $label, 'value' => $value];
            })->values()->all(),
        ]);
    }

    public function clearOnSelect($clearOnSelect = true)
    {
        return $this->withMeta(['clearOnSelect' => $clearOnSelect]);
    }
}
