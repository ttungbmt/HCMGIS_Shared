<?php
namespace Larabase\Nova\MenuItemTypes;

use Laravel\Nova\Nova;
use OptimistDigital\MenuBuilder\MenuItemTypes\MenuItemSelectType;

class Resource extends MenuItemSelectType
{
    public static function getIdentifier(): string
    {
        return 'resource';
    }

    public static function getName(): string
    {
        return 'Resource';
    }

    public static function getOptions($locale): array
    {
        $resources = [
            ...Nova::$resources,
            \Vyuldashev\NovaPermission\Role::class,
            \Vyuldashev\NovaPermission\Permission::class,
            \Bolechen\NovaActivitylog\Resources\Activitylog::class,
        ];
        return array_combine($resources, $resources);
    }
}
