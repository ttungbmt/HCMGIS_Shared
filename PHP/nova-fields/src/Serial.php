<?php
namespace Larabase\NovaFields;

use Laravel\Nova\Fields\Text;

class Serial extends Text
{
    public function __construct($name, $attribute = null, callable $resolveCallback = null)
    {
        parent::__construct($name, $attribute, $resolveCallback);
        $this->onlyOnIndex();
    }
}
