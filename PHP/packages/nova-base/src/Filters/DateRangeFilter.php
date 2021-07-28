<?php
namespace Larabase\Nova\Filters;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Illuminate\Support\Str;

class DateRangeFilter extends \Ampeco\Filters\DateRangeFilter
{
    public $attribute;

    public function __construct($name = null, $attribute = null)
    {
        $this->name = $name ?? $this->name;
        $this->attribute = $attribute ?? $this->attribute ?? str_replace(' ', '_', Str::lower($this->name()));

        $this->placeholder(__('Choose date'));
        $this->dateFormat('d/m/Y');
    }

    public function setName($name){
        $this->name = $name;
        return $this;
    }

    public function attribute($attribute){
        $this->attribute = $attribute;
        return $this;
    }

    public function apply(Request $request, $query, $value)
    {
        $value = collect($value)->filter()->map(fn($v) => Carbon::createFromFormat('d/m/Y', $v));
        if($value->count() === 1) return $query->where($this->attribute, $value->first());
        else if($value->count() === 2) return $query->whereBetween($this->attribute, $value->all());
        return $query;
    }

    public function options(Request $request)
    {
        return [
            'mode' => 'range',
            'dateFormat' => 'd/m/Y',
        ];
    }
}
