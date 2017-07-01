<?php
/**
 * Created by PhpStorm.
 * User: panda
 * Date: 7/1/17
 * Time: 1:58 PM
 */

require_once 'vendor/autoload.php';

$db = \model\Db::getInstance();
$tableName = 'duck';
$createTableDuck = "create table {$tableName} (id SERIAL PRIMARY KEY,username TEXT NOT NULL UNIQUE, display_name TEXT, password TEXT NOT NULL,email TEXT NOT NULL, last_login TIMESTAMP WITHOUT TIME ZONE NOT NULL DEFAULT (now()), is_active BOOLEAN NOT NULL DEFAULT FALSE, is_administrator BOOLEAN NOT NULL DEFAULT FALSE, is_reporter BOOLEAN NOT NULL DEFAULT FALSE, is_banned BOOLEAN NOT NULL DEFAULT FALSE)";
$populateTableDuck = "INSERT INTO {$tableName} (username, password, email, is_active) VALUES ('admin', '', 'kushaldeveloper@gmail.com', TRUE)";
dropTable($db, $tableName);
executeStatement($db, $createTableDuck);
executeStatement($db, $populateTableDuck);
$ducks = fetchAllUsers($db);
highlight_string("<?php\n\$data =\n" . var_export($ducks, true) . ";\n?>");

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

function fetchAllUsers(\PDO $db): array
{
    $req = $db->prepare('SELECT username, display_name, password, email, last_login, is_active, is_administrator, is_reporter, is_banned FROM duck');
    $req->execute();
    $users = array();
    foreach ($req->fetchAll() as $user) {
        array_push($users, \model\User::create()
            ->setUsername($user['username'])
            ->setDisplayName($user['display_name'])
            ->setPassword($user['password'])
            ->setEmail($user['email'])
            ->setLastLogin($user['last_login'])
            ->setIsActive($user['is_active'])
            ->setIsAdministrator($user['is_administrator'])
            ->setIsReporter($user['is_reporter'])
            ->setIsBanned($user['is_banned']));
    }
    $req->closeCursor();
    return $users;
}