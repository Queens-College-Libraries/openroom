<?php
/**
 * Created by PhpStorm.
 * User: panda
 * Date: 7/1/17
 * Time: 1:58 PM
 */
require_once 'vendor/autoload.php';

$db = \model\Db::getInstance();

doIt($db);

function doIt(\PDO $db)
{
    dropAndCreateDuck($db);
    dropAndCreateUsers($db);
}

function dropAndCreateDuck(\PDO $db)
{
    $tableName = 'duck';
    $createTable = "create table {$tableName} (id SERIAL PRIMARY KEY,username TEXT NOT NULL UNIQUE)";
    $populateTable = "INSERT INTO {$tableName} (username) VALUES ('admin')";
    dropTable($db, $tableName);
    executeStatement($db, $createTable);
    executeStatement($db, $populateTable);
}

function dropAndCreateUsers(\PDO $db)
{
    $tableName = 'users';
    $createTable = "CREATE TABLE Users (
  id               SERIAL PRIMARY KEY,
  username         TEXT                        NOT NULL UNIQUE,
  display_name     TEXT,
  password         TEXT                        NOT NULL,
  email            TEXT                        NOT NULL,
  last_login       TIMESTAMP WITHOUT TIME ZONE NOT NULL DEFAULT (now()),
  is_active        BOOLEAN                     NOT NULL DEFAULT FALSE,
  is_administrator BOOLEAN                     NOT NULL DEFAULT FALSE,
  is_reporter      BOOLEAN                     NOT NULL DEFAULT FALSE,
  is_banned        BOOLEAN                     NOT NULL DEFAULT FALSE
);";
    $populateTable = "INSERT INTO Users (username, password, email, is_active) VALUES ('admin', 'hunter2', 'hikingfan@gmail.com', TRUE);";
    dropTable($db, $tableName);
    executeStatement($db, $createTable);
    executeStatement($db, $populateTable);
}

function dropTable(\PDO $db, string $tableName)
{
    $statement = "DROP TABLE IF EXISTS {$tableName} CASCADE";
    executeStatement($db, $statement);
}

function executeStatement(\PDO $db, string $statement)
{
    try {
        $req = $db->prepare("{$statement}");
        $req->execute();
        echo "executed statement {$statement}";
        echo "<br />";
    } catch (PDOException $e) {
        echo $e->getMessage();
        die();
    }
}