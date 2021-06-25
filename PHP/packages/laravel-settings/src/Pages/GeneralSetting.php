<?php

namespace Larabase\Setting\Pages;

use Larabase\Settings\General;
use DateTimeZone;
use Larabase\NovaFields\Radio;
use Laravel\Nova\Fields\Boolean;
use Laravel\Nova\Fields\Select;
use Laravel\Nova\Fields\Text;
use Laravel\Nova\Fields\Textarea;
use Laravel\Nova\Panel;

class GeneralSetting extends Template
{
    public $settingClass = General::class;

    public static $path = 'general';

    public static function label()
    {
        return 'Cơ bản';
    }

    public function fields()
    {
        $timezone = collect(DateTimeZone::listIdentifiers(DateTimeZone::ALL))->prepend('Asia/Ho_Chi_Minh')->mapWithKeys(function ($timezone) {
            return [$timezone => $timezone];
        })->all();

        $general = collect([
            Text::make('Name', 'site_name'),
            Text::make('Title', 'site_title'),
            Textarea::make('Description', 'site_description')->rows(2),
            Text::make('Keywords', 'site_keywords'),
            Text::make('Url', 'site_url')->withMeta(['extraAttributes' => ['type' => 'url']]),
            Text::make('Author', 'site_author'),
            Text::make('Version', 'site_version'),
            Text::make('Admin Email', 'admin_email')->withMeta(['extraAttributes' => ['type' => 'email']]),
            Select::make('Language', 'active_language')->options([
                'en' => 'English',
                'vi' => 'Tiếng việt',
            ])->displayUsingLabels(),
            Radio::make('Date Format', 'date_format')
                ->options([
                    'Y-m-d' => date('Y-m-d'),
                    'm/d/Y' => date('m/d/Y'),
                    'd/m/Y' => date('d/m/Y'),
                ])
                ->default('d/m/Y')
                ->stack(),
            Radio::make('Time Format', 'time_format')
                ->options([
                    'g:i a' => date('g:i a'),
                    'g:i A' => date('g:i A'),
                    'H:i' => date('H:i'),
                ])
                ->default('H:i')
                ->stack(),

            Select::make('Timezone', 'timezone')->searchable()->debounce(200)->options($timezone)
        ]);

        return $general->merge([
            new Panel(__('User'), [
                Boolean::make('Membership', 'users_can_register'),
                Text::make('New User Default Role', 'default_role'),
            ]),
        ])->all();
    }
}
