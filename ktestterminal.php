<?php
require_once 'vendor/autoload.php';
$my_connection = \model\Db::getInstance();
$username = generateRandomString(96);
$kus = \model\User::create()
    ->setUsername($username)
    ->setDisplayName(generateRandomString(24))
    ->setPassword(\model\User::hashPassword('hunter2'))
    ->setEmail(generateRandomString(16) . '@' . generateRandomString(8) . '.' . generateRandomString(3));
model\User::addUser($my_connection, $kus);
$users = model\User::fetchCount($my_connection);
echo PHP_EOL;
//echo 'The number of users is ' . $users;
$claimed_user = \model\User::fetchByUsername($my_connection, $kus->getUsername());
$password = $claimed_user->getPassword();
$groups = \model\Group::fetchAllOrderByIdAscending($my_connection);
var_dump($groups);
$my_connection = null;
echo PHP_EOL;
echo $password;
function generateRandomString($length = 10)
{
    $characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
    $charactersLength = strlen($characters);
    $randomString = '';
    for ($i = 0; $i < $length; $i++) {
        $randomString .= $characters[rand(0, $charactersLength - 1)];
    }
    return $randomString;
}
