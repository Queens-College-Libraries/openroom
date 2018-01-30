<?php
/*
*or-dbinfo.php
*Contains settings and functions for connecting to mysql.
*This file should be included in any page that requires database connectivity.
*This file also sets an array with all values from the settings table.
*/

//mysql Database
/*
*Information used to connect to mysql database
*$dbhost is the host name of the server with mysql installed
*$dbuser and $dbpass are the username and password that have
*	SELECT, INSERT, UPDATE, and DELETE privileges on the openroom database
*$dbdatabase is the name of the database OpenRoom uses (default: openroom)
*/
$dbhost = "localhost";
$dbuser = "openroom";
$dbpass = "change_me";
$dbdatabase = "openroom";

($GLOBALS["___mysqli_ston"] = mysqli_connect($dbhost, $dbuser, $dbpass)) or die('Can\'t connect to the database. Error: ' . mysqli_error($GLOBALS["___mysqli_ston"]));
mysqli_select_db($GLOBALS["___mysqli_ston"], $dbdatabase) or die('Can\'t connect to the database. Error: ' . mysqli_error($GLOBALS["___mysqli_ston"]));
require_once(__DIR__ . '/../vendor/autoload.php');
$settings = [];
$settings = model\Setting::fetch_all();

foreach ($_POST as $key => $value) {
    if (!is_array($value)) {
        $_POST[$key] = mysqli_real_escape_string($GLOBALS["___mysqli_ston"], $value);
    } else {
        foreach ($value as $key2 => $value2) {
            $_POST[$key][$key2] = mysqli_real_escape_string($GLOBALS["___mysqli_ston"], $value2);
        }
    }
}

foreach ($_GET as $key => $value) {
    if (!is_array($value)) {
        $_GET[$key] = mysqli_real_escape_string($GLOBALS["___mysqli_ston"], $value);
    } else {
        foreach ($value as $key2 => $value2) {
            $_GET[$key][$key2] = mysqli_real_escape_string($GLOBALS["___mysqli_ston"], $value2);
        }
    }
}

?>
