<?php
namespace Larabase\Setting;

class Setting
{
    public function all()
    {
        return;
    }

    public function get($key, $defaultValue = null)
    {
        [$group, $path] = explode('.', $key);

        if($this->has($key)){
            $setting = app($this->getClass($group));
            return $setting->{$path};
        }

        return $defaultValue;
    }

    /**
     * Set the setting by key and value.
     *
     * @param string $key
     * @param mixed  $value
     *
     * @return void
     */
    public function set($key, $value)
    {
//        if (strpos($key, '.') !== false) {
//            $this->setSubValue($key, $value);
//        } else {
//            $this->setByKey($key, $value);
//        }
    }

    public function getClass($group){
        return collect(config('settings.settings'))->first(fn($class) => app($class)::group() === $group);
    }

    public function has($key)
    {
        [$group, $path] = explode('.', $key);
        $settingClass = $this->getClass($group);
        return $settingClass ? property_exists($settingClass, $path) : false;
    }

    public function forget($key)
    {
//        if (strpos($key, '.') !== false) {
//            $this->forgetSubKey($key);
//        } else {
//            $this->forgetByKey($key);
//        }
//
//        $this->resetLang();
    }
}
