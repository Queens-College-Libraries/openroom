<?php
/**
 * Created by PhpStorm.
 * User: panda
 * Date: 7/1/17
 * Time: 1:58 PM
 */

require_once 'vendor/autoload.php';
echo '<br />';
echo 'host';
echo '<br />';
echo \model\Config::read('db.host');

echo '<hr>';

echo '<br />';
echo 'port';
echo '<br />';
echo \model\Config::read('db.port');


echo '<hr>';

echo '<br />';
echo 'path';
echo '<br />';
echo \model\Config::read('db.path');

echo '<hr>';

echo 'user';
echo '<br />';
echo \model\Config::read('db.user');

echo '<hr>';

echo '<br />';
echo '<br />';
echo \model\Config::read('db.pass');

echo '<hr>';

echo '<br />';

//$db = \model\Db::getInstance();
//$tableName = 'duck';
//$createTableDuck = "create table {$tableName} (id SERIAL PRIMARY KEY,username TEXT NOT NULL UNIQUE, display_name TEXT, password TEXT NOT NULL,email TEXT NOT NULL, last_login TIMESTAMP WITHOUT TIME ZONE NOT NULL DEFAULT (now()), is_active BOOLEAN NOT NULL DEFAULT FALSE, is_administrator BOOLEAN NOT NULL DEFAULT FALSE, is_reporter BOOLEAN NOT NULL DEFAULT FALSE, is_banned BOOLEAN NOT NULL DEFAULT FALSE)";
//$populateTableDuck = "INSERT INTO {$tableName} (username, password, email, is_active) VALUES ('admin', '', 'kushaldeveloper@gmail.com', TRUE)";
//dropTable($db, $tableName);
//executeStatement($db, $createTableDuck);
//executeStatement($db, $populateTableDuck);
//
//function dropTable(\PDO $db, string $tableName)
//{
//    $statement = "DROP TABLE IF EXISTS {$tableName}";
//    executeStatement($db, $statement);
//}
//
//function executeStatement(\PDO $db, string $statement)
//{
//    try {
//        $req = $db->prepare("{$statement}");
//        $req->execute();
//        echo "executed statement {$statement}";
//        echo "<br />";
//    } catch (PDOException $e) {
//        echo $e->getMessage();
//        die();
//    }
//}