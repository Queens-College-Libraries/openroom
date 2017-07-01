<?php

namespace model;

class BannedUser
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
        $req = $db->query('SELECT * FROM `bannedusers`');
        foreach ($req->fetchAll() as $banneduser) {
            $list[] = new BannedUser($banneduser['username']);
        }

        return $list;
    }

    public static function find($username)
    {
        $db = Db::getInstance();
        $req = $db->prepare('SELECT * FROM `bannedusers` WHERE username = :username');
        $req->execute(array('username' => $username));
        $banneduser = $req->fetch();

        return new BannedUser($banneduser['username']);
    }

    public static function add($username)
    {
        if (!BannedUser::exists($username)) {
            $db = Db::getInstance();
            $req = $db->prepare('INSERT INTO `bannedusers`(username) VALUES (:username)');
            $req->bindParam(':username', $username, \PDO::PARAM_STR, 255);
            $req->execute();
            return true;
        }
        return false;
    }

    public static function exists($username)
    {
        $db = Db::getInstance();
        $req = $db->prepare('SELECT exists(SELECT * FROM `bannedusers` WHERE username = :username)');
        $req->execute(array('username' => $username));
        $banneduser = $req->fetch();
        $logger = new Logger(__DIR__ . '/logs');
        $logger->info('User ' . $username . ' was banned. ');
        return $banneduser[0];
    }

    public static function remove($username)
    {
        if (BannedUser::exists($username)) {
            $db = Db::getInstance();
            $req = $db->prepare('DELETE FROM `bannedusers` WHERE username = :username');
            $req->bindParam(':username', $username, \PDO::PARAM_STR, 255);
            $req->execute();
            return true;
        }
        return false;
    }
}
