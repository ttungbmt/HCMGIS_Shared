<?php
namespace Larabase\Nova\MenuItemTypes;

use Larabase\Nova\Models\MapLayer;
use Laravel\Nova\Fields\Boolean;
use OptimistDigital\MenuBuilder\MenuItemTypes\MenuItemSelectType;

class Layer extends MenuItemSelectType
{
    public static function getIdentifier(): string
    {
        return 'layer';
    }

    public static function getName(): string
    {
        return 'Layer';
    }

    public static function getOptions($locale): array {
        return MapLayer::all()->pluck('name', 'id')->all();
    }

    public static function getDisplayValue($value, ?array $data, $locale) {
        $name = data_get(MapLayer::find($value), 'name');
        return $value.") {$name}";
    }


    public static function getRules(): array
    {
        return [

        ];
    }


    public static function getFields(): array
    {
        return [
            Boolean::make('Selected', 'selected'),
        ];
    }

    public static function getData($data = null)
    {
        $layerData = [];
        if(isset($data['selected'])) $layerData['active'] = !!$data['selected'];
        return $layerData;
    }
}
