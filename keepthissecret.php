<?php
/**
 * Created by PhpStorm.
 * User: panda
 * Date: 7/1/17
 * Time: 1:58 PM
 */

require_once 'vendor/autoload.php';

$db = \model\Db::getInstance();

dropTable($db, 'duck');
createTable($db, 'duck');

function dropTable(\PDO $db, string $tableName)
{
    try {
        $statement = 'drop table if exists ' . $tableName;
        $req = $db->prepare($statement);
        $req->execute();
        echo 'success dropped!';
    } catch (PDOException $e) {
        echo $e->getMessage();
        die();
    }
}

function createTable(\PDO $db, string $tableName)
{
    try {
        $req = $db->prepare('CREATE TABLE ' . $tableName . ' (id SERIAL PRIMARY KEY,username TEXT NOT NULL UNIQUE, display_name TEXT, password TEXT NOT NULL,email TEXT NOT NULL, last_login       TIMESTAMP WITHOUT TIME ZONE NOT NULL DEFAULT (now()), is_active BOOLEAN NOT NULL DEFAULT FALSE, is_administrator BOOLEAN NOT NULL DEFAULT FALSE, is_reporter BOOLEAN NOT NULL DEFAULT FALSE, is_banned BOOLEAN NOT NULL DEFAULT FALSE)');
        $req->execute();
        echo 'success created!';
    } catch (PDOException $e) {
        echo $e->getMessage();
        die();
    }
}