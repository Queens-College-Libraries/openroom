<?php
require_once 'vendor/autoload.php';

function getOptionalFields(PDO $db)
{
    $sql = "SELECT choices FROM optionalfields";
    $sth = $db->prepare($sql);
    $sth->execute();
    return $sth->fetchAll();
}

function getSettings(PDO $db)
{
    $sql = "SELECT * FROM Settings";
    $sth = $db->prepare($sql);
    $sth->execute();
    return $sth->fetchAll();
}

$db = \model\Db::getInstance();
$myResult = getOptionalFields($db);
foreach ($myResult as $result) {
    echo $result[0]. PHP_EOL;
}
$myResult = getSettings($db);
foreach ($myResult as $result) {
    foreach($result as $resultColumn)
    {
        echo $resultColumn . PHP_EOL;
    }
}
