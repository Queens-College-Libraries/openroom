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

    if (isset($_REQUEST["starttime"])) {
        $starttime = $_REQUEST["starttime"];

        if (model\Setting::update('starttime', $starttime)) {
            $successmsg = $successmsg . "Start time updated! ";
        } else {
            $errormsg = $errormsg . "Unable to update opening time. Please try again. ";
        }
    }
    if (isset($_REQUEST["endtime"])) {
        $endtime = $_REQUEST["endtime"];

        if (model\Setting::update('endtime', $endtime)) {
            $successmsg = $successmsg . "Closing time updated! ";
        } else {
            $errormsg = $errormsg . "Unable to update closing time. Please try again. ";
        }
    }
    $settings = model\Setting::fetch_all();
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
        <h3><a href="index.php">Administration</a> - Opening and closing time</h3>
        <p>
            <strong>Settings for open and close time</strong><em> as shown by the reservation calendar. 8 represents 8
                AM; 20 represents 8 PM"</em></p>
        <form name="openhours" method="POST" action="hours.php">
            <ul>
                <li>
                    Opening time: </br />
                    <input type="range" min="0" max="23" step="1" name="starttime" style="width: 80%;"
                           value="<?php echo $settings["starttime"] ?>"
                           oninput="starttimeoutput.value = starttime.value"/>
                    <output name="starttimeoutput"><?php echo $settings["starttime"]; ?></output>
                </li>
                <br/>
                <li>
                    Closing time: <br/>
                    <input type="range" min="0" max="24" step="1" name="endtime" style="width: 80%;"
                           value="<?php echo $settings["endtime"]; ?>" oninput="endtimeoutput.value = endtime.value"/>
                    <output name="endtimeoutput"><?php echo $settings["endtime"]; ?></output>
                </li>
                <br/>
                <input type="submit" value="Update"/>
            </ul>
        </form>
        <?php
        }
        ?>
    </div>
    </body>
    </html>
    <?php
}
?>
