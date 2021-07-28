<?php
namespace Larabase\NovaFields;

use Illuminate\Support\Str;

class Date extends \Laravel\Nova\Fields\Date
{
    public function __construct($name, $attribute = null, $resolveCallback = null)
    {
        parent::__construct($name, $attribute, $resolveCallback);

        $dateFormat = setting('general.date_format', 'd/m/Y');
        $displayFormat = (string)Str::of($dateFormat)->replace('d', 'DD')->replace('m', 'MM')->replace('Y', 'YYYY');

        $this->pickerDisplayFormat($dateFormat);
        $this->format($displayFormat);
        $this->nullable();
    }

}
