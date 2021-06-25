<?php

namespace Larabase\Setting\Pages;

use Larabase\Nova\Fields\Email;
use Larabase\Nova\Fields\Integer;
use Laravel\Nova\Fields\Number;
use Laravel\Nova\Fields\Password;
use Laravel\Nova\Fields\Select;
use Laravel\Nova\Fields\Text;

class EmailSetting extends Template
{
    public $settingClass = \Larabase\Settings\Email::class;

    public static $path = 'email';

    public static function label()
    {
        return __('Email');
    }

    public function fields(){
        return [
            Select::make('Mailer', 'email_driver')->options([
                'smtp' => 'SMTP',
                'mailgun' => 'Mailgun',
            ])->displayUsingLabels(),
            Integer::make('Port', 'email_port'),
            Text::make('Host', 'email_host'),
            Text::make('Username', 'email_username'),
            Password::make('Password', 'email_password'),
            Text::make('Encryption', 'email_encryption'),
            Text::make('Sender Name', 'email_from_name'),
            Email::make('Sender Email', 'email_from_address')->withMeta(['extraAttributes' => ['type' => 'email']]),
        ];
    }
}
