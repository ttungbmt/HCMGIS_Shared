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
use Laravel\Nova\Http\Requests\NovaRequest;
use OptimistDigital\MenuBuilder\MenuItemTypes\MenuItemStaticURLType;
use Spatie\Permission\PermissionRegistrar;

class MenuHelper
{
    public static function getTools(){
        $adminMenus = MenuHelper::getAdminMenus();
        $navigationItems = MenuHelper::getAdminNavigation($adminMenus);

        $toolItems = MenuHelper::getMenuTools($adminMenus);

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
            if ($i['type'] === Tool::getIdentifier() && $i['enabled']) $tools[] = $i['tool'] ?? new $i['value'];
            if ($i['children']) $tools = array_merge($tools, static::getMenuTools($i['children']));
        }

        return $tools;
    }

    public static function getAdminMenus()
    {
        $slug = 'admin';
        $adminMenus = Cache::remember('menus.'.$slug, 2*24*60*60, fn() => data_get(nova_get_menu_by_slug($slug), 'menuItems', []));
//        return self::formatMenus(data_get(nova_get_menu_by_slug('admin'), 'menuItems', []));
        return self::formatMenus($adminMenus);
    }

    public static function formatMenus($menus){
        $data = [];
        foreach ($menus as $k => $i){
            $data[$k] = $i;

            if($i['type'] === Tool::getIdentifier()){
                $ability = data_get(Tool::mappingTools(), $i['value'].'.ability');
                $permissions = app(PermissionRegistrar::class)->getPermissions();
                if($ability && !$permissions->filter(fn($m) => $m->name === $ability)->isEmpty()){
                    $data[$k]['tool'] = (new $i['value'])->canSeeWhen($ability);
                    $data[$k]['enabled'] = $i['enabled'] && $data[$k]['tool']->authorize(app(NovaRequest::class));
                }
            }

            if($i['children']) $data[$k]['children'] = self::formatMenus($i['children']);
        }

        return collect($data);
    }

    public static function getAdminNavigation($adminMenus)
    {
        return collect($adminMenus)->where('enabled', true)->map(function ($i) {
            $label = data_get($i, 'data.label', '');
            $label = $label === '' ? $i['name'] : $label;
            $icon = data_get($i, 'data.icon', '');
            $url = data_get($i, 'data.url', '');

            if ($i['type'] === Tool::getIdentifier() && $url) {
                return TopLevelResource::make([
                    'label' => $i['name'],
                ])->linkToResource(RawResource::make([
                    'target' => '_self',
                    'path' => $url,
                ]))->icon($icon);
            };

            $resources = $i['children']->whereIn('type', [InternalUrl::getIdentifier(), MenuItemStaticURLType::getIdentifier(), Resource::getIdentifier(), Tool::getIdentifier()])->where('enabled', true)->map(function ($v) {
                $url = data_get($v, 'data.url', '');
                $icon = data_get($v, 'data.icon', '');

                if ($v['type'] === Tool::getIdentifier()) {
                    return InternalLink::make([
                        'label' => $v['name'],
                        'target' => '_self',
                        'path' => $url,
                    ])->icon($icon);
                }

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
        $menuTools = collect(MenuHelper::getMenuTools(MenuHelper::getAdminMenus()))->map(fn($t) => get_class($t))->all();
        $novaTools = \Laravel\Nova\Nova::availableTools(request());
        return collect($novaTools)->filter(fn($i) => !in_array(get_class($i), $menuTools));
    }

}