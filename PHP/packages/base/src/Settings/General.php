<?php
namespace Larabase\Settings;

use Spatie\LaravelSettings\Settings;

class General extends Settings
{
    public $site_name;
    public $site_title;
    public $site_keywords;
    public $site_author;
    public $site_url;
    public $site_version;
    public $admin_email;
    public $active_language;
    public $date_format;
    public $time_format;
    public $timezone;
    public $users_can_register;
    public $default_role;

    public static function group(): string
    {
        return 'general';
    }

    public function boot(){
        config([
            'app.name' => $this->site_name,
            'nova.name' => $this->site_name,
            'app.locale' => $locale = $this->active_language,
            'app.timezone' => $this->timezone,
        ]);

        app('translator')->setLocale($locale);
    }
}
