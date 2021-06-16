<?php

use Illuminate\Support\Carbon;

if (!function_exists('to_date')) {
    function to_date($str)
    {
        return $str ? Carbon::createFromFormat('d/m/Y', $str) : null;
    }
}

if (!function_exists('from_date')) {
    function from_date($date)
    {
        return $date ? $date->format('d/m/Y') : null;
    }
}