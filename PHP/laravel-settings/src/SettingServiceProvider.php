<?php
namespace Larabase\Setting;

use Illuminate\Support\Facades\Blade;
use Illuminate\Support\ServiceProvider;

class SettingServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap the application services.
     *
     * @return void
     */
    public function boot()
    {
        Blade::directive('setting', function ($expression) {
            return "<?php echo setting($expression); ?>";
        });
    }

    /**
     * Register the application services.
     *
     * @return void
     */
    public function register()
    {
        $this->app->singleton('setting', function ($app) {
            return new Setting();
        });
    }
}
