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
    dropAndCreateGroups($db);
    dropAndCreateRooms($db);
    dropAndCreateReservations($db);
    dropAndCreateHours($db);
    dropAndCreateSpecialHours($db);
    dropAndCreateOptionalFields($db);
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
    $hashedPassword = \model\User::hashPassword('hunter2');
    $createTable = "CREATE TABLE {$tableName}  (
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
    $populateTable = "INSERT INTO {$tableName}  (username, password, email, is_active) VALUES ('admin', {$hashedPassword}, 'hikingfan@gmail.com', TRUE);";
    dropTable($db, $tableName);
    executeStatement($db, $createTable);
    executeStatement($db, $populateTable);
}

function dropAndCreateSettings(\PDO $db)
{
    $tableName = 'settings';
    $createTable = "CREATE TABLE {$tableName}  (
  id    SERIAL PRIMARY KEY,
  name  TEXT UNIQUE,
  value TEXT
);";
    $populateTable = "INSERT INTO {$tableName}  (name, value) VALUES 
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

function dropAndCreateGroups(\PDO $db)
{
    $tableName = 'groups';
    $createTable = "create table {$tableName}   id   SERIAL PRIMARY KEY, name TEXT NOT NULL)";
    $populateTable = "INSERT INTO {$tableName} (name) VALUES ('apple')";
    dropTable($db, $tableName);
    executeStatement($db, $createTable);
    executeStatement($db, $populateTable);
}

function dropAndCreateRooms(\PDO $db)
{
    $tableName = 'rooms';
    $createTable = "create table {$tableName} (
  id          SERIAL PRIMARY KEY,
  name        TEXT,
  position    INTEGER,
  capacity    INTEGER,
  groupid     INTEGER REFERENCES Groups (id),
  description TEXT
);";
    $populateTable = "INSERT INTO {$tableName} (name, position, capacity, groupid, description)
VALUES ('방 101', 1, 8, 9, '이것은 시험이다.')";
    dropTable($db, $tableName);
    executeStatement($db, $createTable);
    executeStatement($db, $populateTable);
}

function dropAndCreateReservations(\PDO $db)
{
    $tableName = 'reservations';
    $createTable = "create table {$tableName} (
  id                   SERIAL PRIMARY KEY,
  start_time           TIMESTAMP NOT NULL,
  end_time             TIMESTAMP NOT NULL,
  room_id              INTEGER   NOT NULL REFERENCES Rooms (id),
  user_id              INTEGER   NOT NULL REFERENCES Users (id),
  number_in_group      INTEGER   NOT NULL DEFAULT 1,
  time_of_request      TIMESTAMP NOT NULL DEFAULT (now()),
  time_of_cancellation TIMESTAMP          DEFAULT NULL
);";
    $populateTable = "INSERT INTO {$tableName} (start_time, end_time, room_id, user_id) 
VALUES ('2017-03-26 11:30:00.000000', '2017-03-26 11:55:00.000000', 1, 1);";
    dropTable($db, $tableName);
    executeStatement($db, $createTable);
    executeStatement($db, $populateTable);
}

function dropAndCreateHours(\PDO $db)
{
    $tableName = 'hours';
    $createTable = "create table {$tableName} (
  id          SERIAL PRIMARY KEY,
  room_id     INTEGER   NOT NULL REFERENCES Rooms (id),
  day_of_week SMALLINT  NOT NULL,
  start_time  TIMESTAMP NOT NULL,
  end_time    TIMESTAMP NOT NULL
);";
    $populateTable = "INSERT INTO {$tableName} (name, position, capacity, groupid, description)
VALUES ('445', 0, 8, 1, 'Room 445'), ('446', 1, 8, 1, 'Room 446'), ('503', 2, 8, 1, 'Room 503'),
  ('541', 3, 8, 1, 'Room 541'), ('1', 0, 8, 2, 'MediaScape Room 1'), ('2', 1, 8, 2, 'MediaScape Room 2'),
  ('3', 2, 8, 2, 'MediaScape Room 3');";
    dropTable($db, $tableName);
    executeStatement($db, $createTable);
    executeStatement($db, $populateTable);
}

function dropAndCreateSpecialHours(\PDO $db)
{
    $tableName = 'specialhours';
    $createTable = "create table {$tableName} (
  id         SERIAL PRIMARY KEY,
  room_id    INTEGER   NOT NULL REFERENCES Rooms (id),
  from_range TIMESTAMP NOT NULL,
  to_range   TIMESTAMP NOT NULL,
  start_time TIMESTAMP NOT NULL,
  end_time   TIMESTAMP NOT NULL
);";
    $populateTable = "INSERT INTO {$tableName} VALUES 
  (1, 1, '2016-10-10 04:00:00', '2016-10-10 04:00:00', '2017-03-26 11:30:00.000000', '2017-03-26 13:30:00.000000'),
  (2, 2, '2016-10-10 04:00:00', '2016-10-10 04:00:00', '2017-03-26 11:30:00.000000', '2017-03-26 13:30:00.000000'),
  (3, 3, '2016-10-10 04:00:00', '2016-10-10 04:00:00', '2017-03-26 11:30:00.000000', '2017-03-26 13:30:00.000000'),
  (4, 4, '2016-10-10 04:00:00', '2016-10-10 04:00:00', '2017-03-26 11:30:00.000000', '2017-03-26 13:30:00.000000'),
  (5, 5, '2016-10-10 04:00:00', '2016-10-10 04:00:00', '2017-03-26 11:30:00.000000', '2017-03-26 13:30:00.000000'),
  (6, 6, '2016-10-10 04:00:00', '2016-10-10 04:00:00', '2017-03-26 11:30:00.000000', '2017-03-26 13:30:00.000000'),
  (7, 7, '2016-10-10 04:00:00', '2016-10-10 04:00:00', '2017-03-26 11:30:00.000000', '2017-03-26 13:30:00.000000');";
    dropTable($db, $tableName);
    executeStatement($db, $createTable);
    executeStatement($db, $populateTable);
}

function dropAndCreateOptionalFields(\PDO $db)
{
    $tableName = 'optionalfields';
    $createTable = "create table {$tableName} (
  id          SERIAL PRIMARY KEY,
  name        TEXT    NOT NULL,
  form_name   TEXT    NOT NULL,
  type        TEXT    NOT NULL,
  choices     JSON    NOT NULL,
  position    INTEGER NOT NULL,
  question    TEXT    NOT NULL,
  is_private  BOOLEAN NOT NULL DEFAULT FALSE,
  is_required BOOLEAN NOT NULL DEFAULT FALSE
);";
    $populateTable = "INSERT INTO {$tableName} 
  (name, form_name, type, choices, position, question, is_private, is_required) 
  VALUES
  ('campus affiliation', 'campus affiliation form', 1, '{
    \"0\": \"Undergraduate\",
    \"1\": \"Graduate\",
    \"2\": \"Faculty / Staff\"
  }', 1,\"What is your Campus Affiliation?\", FALSE, TRUE
  );";
    $populateTable2 = "INSERT INTO {$tableName}
    (name, form_name, type, choices, position, question, is_private, is_required) VALUES
    ('random question name', 'random question form name', 1, '{
    \"0\": \"蘇步青\",
    \"1\": \"復旦大學\",
    \"2\": \"上海浦\",
    \"3\": \"也係世界跟到新加坡同香港後面嗰世界第三大貨櫃港\",
    \"4\": \"Cómo estás hoy?\"
  }', 1,
   '\"¿Cuál es su afiliación en el campus ?\"', FALSE, TRUE
  );";
    dropTable($db, $tableName);
    executeStatement($db, $createTable);
    executeStatement($db, $populateTable);
    executeStatement($db, $populateTable2);
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