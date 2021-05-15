<?php
namespace Larabase\Nova\Resources;


use ChrisWare\NovaBreadcrumbs\Traits\Breadcrumbs;
use Laravel\Nova\Resource as NovaResource;

abstract class Resource extends NovaResource
{
    use Breadcrumbs;

    public static function group()
    {
        return __(static::$group);
    }
}
