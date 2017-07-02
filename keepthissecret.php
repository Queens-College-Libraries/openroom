<?php
/**
 * Created by PhpStorm.
 * User: panda
 * Date: 7/1/17
 * Time: 1:58 PM
 */
require_once 'vendor/autoload.php';
$dbstr = getenv('DATABASE_URL');
$dbstr = substr("$dbstr", 11);
$dbstrarruser = explode(":", $dbstr);
$dbstrarrport = explode("/", $dbstrarruser[2]);
$dbstrarrhost = explode("@", $dbstrarruser[1]);
$dbpassword = $dbstrarrhost[0];
$dbhost = $dbstrarrhost[1];
$dbport = $dbstrarrport[0];
$dbuser = $dbstrarruser[0];
$dbname = $dbstrarrport[1];
unset($dbstrarrport);
unset($dbstrarruser);
unset($dbstrarrhost);
unset($dbstr);
$dsn = "pgsql:host=" . $dbhost . ";dbname=" . $dbname . ";user=" . $dbuser . ";port=" . $dbport . ";sslmode=require;password=" . $dbpassword . ";";
if ($dbhost != "") {
    $db = new PDO($dsn);

} else {
    $db = \model\Db::getInstance();
}
$tableName = 'duck';
$createTableDuck = "create table {$tableName} (id SERIAL PRIMARY KEY,username TEXT NOT NULL UNIQUE, display_name TEXT, password TEXT NOT NULL,email TEXT NOT NULL, last_login TIMESTAMP WITHOUT TIME ZONE NOT NULL DEFAULT (now()), is_active BOOLEAN NOT NULL DEFAULT FALSE, is_administrator BOOLEAN NOT NULL DEFAULT FALSE, is_reporter BOOLEAN NOT NULL DEFAULT FALSE, is_banned BOOLEAN NOT NULL DEFAULT FALSE)";
$populateTableDuck = "INSERT INTO {$tableName} (username, password, email, is_active) VALUES ('admin', 'hunter2', 'kushaldeveloper@gmail.com', TRUE)";
dropTable($db, $tableName);
executeStatement($db, $createTableDuck);
executeStatement($db, $populateTableDuck);

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