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
    dropAndCreateSettings($db);
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

function dropAndCreateSettings(\PDO $db)
{
    $tableName = 'settings';
    $createTable = "CREATE TABLE Settings (
  id    SERIAL PRIMARY KEY,
  name  TEXT UNIQUE,
  value TEXT
);";
    $populateTable = "INSERT INTO Settings (name, value) VALUES 
('login_method', 'normal'),
('systemid', '80zhh73n5'),
('theme', 'default'),
('policies', 'Rosenthal Library usually has several rooms available to students for group study on a ' ||
               'first-come, first-serve basis. These rooms are available to currently registered Queens College ' ||
               'students only.\r\n\r\nImmediate use of a Group Study Room is made by presenting your valid Queens ' ||
               'College ID at the Circulation Desk (located on Level 3 of the Library). If available, a room will ' ||
               'be assigned to you for one 2-hour time block. If the room is in use a hold may be placed to secure ' ||
               'the next available time slot. Room use, like book use, is assigned to your record in our automated ' ||
               'circulation system. When a room is assigned to you, you will be handed a wooden block upon which ' ||
               'the room number and policies governing Group Study Rooms is adhered. Upon completing your use of ' ||
               'the room, the wooden block is to be returned to the Circulation Desk and the assignment of the room ' ||
               'to your record will be released.\r\n\r\nShould you wish to extend the use of the room you are ' ||
               'required to return to the Circulation desk with your ID and the wooden block at the end of the 2 ' ||
               'hours. The room will then be reassigned to you provided there are no other users awaiting use of ' ||
               'the room.'),
('time_format', 'g:i a');";
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