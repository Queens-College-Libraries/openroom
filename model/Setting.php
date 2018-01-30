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
        $req = $db->query('SELECT `settingname`, `settingvalue` FROM `settings`');
        foreach ($req->fetchAll() as $setting) {
            $list[] = new Setting($setting['settingname'], $setting['settingvalue']);
        }
        return $list;
    }

    public static function fetch_all()
    {
        $settings = [];
        $db = Db::getInstance();
        $q = $db->query('SELECT `settingname`, `settingvalue` FROM `settings`');
        foreach ($q->fetchAll() as $row) {
            $settings[$row['settingname']] = $row['settingvalue'];
        }
        return $settings;
    }

    public static function find($settingname)
    {
        $db = Db::getInstance();
        $req = $db->prepare('SELECT `settingname`, `settingvalue` FROM `settings` WHERE settingname = :settingname');
        $req->execute(array('settingname' => $settingname));
        $setting = $req->fetch();
        return new Setting($setting['settingname'], $setting['settingvalue']);
    }

    public static function update($settingname, $settingvalue): bool
    {
        $db = Db::getInstance();
        $req = $db->prepare('UPDATE `settings` SET `settingvalue` = :settingvalue WHERE `settingname` = :settingname');
        $req->bindParam(':settingname', $settingname, \PDO::PARAM_STR);
        $req->bindParam(':settingvalue', $settingvalue, \PDO::PARAM_STR);
        $req->execute();
        return true;
    }

    public function get_value()
    {
        return $this->value;
    }
}
