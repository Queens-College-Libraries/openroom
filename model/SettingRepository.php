<?php

namespace model;
class SettingRepository
{
    public static function fetchSetting(\PDO $db, string $settingName): \model\Setting
    {
        $req = $db->prepare('SELECT value FROM settings WHERE name = :name');
        $req->execute(array('name' => $settingName));
        $setting = $req->fetch();
        $settingValue = $setting['value'];
        return \model\Setting::create()->setName($settingName)->setValue($settingValue);
    }

    public static function updateSetting(\PDO $db, \model\Setting $setting)
    {
        $settingName = $setting->getName();
        $settingValue = $setting->getValue();
        $req = $db->prepare('UPDATE settings SET value = :value WHERE name = :name');
        $req->bindParam(':name', $settingName, \PDO::PARAM_STR);
        $req->bindParam(':value', $settingValue, \PDO::PARAM_STR);
        $req->execute();
        return true;
    }

    public static function addSetting(\PDO $db, \model\Setting $setting)
    {
        $settingName = $setting->getName();
        $settingValue = $setting->getValue();
        $req = $db->prepare('INSERT INTO settings (name, value) VALUES (:settingName, :settingValue)');
        $req->bindParam(':settingName', $settingName, \PDO::PARAM_STR, 255);
        $req->bindParam(':settingValue', $settingValue, \PDO::PARAM_STR, 255);
        $req->execute();
        $req = NULL;
    }
}