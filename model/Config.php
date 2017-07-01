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
Config::write('db.host', $db["host"]);
Config::write('db.port', $db["port"]);
Config::write('db.basename', $db["path"]);
Config::write('db.user', $db["user"]);
Config::write('db.password', $db["pass"]);
