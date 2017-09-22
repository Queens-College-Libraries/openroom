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

/** @var array $db */
$db = parse_url(getenv('DATABASE_URL'));
Config::write('db.host', 'localhost');
Config::write('db.port', '5432');
Config::write('db.basename', 'openroomtesting');
Config::write('db.user', 'panda');
Config::write('db.password', 'Apple@1234');
