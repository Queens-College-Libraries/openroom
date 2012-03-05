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
			case "addadministrator":
				$adminname = isset($_REQUEST["adminname"])?$_REQUEST["adminname"]:"";
				if($adminname != ""){
					if(mysql_query("INSERT INTO administrators(username) VALUES('". $adminname ."');")){
						$successmsg = $adminname ." has been added to the adminstrator list.";
					}
					else{
						$errormsg = "Unable to add this administrator. Try again.";
					}
				}
				else{
					$errormsg = "Unable to add this administrator. Try again.";
				}
				break;
			case "deleteadministrator":
				$adminname = isset($_REQUEST["adminname"])?$_REQUEST["adminname"]:"";
				if($adminname != ""){
					if(mysql_query("DELETE FROM administrators WHERE username='". $adminname ."';")){
						$successmsg = $adminname ." has been deleted from the adminstrator list.";
					}
					else{
						$errormsg = "Unable to delete this administrator. Try again.";
					}
				}
				else{
					$errormsg = "Unable to delete this administrator. Try again.";
				}
				break;
		}
		
		
		?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.1//EN" "http://www.w3.org/TR/xhtml11/DTD/xhtml11.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en" lang="en">

<head>
	<title><?php echo $settings["instance_name"]; ?> - Administration - Administrators</title>
	<link rel="stylesheet" type="text/css" href="adminstyle.css" />
	<meta http-equiv="Content-Script-Type" content="text/javascript" />
	<script language="javascript" type="text/javascript">
		function confirmdelete(username){
			var answer = confirm("Are you sure you would like to delete this administrator?");
			if(answer){
				window.location = "administrators.php?op=deleteadministrator&adminname="+username;
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
	<h3><a href="index.php">Administration</a> - Administrators</h3>
	<ul>
		<?php
			$admina = mysql_query("SELECT * FROM administrators;");
			while($admin = mysql_fetch_array($admina)){
				echo "<li>". $admin["username"] ." <a href=\"javascript:confirmdelete('". $admin["username"] ."');\">Delete</a></li>";
			}
		?>
	</ul>
	<br/>
	<h4>Add Administrator</h4>
	<form name="addadministrator" action="administrators.php" method="POST">
		<input type="text" name="adminname" />
		<input type="hidden" name="op" value="addadministrator" />
		<input type="submit" value="Add Administrator" />
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
