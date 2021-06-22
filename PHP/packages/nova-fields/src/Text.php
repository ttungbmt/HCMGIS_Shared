<?php
namespace Larabase\NovaFields;

use Illuminate\Support\Arr;
use Illuminate\Support\Str;
use Laravel\Nova\Http\Requests\NovaRequest;

class Text extends \Laravel\Nova\Fields\Text
{
    use Configurable;

    public $component = 'nova-text-field';

    public function limit($words = 100, $end = '...', $disableOnActions = []){
        !in_array(request()->get('action'), $disableOnActions) && $this->displayUsing(fn ($value) => Str::words($value, $words, $end));
        return $this;
    }

    public function tooltip($options = []){
        return $this->withMeta([
            'tooltip' => $options
        ]);
    }

    public function icon($icon)
    {
        return $this->withMeta(['icon'      => $icon]);
    }

    public function url($url, $target = '_self')
    {
        return $this->withMeta([
            'url' => is_callable($url) ? call_user_func($url) : $url,
            'target' => $target
        ]);
    }

    public function target($target = 'blank')
    {
        return $this->withMeta([
            'target' => $target,
        ]);
    }

    public function link($resource)
    {
        $router = $resource instanceof \Laravel\Nova\Resource ? [
            'path' => "/resources/{$resource->uriKey()}/{$resource->id}"
        ] : $resource;

        return $this->withMeta(['router' => $router]);
    }

    public function linkResource(array $router)
    {
        if(!Arr::isAssoc($router)) return $this->withMeta(['router' => ['path' => "/resources/{$router[0]}/{$router[1]}"]]);

        return $this->withMeta(['router' => $router]);
    }


//    public function api($path, $resourceClass)
//    {
//        if (empty($resourceClass)) throw new Exception('Multiselect requires resourceClass, none provided.');
//        if (empty($path)) throw new Exception('Multiselect requires apiUrl, none provided.');
//
//        $this->resolveUsing(function ($value) use ($resourceClass) {
//            $this->suggestions([]);
//            if (empty($value)) return $value;
//
//            try {
////                $modelObj = $resourceClass::newModel();
////                $models = $modelObj::where($resourceClass::$title, 'like', "%{$value}%")->get();
////                $this->suggestions($models->pluck($resourceClass::$title)->all());
//            } catch (Exception $e) {
//
//            }
//
//            return $value;
//        });
//
//        return $this->withMeta(['apiUrl' => $path, 'labelKey' => $resourceClass::$title]);
//    }
//
//    public function asyncResource($resourceClass)
//    {
//        $apiUrl = "/nova-api/{$resourceClass::uriKey()}";
//        return $this->api($apiUrl, $resourceClass);
//    }

}
