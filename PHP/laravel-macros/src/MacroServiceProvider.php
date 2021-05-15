<?php

namespace Larabase\Macros;

use Illuminate\Support\Collection;
use Illuminate\Support\ServiceProvider;

class MacroServiceProvider extends ServiceProvider
{
    public function register()
    {
        Collection::make(glob(__DIR__.'/*/*.php'))
            ->mapWithKeys(function ($path) {
                return [$path => pathinfo($path, PATHINFO_FILENAME)];
            })
            ->each(function ($macro, $path) {
                require_once $path;
            });
    }
}
