<?php

class Db
{
    private static $instance = NULL;

    private function __construct()
    {
    }

    public static function getInstance()
    {
        if (!isset(self::$instance)) {
            $pdo_options[PDO::ATTR_ERRMODE] = PDO::ERRMODE_EXCEPTION;
            self::$instance = new PDO('mysql:host=localhost;dbname=openroom', 'openroom', 'change_me', $pdo_options);
        }
        return self::$instance;
    }

    private function __clone()
    {
    }
}