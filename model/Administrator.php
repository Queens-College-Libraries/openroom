<?php
declare(strict_types=1);
namespace model;
class Administrator
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
        $req = $db->query('SELECT username FROM administrators');
        foreach ($req->fetchAll() as $administrator) {
            $list[] = new Administrator($administrator['username']);
        }

        return $list;
    }

    public static function find($username)
    {
        $db = Db::getInstance();
        $req = $db->prepare('SELECT username FROM administrators WHERE username = :username');
        $req->execute(array('username' => $username));
        $administrator = $req->fetch();

        return new Administrator($administrator['username']);
    }

    public static function add($username)
    {
        if (!Administrator::exists($username)) {
            $db = Db::getInstance();
            if (isset($username) && $username != "")
            {
                $req = $db->prepare('INSERT INTO administrators(username) VALUES (:username)');
                $req->bindParam(':username', $username, \PDO::PARAM_STR, 255);
                $req->execute();
                return true;
            }
        }
        return false;
    }

    public static function exists($username)
    {
        $db = Db::getInstance();
        $req = $db->prepare('SELECT exists(SELECT username FROM administrators WHERE username = :username)');
        $req->execute(array('username' => $username));
        $administrator = $req->fetch();
        return $administrator[0];
    }

    public static function remove($username)
    {
        if (Administrator::exists($username)) {
            $db = Db::getInstance();
            $req = $db->prepare('DELETE FROM administrators WHERE username = :username');
            $req->bindParam(':username', $username, \PDO::PARAM_STR, 255);
            $req->execute();
            return true;
        }
        return false;
    }
}
