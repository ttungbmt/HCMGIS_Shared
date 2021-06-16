<?php
namespace Larabase\Nova\MenuItemTypes;

use Laravel\Nova\Fields\Text;
use OptimistDigital\MenuBuilder\MenuItemTypes\MenuItemStaticURLType;

class StaticURL extends MenuItemStaticURLType
{
    public static function getName(): string
    {
        return 'Custom Static URL';
    }

    public static function getFields(): array
    {
        return [
            Text::make('Icon', 'icon'),
        ];
    }
}
