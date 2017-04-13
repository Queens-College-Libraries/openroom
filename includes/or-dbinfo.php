<?php
/*
*or-dbinfo.php
*Contains settings and functions for connecting to MySQL.
*This file should be included in any page that requires database connectivity.
*This file also sets an array with all values from the settings table.
*/

//MySQL Database
/*
*Information used to connect to MySQL database
*$dbhost is the host name of the server with MySQL installed
*$dbuser and $dbpass are the username and password that have
*	SELECT, INSERT, UPDATE, and DELETE privileges on the openroom database
*$dbdatabase is the name of the database OpenRoom uses (default: openroom)
*/
$dbhost = "localhost";
$dbuser = "rooms";
$dbpass = "oZl4eftKZuYx4aTDGcLK2yXrLbePH6iQ3POAcVm2YPtbEMBlCwcTpn2abhpls2v";
$dbdatabase = "rooms";
//$dbhost = "localhost";
//$dbuser = "openroom";
//$dbpass = "xnNtKs804RoaohzSyUfV6xo7bPtvSJnbL9J7M9SrcWIkv3yaWfw8UhjDqMnfEqG";
//$dbdatabase = "openroom";

mysql_connect($dbhost, $dbuser, $dbpass) or die('Can\'t connect to the database. Error: ' . mysql_error());
mysql_select_db($dbdatabase) or die('Can\'t connect to the database. Error: ' . mysql_error());
require_once(__DIR__ . '/../vendor/autoload.php');
$settings = [];
$settings = model\Setting::fetch_all();

foreach ($_POST as $key => $value) {
    if (!is_array($value)) {
        $_POST[$key] = mysql_real_escape_string($value);
    } else {
        foreach ($value as $key2 => $value2) {
            $_POST[$key][$key2] = mysql_real_escape_string($value2);
        }
    }
}

foreach ($_GET as $key => $value) {
    if (!is_array($value)) {
        $_GET[$key] = mysql_real_escape_string($value);
    } else {
        foreach ($value as $key2 => $value2) {
            $_GET[$key][$key2] = mysql_real_escape_string($value2);
        }
    }
}

?>
