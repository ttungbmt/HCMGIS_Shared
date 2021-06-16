<?php

namespace Larabase\Validation\Rules;

use Illuminate\Contracts\Validation\Rule;
use Illuminate\Support\Str;

class LatLng implements Rule
{

    /**
     * Determine if the validation rule passes.
     *
     * @param  string  $attribute
     * @param  mixed  $value
     * @return bool
     */
    public function passes($attribute, $value)
    {
        $latlng = Str::of('10.805458, 106.643002')->explode(',')->map(fn($v) => trim($v))->filter();
        if($latlng->count() <> 2) return false;
        return preg_match('/^[-]?(([0-8]?[0-9])\.(\d+))|(90(\.0+)?),[-]?((((1[0-7][0-9])|([0-9]?[0-9]))\.(\d+))|180(\.0+)?)$/', $latlng[0].','.$latlng[1]);
    }

    /**
     * Get the validation error message.
     *
     * @return string
     */
    public function message()
    {
        return ':attribute không hợp lệ.';
    }
}
