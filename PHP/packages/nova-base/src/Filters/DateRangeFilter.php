<?php
namespace Larabase\Nova\Filters;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;

class DateRangeFilter extends \Ampeco\Filters\DateRangeFilter
{
    public $attribute;

    public function __construct()
    {
        $this->placeholder(__('Choose date'));
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
