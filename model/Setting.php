<?php

namespace model;

class Setting
{
    public $name;
    public $value;

    public function __construct($name, $value)
    {
        $this->name = $name;
        $this->value = $value;
    }

    public static function all()
    {
        $list = [];
        $db = Db::getInstance();
        $req = $db->query('SELECT name, value FROM settings');
        foreach ($req->fetchAll() as $setting) {
            $list[] = new Setting($setting['name'], $setting['value']);
        }
        return $list;
    }

    public static function fetch_all()
    {
        $settings = [];
        $db = Db::getInstance();
        $q = $db->query('SELECT name, value FROM settings');
        foreach ($q->fetchAll() as $row) {
            $settings[$row['name']] = $row['value'];
        }
        return $settings;
    }

    public static function fetch($settingname)
    {
        $db = Db::getInstance();
        $req = $db->prepare('SELECT name, value FROM settings WHERE name = :name');
        $req->execute(array('name' => $settingname));
        $setting = $req->fetch();
        return new Setting($setting['name'], $setting['value']);
    }

    public static function fetchValue(\PDO $db, string $settingName): string
    {
        $req = $db->prepare('SELECT value FROM settings WHERE name = :name');
        $req->execute(array('name' => $settingName));
        $setting = $req->fetch();
        return $setting['value'];
    }

    public static function update($settingname, $settingvalue): bool
    {
        $db = Db::getInstance();
        $req = $db->prepare('UPDATE settings SET value = :value WHERE name = :name');
        $req->bindParam(':name', $settingname, \PDO::PARAM_STR);
        $req->bindParam(':value', $settingvalue, \PDO::PARAM_STR);
        $req->execute();
        return true;
    }

    public function get_value()
    {
        return $this->value;
    }
}
