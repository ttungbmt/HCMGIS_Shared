<?php
namespace Larabase\Setting;

use Illuminate\Support\Facades\Facade;

class SettingFacade extends Facade
{
    protected static function getFacadeAccessor()
    {
        return 'setting';
    }
}
