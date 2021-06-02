<?php
namespace Larabase\Nova;

use Illuminate\Support\Facades\Route;
use Laravel\Nova\Nova;

class PendingRouteRegistration extends \Laravel\Nova\PendingRouteRegistration
{
    /**
     * Register the Nova authentication routes.
     *
     * @param  array  $middleware
     * @return \Laravel\Nova\PendingRouteRegistration
     */
    public function withAuthenticationRoutes($middleware = ['web'])
    {
        parent::withAuthenticationRoutes($middleware);

        Route::namespace('Larabase\Nova\Http\Controllers')
            ->domain(config('nova.domain', null))
            ->middleware($middleware)
            ->prefix(Nova::path())
            ->group(function () {
                Route::get('/register', 'RegisterController@showRegisterForm');
                Route::post('/register', 'RegisterController@register')->name('nova.register');
            });

        return $this;
    }
}
