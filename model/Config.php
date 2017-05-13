<?php
namespace model;
class Config
{
    static $confArray;

    public static function read($name)
    {
        return self::$confArray[$name];
    }

    public static function write($name, $value)
    {
        self::$confArray[$name] = $value;
    }

}

Config::write('db.host', 'stampy.db.elephantsql.com');
Config::write('db.port', '5432');
Config::write('db.basename', 'iiqtmcdy');
Config::write('db.user', 'iiqtmcdy');
Config::write('db.password', 'M-BHbLIXej6eNP33fg1rda6obhHG7_Iz');
