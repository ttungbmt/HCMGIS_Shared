<?php
namespace Larabase\Settings;

use Spatie\LaravelSettings\Settings;

class SocialLogin extends Settings
{
    public $social_login_enable;
    public $google_enable;
    public $google_client_id;
    public $google_client_secret;
    public $facebook_enable;
    public $facebook_client_id;
    public $facebook_client_secret;
    public $github_enable;
    public $github_client_id;
    public $github_client_secret;
    public $twitter_enable;
    public $twitter_client_id;
    public $twitter_client_secret;

    public static function group(): string
    {
        return 'social_login';
    }
}
