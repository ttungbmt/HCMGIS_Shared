<?php
namespace Larabase\Settings;

use Spatie\LaravelSettings\Settings;

class Email extends Settings
{
    public $email_driver;
    public $email_port;
    public $email_host;
    public $email_username;
    public $email_password;
    public $email_encryption;
    public $email_from_name;
    public $email_from_address;

    public static function group(): string
    {
        return 'email';
    }
}
