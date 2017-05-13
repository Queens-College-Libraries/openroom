<?php
require_once 'vendor/autoload.php';

function getOptionalFieldsAscending(PDO $db)
{
    $sql = "SELECT choices FROM optionalfields";
    $sth = $db->prepare($sql);
    $sth->execute();
    return $sth->fetchAll();
}

$db = \model\Db::getInstance();
$myResult = getOptionalFieldsAscending($db);
foreach ($myResult as $result) {
    echo $result[0]. PHP_EOL;
}
