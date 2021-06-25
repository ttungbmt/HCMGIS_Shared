<?php
namespace Larabase\Nova\Resources;

use Ganyicz\NovaCallbacks\HasCallbacks;
use Laravel\Nova\Resource as NovaResource;

abstract class Resource extends NovaResource
{
    use HasCallbacks;

    public static $dirs = [];

    public static function group()
    {
        return __(static::$group);
    }

    protected static function policyKey(){
        return (new static::$model)->getTable();
    }
}
