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
Config::write('db.basename', 'openroom');
Config::write('db.user', 'openroomdemo');
Config::write('db.password', '53PVs7nj2i2AD5FXNLNpZyW3B3sG31WGPThmPCntdldKwxZ5vvb3Pg266HSN8NG');
