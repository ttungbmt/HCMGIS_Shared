<?php
namespace Larabase\Nova\Fields;

use Laravel\Nova\Fields\Text;

class Email extends Text
{
    public function __construct($name, $attribute = null, callable $resolveCallback = null)
    {
        parent::__construct($name, $attribute, $resolveCallback);

        $this->withMeta([
            'type' => 'email'
        ]);
    }
}
