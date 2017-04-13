<?php
	require_once("includes/or-dbinfo.php");
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.1//EN" "http://www.w3.org/TR/xhtml11/DTD/xhtml11.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en" lang="en">

<head>
	<title><?php echo $settings["instance_name"]; ?></title>
	<link rel="stylesheet" type="text/css" href="<?php echo $_SESSION["themepath"]; ?>style.css" />
	<meta http-equiv="Content-Script-Type" content="text/javascript" />
</head>

<body>
<div id="heading">
	<span class="username">
	<?php
			if($_SESSION["systemid"] == $settings["systemid"]){
				echo isset($_SESSION["username"])?"<strong>Logged in as</strong>: ". $_SESSION["username"]:"&nbsp;"; ?></span>&nbsp;<?php echo ($_SESSION["isadministrator"] == "TRUE")?"<span class=\"isadministrator\">(<a href=\"admin/index.php\">Admin</a>)</span>&nbsp;":""; echo ($_SESSION["isreporter"] == "TRUE")?"<span class=\"isreporter\">(<a href=\"admin/index.php\">Reporter</a>)</span>&nbsp;":"";
				if($settings["login_method"] == "normal" && $_SESSION["username"] != ""){
					echo "|&nbsp;<a href=\"editaccount.php\">Edit Account</a>&nbsp;|";
				}
				if($_SESSION["username"] != ""){
					echo "&nbsp;<a href=\"modules/logout.php\">Logout</a>";
				}
			}
	?>
</div>
<?php include("modules/reminder.php"); ?>
<div id="container">
	<div id="leftside">
		<img src="<?php echo $_SESSION["themepath"]; ?>images/openroom09.png" alt="OpenRoom" />
		<br/>

		<?php include("modules/calendar.php"); ?>
		<br/>
		
		<?php include("modules/legend.php"); ?>
		<br/>
		
		<?php include("modules/roomdetails.php"); ?>
		
	</div>
<div id="rightside">
