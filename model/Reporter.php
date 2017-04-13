<?php
namespace model;
class Reporter
{
    public $username;

    public function __construct($username)
    {
        $this->username = $username;
    }

    public static function all()
    {
        $list = [];
        $db = Db::getInstance();
        $req = $db->query('SELECT * FROM `reporters`');
        foreach ($req->fetchAll() as $reporter) {
            $list[] = new Reporter($reporter['username']);
        }

        return $list;
    }

    public static function find($username)
    {
        $db = Db::getInstance();
        $req = $db->prepare('SELECT * FROM `reporters` WHERE username = :username');
        $req->execute(array('username' => $username));
        $reporter = $req->fetch();

        return new Reporter($reporter['username']);
    }

    public static function add($username)
    {
        if (!Reporter::exists($username)) {
            $db = Db::getInstance();
            $req = $db->prepare('INSERT INTO `reporters`(username) VALUES (:username)');
            $req->bindParam(':username', $username, \PDO::PARAM_STR, 255);
            $req->execute();
            return true;
        }
        return false;
    }

    public static function exists($username)
    {
        $db = Db::getInstance();
        $req = $db->prepare('SELECT exists(SELECT * FROM `reporters` WHERE username = :username)');
        $req->execute(array('username' => $username));
        $reporter = $req->fetch();
        return $reporter[0];
    }

    public static function remove($username)
    {
        if (Reporter::exists($username)) {
            $db = Db::getInstance();
            $req = $db->prepare('DELETE FROM `reporters` WHERE username = :username');
            $req->bindParam(':username', $username, \PDO::PARAM_STR, 255);
            $req->execute();
            return true;
        }
        return false;
    }
}
