<?php
namespace Larabase\Nova\Filters;

use Illuminate\Http\Request;
use Illuminate\Support\Str;

class MultiSelectFilter extends \OptimistDigtal\NovaMultiselectFilter\MultiselectFilter
{
    public $attribute;

    /**
     * @var callable|null
     */
    protected $optionsCallback;

    public function __construct($name = null, $attribute = null)
    {
        $this->name = $name ?? $this->name;
        $this->attribute = $attribute ?? $this->attribute ?? str_replace(' ', '_', Str::lower($this->name()));
        $this->placeholder(__('Choose :name', ['name' => Str::lower($this->name())]));
    }

    /**
     * @param  callable|array $callback
     *
     * @return $this
     */
    final public function withOptions($callback)
    {
        if (! is_callable($callback)) $callback = fn (Request $request) => $callback;

        $this->optionsCallback = $callback;

        return $this;
    }

    public function options(Request $request)
    {
        return call_user_func($this->optionsCallback, $request);
    }

    public function apply(Request $request, $query, $value)
    {
        return $query->whereIn($this->attribute, $value);
    }
}
