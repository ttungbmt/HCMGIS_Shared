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
        $tools = [
            \Mastani\NovaPasswordReset\NovaPasswordReset::class,
            \ChrisWare\NovaBreadcrumbs\NovaBreadcrumbs::class,
            \Bolechen\NovaActivitylog\NovaActivitylog::class,
            \KABBOUCHI\LogsTool\LogsTool::class,
            \Spatie\BackupTool\BackupTool::class,
            \Sbine\RouteViewer\RouteViewer::class,
            \BinaryBuilds\NovaAdvancedCommandRunner\CommandRunner::class,
            \Infinety\Filemanager\FilemanagerTool::class,
            \OptimistDigital\MenuBuilder\MenuBuilder::class,
            \Larabase\NovaPage\NovaPage::class
        ];

        return array_combine($tools, $tools);
    }

    public static function getFields(): array
    {
        return [
            Text::make('Icon', 'icon'),
            Text::make('Url', 'url')
        ];
    }
}
