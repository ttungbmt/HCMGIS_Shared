<?php
namespace Larabase\Nova\Fields;

class Code extends \Laravel\Nova\Fields\Code
{
    public function __construct($name, $attribute = null, callable $resolveCallback = null)
    {
        parent::__construct($name, $attribute, $resolveCallback);

        $this->autoHeight();
    }

}
