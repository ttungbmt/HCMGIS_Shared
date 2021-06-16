<?php
namespace Larabase\Nova\MenuItemTypes;

use Laravel\Nova\Fields\Text;
use OptimistDigital\MenuBuilder\MenuItemTypes\BaseMenuItemType;

class InternalUrl extends BaseMenuItemType
{
    public static function getIdentifier(): string
    {
        return 'internal-url';
    }

    public static function getType(): string
    {
        return 'internal-url';
    }

    public static function getName(): string
    {
        return 'Internal URL';
    }

    public static function getFields(): array
    {
        return [
            Text::make('Url', 'url'),
            Text::make('Icon', 'icon'),
        ];
    }
}
