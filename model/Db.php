<?php

namespace model;
class Db
{
    private static $instance = NULL;

    private function __construct()
    {
    }

    public static function getInstance()
    {
        if (!isset(self::$instance)) {
            $options = [
                \PDO::ATTR_ERRMODE => \PDO::ERRMODE_EXCEPTION, // highly recommended
                \PDO::ATTR_EMULATE_PREPARES => false // ALWAYS! ALWAYS! ALWAYS!
            ];
            if (getenv('DATABASE_URL') != "") {
                $dsn = Db::getHerokuUrl();
                self::$instance = new \PDO($dsn);
            } else {
                $dsn = Db::getConfigUrl();
                self::$instance = new \PDO($dsn);
            }

        }
        return self::$instance;
    }

    private static function getHerokuUrl(): string
    {
        $dbstr = getenv('DATABASE_URL');
        $dbstr = substr("$dbstr", 11);
        $dbstrarruser = explode(":", $dbstr);
        $dbstrarrport = explode("/", $dbstrarruser[2]);
        $dbstrarrhost = explode("@", $dbstrarruser[1]);
        $dbpassword = $dbstrarrhost[0];
        $dbhost = $dbstrarrhost[1];
        $dbport = $dbstrarrport[0];
        $dbuser = $dbstrarruser[0];
        $dbname = $dbstrarrport[1];
        unset($dbstrarrport);
        unset($dbstrarruser);
        unset($dbstrarrhost);
        unset($dbstr);
        return "pgsql:host=" . $dbhost . ";dbname=" . $dbname . ";user=" . $dbuser . ";port=" . $dbport . ";sslmode=require;password=" . $dbpassword . ";";
    }

    private static function getConfigUrl(): string
    {
        $dbhost = Config::read('db.host');
        $dbport = Config::read('db.port');
        $dbname = Config::read('db.basename');
        $dbuser = Config::read('db.user');
        $dbpassword = Config::read('db.password');
        return "pgsql:host=" . $dbhost . ";dbname=" . $dbname . ";user=" . $dbuser . ";port=" . $dbport . ";password=" . $dbpassword . ";";
    }

    private function __clone()
    {
    }


}
