<?php


namespace Hubertnnn\LaravelNova\Fields\DynamicSelect\Traits;

use Closure;

trait HasDynamicDefaultValue
{
    public function getDefaultValue($parameters = [])
    {
        if (is_null($this->value) && $this->defaultCallback instanceof Closure) {
            return call_user_func($this->defaultCallback, $parameters);
        }

        return $this->defaultCallback;
    }
}
