<?php
declare(strict_types=1);
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}
require_once('vendor/autoload.php');
include("includes/or-theme.php");
if (isset($_COOKIE["redirected"]) && $_COOKIE["redirected"] == "true") {
    setcookie("redirected", "false");
}

include($_SESSION["themepath"] . "header.php");


if (!(isset($_SESSION["username"])) || $_SESSION["username"] == "") {
    include("modules/login.php");
    include("modules/loggedoutcalendar.php");
} elseif ($_SESSION["systemid"] == "" || !(isset($_SESSION["systemid"])) || $_SESSION["systemid"] != $settings["systemid"]) {
    include("modules/login.php");
} else {
    include($_SESSION["themepath"] . "content.php");
}

include($_SESSION["themepath"] . "footer.php");