<?php

namespace Larabase\Nova;

use Closure;
use Illuminate\Support\Arr;
use Illuminate\Support\Carbon;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Blade;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\ServiceProvider;
use Laravel\Nova\Events\ServingNova;
use Laravel\Nova\Http\Requests\NovaRequest;
use Laravel\Nova\Nova;
use Laravel\Nova\Tools\Dashboard;
use Laravel\Nova\Tools\ResourceManager;
use Illuminate\Support\Facades\File;
use OptimistDigital\NovaTranslationsLoader\LoadsNovaTranslations;

class NovaServiceProvider extends ServiceProvider
{
    use LoadsNovaTranslations;

    /**
     * Bootstrap any package services.
     *
     * @return void
     */
    public function boot()
    {
        $this->registerResources();
        $this->registerTools();
        $this->registerCollectionMacros();
        $this->registerFieldMacros();
        $this->registerJsonVariables();
        $this->registerBladeDirectives();
    }

    /**
     * Register the package resources such as routes, templates, etc.
     *
     * @return void
     */
    protected function registerResources()
    {
        collect([
            'nova' => __DIR__ . '/../resources/lang',
            'filemanager' => __DIR__ . '/../resources/lang/vendor/filemanager',
            'nova-password-reset' => __DIR__ . '/../resources/lang/vendor/nova-password-reset',
            'nova-backup-tool' => __DIR__ . '/../resources/lang/vendor/nova-backup-tool',
            'nova-menu-builder' => __DIR__ . '/../resources/lang/vendor/nova-menu-builder',
            'nova-auditable-log' => __DIR__ . '/../resources/lang/vendor/nova-auditable-log',
            'advanced-nova-media-library' => __DIR__ . '/../resources/lang/vendor/advanced-nova-media-library',
        ])->each(fn($filePath, $name) => $this->loadTranslations($filePath, $name, true));

        $this->registerRoutes();
    }

    /**
     * Register the package routes.
     *
     * @return void
     */
    protected function registerRoutes()
    {
        Route::group($this->routeConfiguration(), function () {
            $this->loadRoutesFrom(__DIR__.'/../routes/api.php');
        });
    }

    /**
     * Get the Nova route group configuration array.
     *
     * @return array
     */
    protected function routeConfiguration()
    {
        return [
            'namespace' => 'Laravel\Nova\Http\Controllers',
            'domain' => config('nova.domain', null),
            // 'as' => 'nova.api.',
            'prefix' => 'nova-api',
            'middleware' => 'nova',
        ];
    }

    /**
     * Boot the standard Nova tools.
     *
     * @return void
     */
    protected function registerTools()
    {
//        Nova::tools([
//            new Dashboard,
//            new ResourceManager,
//        ]);
    }


    /**
     * Register the Nova JSON variables.
     *
     * @return void
     */
    protected function registerJsonVariables()
    {
        Nova::serving(function (ServingNova $event) {

        });
    }

    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {

    }

    protected function registerCollectionMacros()
    {

    }

    protected function registerFieldMacros(){
        \Laravel\Nova\Fields\Field::macro('resolveUsingDefaultValue', function(NovaRequest $request){
            if (is_null($this->value)) {
                $this->value = $this->defaultCallback instanceof Closure ? call_user_func($this->defaultCallback, $request) : $this->defaultCallback;
            }
        });
    }

    protected function registerBladeDirectives()
    {
        Blade::directive('hastool', function ($expression) {
            return "<?php if(collect(\Laravel\Nova\Nova::\$tools)->first(fn(\$i) => get_class(\$i) === {$expression})) : ?>";
        });

        Blade::directive('endtool', function ($expression) {
            return "<?php endif; ?>";
        });
    }
}
