<?php
namespace Larabase\DevTool;

use Illuminate\Support\ServiceProvider;

class DevToolServiceProvider extends ServiceProvider
{
    public function boot()
    {
        if ($this->app->isLocal()) {
            env('TELESCOPE_ENABLED') && $this->app->register(\Laravel\Telescope\TelescopeServiceProvider::class);
            env('DEBUGBAR_ENABLED') && $this->app->register(\Barryvdh\Debugbar\ServiceProvider::class);

            $this->app->runningInConsole() && $this->app->register(\Barryvdh\LaravelIdeHelper\IdeHelperServiceProvider::class);
        }
    }
}
