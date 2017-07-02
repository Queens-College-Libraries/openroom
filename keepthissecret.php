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
}

function dropAndCreateDuck(\PDO $db)
{
    $tableName = 'duck';
    $createTableDuck = "create table {$tableName} (id SERIAL PRIMARY KEY,username TEXT NOT NULL UNIQUE)";
    $populateTableDuck = "INSERT INTO {$tableName} (username) VALUES ('admin')";
    dropTable($db, $tableName);
    executeStatement($db, $createTableDuck);
    executeStatement($db, $populateTableDuck);
}

function dropTable(\PDO $db, string $tableName)
{
    $statement = "DROP TABLE IF EXISTS {$tableName}";
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