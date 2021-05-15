<?php
namespace Larabase\Resolvers;

use Illuminate\Support\Facades\Http;

class GeolocationResolver implements \OwenIt\Auditing\Contracts\UrlResolver
{
    /**
     * {@inheritdoc}
     */
    public static function resolve(): string
    {
        $response = Http::get('http://www.geoplugin.net/php.gp?ip=113.161.70.126');
        $content = unserialize($response->body());
        return json_encode($content);
    }
}
