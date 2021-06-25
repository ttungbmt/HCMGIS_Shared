<?php
namespace Larabase\Setting\Pages;

use Infinety\Filemanager\FilemanagerField;
use Larabase\Nova\Fields\Code;
use Laravel\Nova\Fields\File;
use Laravel\Nova\Fields\Heading;
use Laravel\Nova\Fields\Image;
use Laravel\Nova\Fields\Text;
use Laravel\Nova\Panel;
use Timothyasp\Color\Color;

class AppearanceSetting extends Template
{
    public $settingClass = \Larabase\Settings\Appearance::class;

    public static $path = 'appearance';

    public static function label()
    {
        return 'Tùy chỉnh giao diện';
    }

    public function fields()
    {
        $general = [
            FilemanagerField::make('Logo', 'site_logo'),
            FilemanagerField::make('Logo - Light', 'site_logo_light'),
            FilemanagerField::make('Favicon', 'site_favicon'),
            FilemanagerField::make('Admin Login Background', 'admin_login_background'),
            Code::make('Footer HTML', 'footer_html')->language('php'),
        ];

        $style = [
            Text::make('Primary Font', 'primary_font'),
            Text::make('Button Radius', 'button_radius'),
            Heading::make('Color'),
            Color::make('Base Color', 'base_color')->help('Used for all normal texts.'),
            Color::make('Headline Color', 'headline_color')->help('Used for all headlines on white backgrounds. (H1, H2, H3 etc.)'),
            Color::make('Primary Color', 'primary_color'),
            Color::make('Secondary Color ', 'secondary_color'),
            Heading::make('Custom CSS'),
            Code::make('Custom CSS', 'custom_css')->language('sass'),
        ];

        $html_scripts = [
            Code::make('Header', 'html_scripts_header')->language('php'),
            Code::make('Footer', 'html_scripts_footer')->language('php'),
            Code::make('After Body', 'html_scripts_after_body')->language('php'),
            Code::make('Before Body', 'html_scripts_before_body')->language('php'),
        ];

        return [
            new Panel(__('Gereral'), $general),
//            new Panel(__('Style'), $style),
            new Panel(__('HTML Scripts'), $html_scripts),
        ];
    }
}
