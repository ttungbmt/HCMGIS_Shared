<?php
namespace Larabase\Setting\Pages;

use Eminiarts\Tabs\Tabs;
use Laravel\Nova\Fields\Boolean;
use Laravel\Nova\Fields\Text;

class SocialLoginSetting extends Template
{
    public $settingClass = \Larabase\Settings\SocialLogin::class;

    public static $path = 'social-login';

    public static function label()
    {
        return 'Mạng xã hội';
    }

    public static function fields(){
        return [
            Boolean::make('Social Media Login', 'social_login_enable'),

            new Tabs(__('Social Media Clients'), [
                'Google' => [
                    Boolean::make('Enable', 'google_enable'),
                    Text::make('Client ID', 'google_client_id'),
                    Text::make('Client Secret', 'google_client_secret'),
                ],
                'Facebook' => [
                    Boolean::make('Enable', 'facebook_enable'),
                    Text::make('Client ID', 'facebook_client_id'),
                    Text::make('Client Secret', 'facebook_client_secret'),
                ],
                'Github' => [
                    Boolean::make('Enable', 'github_enable'),
                    Text::make('Client ID', 'github_client_id'),
                    Text::make('Client Secret', 'github_client_secret'),
                ],
                'Twitter' => [
                    Boolean::make('Enable', 'twitter_enable'),
                    Text::make('Client ID', 'twitter_client_id'),
                    Text::make('Client Secret', 'twitter_client_secret'),
                ],
            ]),
        ];
    }
}
