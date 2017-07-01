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

$dbopts = parse_url(getenv('DATABASE_URL'));
//
Config::write('db.host', $dbopts["host"]);
Config::write('db.port', $dbopts["port"]);
Config::write('db.basename', $dbopts["path"]);
Config::write('db.user', $dbopts["user"]);
Config::write('db.password', $dbopts["pass"]);
