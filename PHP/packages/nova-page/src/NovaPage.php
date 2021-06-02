<?php

namespace Larabase\NovaPage;

use Illuminate\Support\Str;
use Laravel\Nova\Nova;
use Laravel\Nova\Tool;

class NovaPage extends Tool
{
    public static $templates = [];
    /**
     * Perform any tasks that need to happen when the tool is booted.
     *
     * @return void
     */
    public function boot()
    {
        Nova::script('nova-page', __DIR__.'/../dist/js/tool.js');
        Nova::style('nova-page', __DIR__.'/../dist/css/tool.css');
    }

    /**
     * Build the view that renders the navigation links for the tool.
     *
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View
     */
    public function renderNavigation()
    {
        return view('nova-page::navigation', [
            'templates' => $this->availableForNavigation()
        ]);
    }

    public function availableForNavigation()
    {
        return collect(static::$templates)->filter(function ($i){
            $class = $i['class'];
            return $class::$displayInNavigation;
        })->all();
    }

    public static function getFields($path){
        return static::getTemplate($path)->fields();
    }

    public static function getLabel($path) {
        return data_get(static::$templates, $path.'.label');
    }

    public static function getTemplate($path) {
        $class = data_get(static::$templates, $path.'.class');
        return with(new $class);
    }

    public static function addTemplate($template){
        $path = Str::lower(Str::slug($template::$path));

        static::$templates[$path] = [
            'class' => $template,
            'label' => $template::label(),
        ];
    }
}
