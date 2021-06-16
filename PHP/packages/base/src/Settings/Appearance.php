<?php
namespace Larabase\Settings;

use Spatie\LaravelSettings\Settings;

class Appearance extends Settings
{
    public $site_logo;
    public $site_logo_light;
    public $site_favicon;
    public $admin_login_background;
    public $footer_html;
    public $primary_font;
    public $button_radius;
    public $base_color;
    public $headline_color;
    public $primary_color;
    public $secondary_color;
    public $custom_css;
    public $html_scripts_header;
    public $html_scripts_footer;
    public $html_scripts_after_body;
    public $html_scripts_before_body;
    public $social_facebook;
    public $social_twitter;
    public $social_youtube;

    public static function group(): string
    {
        return 'appearance';
    }
}
