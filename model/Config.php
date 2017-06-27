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

Config::write('db.host', '');
Config::write('db.port', '5432');
Config::write('db.basename', '');
Config::write('db.user', '');
Config::write('db.password', '');
