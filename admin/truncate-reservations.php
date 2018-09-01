<?php
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}
require_once(__DIR__ . '/../vendor/autoload.php');
include("../includes/or-dbinfo.php");

if (!(isset($_SESSION["username"])) || $_SESSION["username"] == "") {
    echo "You are not logged in. Please <a href=\"../index.php\">click here</a> and login with an account that is an authorized administrator or reporter.";
} elseif ($_SESSION["isadministrator"] != "TRUE") {
    echo "You must be authorized as an administrator to view this page. Please <a href=\"../index.php\">go back</a>.<br/>If you believe you received this message in error, contact an administrator.";
} elseif ($_SESSION["systemid"] != $settings["systemid"]) {
    echo "You are not logged in. Please <a href=\"../index.php\">click here</a> and login with an account that is an authorized administrator or reporter.";
} else {
    $successmsg = "";
    $errormsg = "";

    if (isset($_REQUEST["number-of-days"])) {
        $days = $_REQUEST["number-of-days"];
        $time = strtotime(date("Y-m-d H:i:s") . " - $days days");
        $truncate_before = date("Y-m-d H:i:s", $time);
        $numberOfReservationsBefore = count(\model\Reservation::all(\model\Db::getInstance()));
        $successmsg .= "Number of reservations before: " . $numberOfReservationsBefore . "<br />";
        \model\Reservation::truncate(\model\Db::getInstance(), $truncate_before);
        $numberOfReservationsAfter = count(\model\Reservation::all(\model\Db::getInstance()));
        $successmsg .= "Number of reservations after: " . $numberOfReservationsAfter . "<br />";
        if ($numberOfReservationsBefore == $numberOfReservationsAfter) {
            $errormsg .= "No change in active reservations <br />";
        }
        $numberOfCancelledReservationsBefore = count(\model\Cancelled::all(\model\Db::getInstance()));
        $successmsg .= "Number of cancelled reservations before: " . $numberOfCancelledReservationsBefore . "<br />";
        \model\Cancelled::truncate(\model\Db::getInstance(), $truncate_before);
        $numberOfCancelledReservationsAfter = count(\model\Cancelled::all(\model\Db::getInstance()));
        $successmsg .= "Number of cancelled reservations after: " . $numberOfCancelledReservationsAfter . "<br />";
        if ($numberOfCancelledReservationsBefore == $numberOfCancelledReservationsAfter) {
            $errormsg .= "No change in cancelled reservations <br />";
        }
    }
    ?>
    <!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.1//EN" "http://www.w3.org/TR/xhtml11/DTD/xhtml11.dtd">
    <html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en" lang="en">

    <head>
        <title><?php echo $settings["instance_name"]; ?> - Administration - Hours</title>
        <link rel="stylesheet" type="text/css" href="adminstyle.css"/>
        <meta http-equiv="Content-Script-Type" content="text/javascript"/>
    </head>

    <body onLoad="jumpToAnchor();">
    <div id="heading"><span
                class="username"><?php echo isset($_SESSION["username"]) ? "<strong>Logged in as</strong>: " . $_SESSION["username"] : "&nbsp;"; ?></span>&nbsp;<?php echo ($_SESSION["isadministrator"] == "TRUE") ? "<span class=\"isadministrator\">(Admin)</span>&nbsp;" : "";
        echo ($_SESSION["isreporter"] == "TRUE") ? "<span class=\"isreporter\">(Reporter)</span>&nbsp;" : ""; ?>
        |&nbsp;<a href="../index.php">Public View</a>&nbsp;|&nbsp;<a href="../modules/logout.php">Logout</a></div>
    <div id="container">
        <center>
            <?php if ($_SESSION["isadministrator"] == "TRUE"){
            if ($successmsg != "") {
                echo "<div id=\"successmsg\">" . $successmsg . "</div>";
            }
            if ($errormsg != "") {
                echo "<div id=\"errormsg\">" . $errormsg . "</div>";
            }
            ?>
        </center>
        <h3><a href="index.php">Administration</a> - Delete reservations</h3>
        <p>
            Please enter a number below.
            The number represents the number of days before today for which we want to delete records.
            There is no confirmation to delete.
            Please be sure you want to delete this data.
            Please take a look at the reservation start time in the table below:
        </p>
        <form name="truncate" method="POST" action="truncate-reservations.php">
            <label for="number-of-days">
                Delete all reservation records this many days prior to today:
            </label>
            <input type="text" value="180" name="number-of-days" id="number-of-days" placeholder="number of days">
            <input type="submit" value="Delete"/>
        </form>
        <?php
        }
        echo "Number of active reservations: "
            . count(\model\Reservation::all(\model\Db::getInstance()))
            . "<br />";
        $reservations = \model\Reservation::all(\model\Db::getInstance());
        $echoString = "Start time for reservations";
        $echoString .= "<hr>";
        echo $echoString;
        foreach ($reservations as $reservation) {
            $echoString = $reservation->getStartTime();
            $echoString .= "<hr>";
            echo $echoString;
        }
        echo "Number of cancelled reservations: "
            . count(\model\Cancelled::all(\model\Db::getInstance()))
            . "<br />";
        $cancelled_reservations = \model\Cancelled::all(\model\Db::getInstance());
        $echoString = "Start time for cancelled reservations";
        $echoString .= "<hr>";
        echo $echoString;
        foreach ($cancelled_reservations as $cancelled_reservation) {
            $echoString = $cancelled_reservation->getStartTime();
            $echoString .= "<hr>";
            echo $echoString;
        }
        ?>
    </div>
    </body>
    </html>
    <?php
}
?>
