<?php
namespace Larabase\Nova\MenuItemTypes;

use Laravel\Nova\Fields\Text;
use OptimistDigital\MenuBuilder\MenuItemTypes\MenuItemSelectType;

class Tool extends MenuItemSelectType
{
    public static function getIdentifier(): string
    {
        return 'tool';
    }

    public static function getName(): string
    {
        return 'Tool';
    }

    public static function getOptions($locale): array
    {
        $tools = array_keys(self::mappingTools());

        return array_combine($tools, $tools);
    }

    public static function mappingTools(){
        return [
            \Mastani\NovaPasswordReset\NovaPasswordReset::class => [
                'url' => '/nova-password-reset',
                'ability' => 'users.reset-password'
            ],
            \ChrisWare\NovaBreadcrumbs\NovaBreadcrumbs::class => [
                'ability' => 'breadcumbs'
            ],
            \Bolechen\NovaActivitylog\NovaActivitylog::class => [
                'url' => '/resources/nova-activity-log',
                'ability' => 'activity-log'
            ],

            \Spatie\BackupTool\BackupTool::class => [
                'url' => '',
                'ability' => '/backups'
            ],
            \BinaryBuilds\NovaAdvancedCommandRunner\CommandRunner::class => [
                'url' => '/nova-advanced-command-runner',
                'ability' => 'command-runner'
            ],
            \Infinety\Filemanager\FilemanagerTool::class => [
                'url' => '/nova-filemanager',
                'ability' => 'file-manager'
            ],
            \OptimistDigital\MenuBuilder\MenuBuilder::class => [
                'url' => '/resources/nova-menus',
                'ability' => 'menu-builder'
            ],
            \Larabase\NovaPage\NovaPage::class => [],
            \KABBOUCHI\LogsTool\LogsTool::class => [],
            \Sbine\RouteViewer\RouteViewer::class => [],
        ];
    }

    public static function getFields(): array
    {
        return [
            Text::make('Icon', 'icon'),
            Text::make('Url', 'url')
        ];
    }
}
