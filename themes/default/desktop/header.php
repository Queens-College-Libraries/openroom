<!DOCTYPE html>
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en" lang="en">

<head>
    <title><?php echo model\Setting::fetchValue(\model\Db::getInstance(), 'instance_name'); ?></title>
    <link rel="stylesheet" type="text/css" href="<?php echo $_SESSION["themepath"]; ?>style.css"/>
    <meta http-equiv="Content-Script-Type" content="text/javascript"/>
</head>

<body>
<div id="heading">
	<span class="username">
	<?php
    if ($_SESSION["systemid"] == model\Setting::fetchValue(\model\Db::getInstance(), 'systemid')){
    if (isset($_SESSION["displayname"])) {
        echo "<strong>Logged in as</strong>: " . $_SESSION["displayname"];
    } else {
        echo "&nbsp;";
    } ?>
    </span>&nbsp;
    <?php
    if (isset($_SESSION["isadministrator"]) && $_SESSION["isadministrator"] == "TRUE") {
        echo "<span class=\"isadministrator\">(<a href=\"admin/index.php\">Admin</a>)</span>&nbsp;";
    }
    if (isset($_SESSION["isreporter"]) && $_SESSION["isreporter"] == "TRUE") {
        echo "<span class=\"isreporter\">(<a href=\"admin/index.php\">Reporter</a>)</span>&nbsp;";
    }
    if (model\Setting::fetchValue(\model\Db::getInstance(), 'login_method') == "normal" && isset($_SESSION["username"]) && $_SESSION["username"] != "") {
        echo "|&nbsp;<a href=\"editaccount.php\">Edit Account</a>&nbsp;|";
    }
    if (isset($_SESSION["username"]) && $_SESSION["username"] != "") {
        echo "&nbsp;<a href=\"modules/logout.php\">Logout</a>";
    }
    }
    ?>
</div>
<?php include("modules/reminder.php"); ?>
<div id="container">
    <div id="leftside">
        <img src="<?php echo $_SESSION["themepath"]; ?>images/openroom09.png" alt="OpenRoom"/>
        <br/>

        <?php include("modules/calendar.php"); ?>
        <br/>

        <?php include("modules/legend.php"); ?>
        <br/>

        <?php include("modules/roomdetails.php"); ?>

    </div>
    <div id="rightside">
