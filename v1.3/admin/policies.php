<?php
	session_start();
	
	include("../includes/or-dbinfo.php");
	
	if(!(isset($_SESSION["username"])) || $_SESSION["username"] == ""){
		echo "You are not logged in. Please <a href=\"../index.php\">click here</a> and login with an account that is an authorized administrator or reporter.";
	}
	elseif($_SESSION["isadministrator"] != "TRUE"){
		echo "You must be authorized as an administrator to view this page. Please <a href=\"../index.php\">go back</a>.<br/>If you believe you received this message in error, contact an administrator.";
	}
	elseif($_SESSION["systemid"] != $settings["systemid"]){
		echo "You are not logged in. Please <a href=\"../index.php\">click here</a> and login with an account that is an authorized administrator or reporter.";
	}
	else{
		$successmsg = "";
		$errormsg = "";
		
		if(isset($_REQUEST["policies"])){
			$policies = $_REQUEST["policies"];
			
			if(mysql_query("UPDATE settings SET settingvalue='". $policies ."' WHERE settingname='policies';")){
				$successmsg = "Policies updated!";
			}
			else{
				$errormsg = "Unable to update Policies. Please try again.";
			}
		}
		$lmresult = mysql_query("SELECT * FROM settings WHERE 1;");
		while($lmrecord = mysql_fetch_array($lmresult)){
			$settings[$lmrecord["settingname"]] = $lmrecord["settingvalue"];
		}
		?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.1//EN" "http://www.w3.org/TR/xhtml11/DTD/xhtml11.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en" lang="en">

<head>
	<title><?php echo $settings["instance_name"]; ?> - Administration - Policies</title>
	<link rel="stylesheet" type="text/css" href="adminstyle.css" />
	<meta http-equiv="Content-Script-Type" content="text/javascript" />
</head>

<body onLoad="jumpToAnchor();">
	<div id="heading"><span class="username"><?php echo isset($_SESSION["username"])?"<strong>Logged in as</strong>: ". $_SESSION["username"]:"&nbsp;"; ?></span>&nbsp;<?php echo ($_SESSION["isadministrator"] == "TRUE")?"<span class=\"isadministrator\">(Admin)</span>&nbsp;":""; echo ($_SESSION["isreporter"] == "TRUE")?"<span class=\"isreporter\">(Reporter)</span>&nbsp;":""; ?>|&nbsp;<a href="../index.php">Public View</a>&nbsp;|&nbsp;<a href="../modules/logout.php">Logout</a></div>
	<div id="container">
	<center>
	<?php if($_SESSION["isadministrator"] == "TRUE"){
		if($successmsg != ""){
			echo "<div id=\"successmsg\">". $successmsg ."</div>";
		}
		if($errormsg != ""){
			echo "<div id=\"errormsg\">". $errormsg ."</div>";
		}
	?>
	</center>
	<h3><a href="index.php">Administration</a> - Policies</h3>
	<br/>
	This message will appear in emails sent to users and will appear whenever the "Policies" link is clicked.
	<form name="policies" action="policies.php" method="POST">
		<textarea cols="80" rows="30" name="policies"><?php echo $settings["policies"]; ?></textarea>
		<br/><input type="submit" value="Save Changes" />
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
