<?php
namespace Larabase\Nova\MenuItemTypes;

use DigitalCreative\CollapsibleResourceManager\Resources\Group;
use DigitalCreative\CollapsibleResourceManager\Resources\TopLevelResource;
use Laravel\Nova\Fields\Boolean;
use Laravel\Nova\Fields\Select;
use Laravel\Nova\Fields\Text;
use OptimistDigital\MenuBuilder\MenuItemTypes\BaseMenuItemType;

class ResourceGroup extends BaseMenuItemType
{

    public static function getIdentifier(): string
    {
        return 'resource-group';
    }

    public static function getName(): string
    {
        return 'Resource Group';
    }

    public static function getType(): string
    {
        return 'text';
    }

    public static function getRules(): array
    {
        return [

        ];
    }

    public static function getFields(): array
    {
        $types = collect([TopLevelResource::class, Group::class])->mapWithKeys(fn($class) => [$class => class_basename($class)]);

        return [
            Text::make('Translation', 'trans'),
            Select::make('Type', 'type')->options($types),
            Text::make('Icon', 'icon'),
            Boolean::make('Expanded', 'expanded')
        ];
    }

    public static function getData($data = null)
    {
        $data['label'] = $data['trans'] ? __($data['trans']) : '';
        $data['expanded'] = !!$data['expanded'];
        return $data;
    }
}
