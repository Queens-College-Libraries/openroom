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
		
		$op = isset($_REQUEST["op"])?$_REQUEST["op"]:"";
		
		$successmsg = "";
		$errormsg = "";
		
		switch($op){
			case "addreporter":
				$reportername = isset($_REQUEST["reportername"])?$_REQUEST["reportername"]:"";
				if($reportername != ""){
					if(mysql_query("INSERT INTO reporters(username) VALUES('". $reportername ."');")){
						$successmsg = $reportername ." has been added to the reporter list.";
					}
					else{
						$errormsg = "Unable to add this reporter. Try again.";
					}
				}
				else{
					$errormsg = "Unable to add this reporter. Try again.";
				}
				break;
			case "deletereporter":
				$reportername = isset($_REQUEST["reportername"])?$_REQUEST["reportername"]:"";
				if($reportername != ""){
					if(mysql_query("DELETE FROM reporters WHERE username='". $reportername ."';")){
						$successmsg = $reportername ." has been deleted from the reporter list.";
					}
					else{
						$errormsg = "Unable to delete this reporter. Try again.";
					}
				}
				else{
					$errormsg = "Unable to delete this reporter. Try again.";
				}
				break;
		}
		
		
		?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.1//EN" "http://www.w3.org/TR/xhtml11/DTD/xhtml11.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en" lang="en">

<head>
	<title><?php echo $settings["instance_name"]; ?> - Administration - Reporters</title>
	<link rel="stylesheet" type="text/css" href="adminstyle.css" />
	<meta http-equiv="Content-Script-Type" content="text/javascript" />
	<script language="javascript" type="text/javascript">
		function confirmdelete(username){
			var answer = confirm("Are you sure you would like to delete this reporter?");
			if(answer){
				window.location = "reporters.php?op=deletereporter&reportername="+username;
			}
			else{
				
			}
		}
	</script>
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
	<h3><a href="index.php">Administration</a> - Reporters</h3>
	<ul>
		<?php
			$reportera = mysql_query("SELECT * FROM reporters;");
			while($reporter = mysql_fetch_array($reportera)){
				echo "<li>". $reporter["username"] ." <a href=\"javascript:confirmdelete('". $reporter["username"] ."');\">Delete</a></li>";
			}
		?>
	</ul>
	<br/>
	<h4>Add Reporter</h4>
	<form name="addreporter" action="reporters.php" method="POST">
		<input type="text" name="reportername" />
		<input type="hidden" name="op" value="addreporter" />
		<input type="submit" value="Add Reporter" />
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
