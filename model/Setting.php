<?php

namespace model;
class Setting
{
    private $name;
    private $value;

    public function __construct($name, $value)
    {
    }

    public static function fetchValue(\PDO $db, string $settingName): string
    {
        $req = $db->prepare('SELECT value FROM settings WHERE name = :name');
        $req->execute(array('name' => $settingName));
        $setting = $req->fetch();
        return $setting['value'];
    }

    public static function update(\PDO $db, $settingname, $settingvalue): bool
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

    private function setName($inputName): Setting
    {
        $this->name = $inputName;
        return $this;
    }

    private function setValue($inputValue): Setting
    {
        $this->value = $inputValue;
        return $this;
    }
}
