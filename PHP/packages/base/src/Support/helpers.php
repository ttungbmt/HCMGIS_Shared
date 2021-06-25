<?php

use Illuminate\Support\Carbon;
use Illuminate\Support\Str;

if (!function_exists('to_date')) {
    function to_date($str, $strict = true)
    {
        $date = is_string($str) ? trim($str) : $str;
        if(!$date || $date === '') return null;

        if(is_string($date)){
            try {
                if(Str::contains($date, '-')) return Carbon::createFromFormat('Y-m-d', $str);
                else return Carbon::createFromFormat('d/m/Y', $str);
            } catch (\Exception $e){
                throw_if($strict, $e);
                return null;
            }
        }

        return $date;
    }
}

if (!function_exists('from_date')) {
    function from_date($date)
    {
        return $date ? $date->format('d/m/Y') : null;
    }
}

