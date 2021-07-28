<?php
namespace Larabase\NovaFields;

use Laravel\Nova\Fields\Field;
use Laravel\Nova\Http\Requests\NovaRequest;

/*
 * @see: https://github.com/nalingia/nova-secret-field
 * */

class Secret extends Field
{
    /**
     * The field's component.
     *
     * @var string
     */
    public $component = 'nova-secret-field';

    public function __construct($name, $attribute = null, callable $resolveCallback = null) {
        parent::__construct($name, $attribute, $resolveCallback);

        $this->withMeta([
            'showCopyToClipboard' => true,
            'showGenerator' => true,
            'showMask' => false,
        ]);
    }

    public function showCopyToClipboard($value = true) {
        return $this->withMeta([
            'showCopyToClipboard' => $value,
        ]);
    }

    public function showMask($value = true) {
        return $this->withMeta([
            'showMask' => $value,
        ]);
    }

    /**
     * @param  array  $rules
     * @return mixed
     */
    public function showGenerator($value = true)
    {
        return $this->withMeta([
            'showGenerator' => $value,
        ]);
    }

    public function generatorOptions(array $options = [])
    {
        return $this->withMeta([
            'generatorOptions' => array_merge([
                'numbers' => true
            ], $options),
        ]);
    }
}