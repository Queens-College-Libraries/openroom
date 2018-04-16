<?php
declare(strict_types=1);
namespace model;
// class Db
// {
//     public $dbh; // handle of the db connexion
//     private static $instance;

//     private function __construct()
//     {
//         // building data source name from config
//         $dsn = 'pgsql:host=' . Config::read('db.host') .
//                ';dbname='    . Config::read('db.basename') .
//                ';port='      . Config::read('db.port') .
//                ';connect_timeout=15';
//         // getting DB user from config                
//         $user = Config::read('db.user');
//         // getting DB password from config                
//         $password = Config::read('db.password');

//         $this->dbh = new PDO($dsn, $user, $password);
//     }

//     public static function getInstance()
//     {
//         if (!isset(self::$instance))
//         {
//             $object = __CLASS__;
//             self::$instance = new $object;
//         }
//         return self::$instance;
//     }

//     // others global functions
// }
class Db
{
    private static $instance = NULL;

    private function __construct()
    {
    }

    public static function getInstance()
    {
        if (!isset(self::$instance)) {
            $pdo_options[\PDO::ATTR_ERRMODE] = \PDO::ERRMODE_EXCEPTION;
            $dbname = 'mysql:host=' . Config::read('db.host') . ';dbname=' . Config::read('db.basename');
            self::$instance = new \PDO($dbname, Config::read('db.user'), Config::read('db.password'), $pdo_options);
        }
        return self::$instance;
    }

    private function __clone()
    {
    }
}