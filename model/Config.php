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

// db
Config::write('db.host', '127.0.0.1');
Config::write('db.port', '3306');
Config::write('db.basename', 'spaces');
Config::write('db.user', 'music');
Config::write('db.password', '5RnXxtojcbDs19');
