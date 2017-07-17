<?php

namespace model;
class Setting
{
    private $name;
    private $value;

    public function __construct()
    {
    }

    public static function create()
    {
        $instance = new self();
        return $instance;
    }

    public static function fetchValue(\PDO $db, string $settingName)
    {
        $req = $db->prepare('SELECT value FROM settings WHERE name = :name');
        $req->execute(array('name' => $settingName));
        $setting = $req->fetch();
        return $setting['value'];
    }

    public static function update(\PDO $db, $settingname, $settingvalue)
    {
        $req = $db->prepare('UPDATE settings SET value = :value WHERE name = :name');
        $req->bindParam(':name', $settingname, \PDO::PARAM_STR);
        $req->bindParam(':value', $settingvalue, \PDO::PARAM_STR);
        $req->execute();
        return true;
    }

    public function getName(): string
    {
        return $this->name;
    }

    public function getValue(): string
    {
        return $this->value;
    }

    public function setName($inputName): Setting
    {
        $this->name = $inputName;
        return $this;
    }

    public function setValue($inputValue): Setting
    {
        $this->value = $inputValue;
        return $this;
    }
}
