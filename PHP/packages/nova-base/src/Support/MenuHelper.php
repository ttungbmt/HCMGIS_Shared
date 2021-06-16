<?php
namespace Larabase\Nova\Support;

use DigitalCreative\CollapsibleResourceManager\CollapsibleResourceManager;
use DigitalCreative\CollapsibleResourceManager\Resources\ExternalLink;
use DigitalCreative\CollapsibleResourceManager\Resources\InternalLink;
use DigitalCreative\CollapsibleResourceManager\Resources\RawResource;
use DigitalCreative\CollapsibleResourceManager\Resources\TopLevelResource;
use Illuminate\Support\Facades\Cache;
use Larabase\Nova\MenuItemTypes\InternalUrl;
use Larabase\Nova\MenuItemTypes\Resource;
use Larabase\Nova\MenuItemTypes\Tool;
use OptimistDigital\MenuBuilder\MenuItemTypes\MenuItemStaticURLType;

class MenuHelper
{
    public static function getTools(){
        $adminMenus = MenuHelper::getAdminMenus();
        $navigationItems = MenuHelper::getAdminNavigation($adminMenus);

        $toolItems = collect(MenuHelper::getMenuTools($adminMenus))->map(fn($i) => new $i);

        return collect([
            new CollapsibleResourceManager([
                'navigation' => [
                    ...$navigationItems,
                ]
            ]),
            ...$toolItems,
        ]);
    }

    public static function getMenuTools($menuItems)
    {
        $tools = [];

        foreach ($menuItems as $i) {
            if ($i['type'] === Tool::getIdentifier() && $i['enabled']) $tools[] = $i['value'];
            if ($i['children']) $tools = array_merge($tools, static::getMenuTools($i['children']));
        }

        return $tools;
    }

    public static function getAdminMenus()
    {
        $slug = 'admin';
        $adminMenus = Cache::remember('menus.'.$slug, 2*24*60*60, fn() => data_get(nova_get_menu_by_slug($slug), 'menuItems', []));
//        return data_get(nova_get_menu_by_slug('admin'), 'menuItems', []);
        return $adminMenus;
    }

    public static function getAdminNavigation($adminMenus)
    {
        return collect($adminMenus)->where('enabled', true)->map(function ($i) {
            $label = data_get($i, 'data.label', '');
            $label = $label === '' ? $i['name'] : $label;
            $icon = data_get($i, 'data.icon', '');
            $url = data_get($i, 'data.url', '');

            if ($i['type'] === Tool::getIdentifier() && $url) return TopLevelResource::make([
                'label' => $i['name'],
            ])->linkToResource(RawResource::make([
                'target' => '_self',
                'path' => $url,
            ]))->icon($icon);


            $resources = $i['children']->whereIn('type', [InternalUrl::getIdentifier(), MenuItemStaticURLType::getIdentifier(), Resource::getIdentifier(), Tool::getIdentifier()])->where('enabled', true)->map(function ($v) {
                $url = data_get($v, 'data.url', '');
                $icon = data_get($v, 'data.icon', '');

                if ($v['type'] === Tool::getIdentifier()) return InternalLink::make([
                    'label' => $v['name'],
                    'target' => '_self',
                    'path' => $url,
                ])->icon($icon);

                if ($v['type'] === InternalUrl::getIdentifier()) return InternalLink::make([
                    'label' => $v['name'],
                    'target' => '_self',
                    'path' => $url,
                ])->icon($icon);

                if ($v['type'] === MenuItemStaticURLType::getIdentifier()) {
                    return ExternalLink::make([
                        'label' => $v['name'],
                        'target' => '_blank',
                        'url' => $v['value'],
                    ])->icon($icon);
                }

                if ($v['type'] === Resource::getIdentifier()) return $v['value'];
            });

            $data = [
                'label' => $label,
                'resources' => $resources->filter()->all()
            ];

            if (isset($i['data']['expanded'])) $data['expanded'] = $i['data']['expanded'];
            return TopLevelResource::make($data)->icon($icon);
        })->filter();
    }

    public static function getSidebarTools(){
        $menuTools = MenuHelper::getMenuTools(MenuHelper::getAdminMenus());
        return collect(\Laravel\Nova\Nova::availableTools(request()))->filter(fn($i) => !in_array(get_class($i), $menuTools));
    }

}