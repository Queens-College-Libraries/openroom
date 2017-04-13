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
			case "editgroup":
				$roomgroupname = isset($_REQUEST["roomgroupname"])?$_REQUEST["roomgroupname"]:"";
				$roomgroupid = isset($_REQUEST["roomgroupid"])?$_REQUEST["roomgroupid"]:"";
				if($roomgroupname != "" && $roomgroupid != ""){
					if(mysql_query("UPDATE roomgroups SET roomgroupname='". $roomgroupname ."' WHERE roomgroupid=". $roomgroupid .";")){
						$successmsg = "Group renamed to ". $roomgroupname ."!";
					}
					else{
						$errormsg = "Unable to edit group. Please try again.";
					}
				}
				break;
			case "deletegroup":
				//When groups are deleted, move rooms from that group into no group.
				$roomgroupid = isset($_REQUEST["roomgroupid"])?$_REQUEST["roomgroupid"]:"";
				if($roomgroupid != ""){
					$roomsingroupa = mysql_query("SELECT * FROM rooms WHERE roomgroupid=". $roomgroupid .";");
					while($roomingroup = mysql_fetch_array($roomsingroupa)){
						mysql_query("UPDATE rooms SET roomgroupid=0 WHERE roomgroupid=". $roomgroupid .";");
					}
					if(mysql_query("DELETE FROM roomgroups WHERE roomgroupid=". $roomgroupid .";")){
						$successmsg = "Group has been deleted!";
					}else{
						$errormsg = "There was a problem deleting the group. Please try again.";
					}
				}else{
					$errormsg = "There was a problem deleting the group. Please try again.";
				}			
				break;
			case "addgroup":
				$roomgroupname = isset($_REQUEST["roomgroupname"])?$_REQUEST["roomgroupname"]:"";
				if($roomgroupname != ""){
					if(mysql_query("INSERT INTO roomgroups(roomgroupname) VALUES('". $roomgroupname ."');")){
						$successmsg = "New group \"". $roomgroupname ."\" has been added!";
					}
					else{
						$errormsg = "Unable to add new group. Please try again!";
					}
				}
				break;
		}
		
		
		?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.1//EN" "http://www.w3.org/TR/xhtml11/DTD/xhtml11.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en" lang="en">

<head>
	<title><?php echo $settings["instance_name"]; ?> - Administration - Room Groups</title>
	<link rel="stylesheet" type="text/css" href="adminstyle.css" />
	<meta http-equiv="Content-Script-Type" content="text/javascript" />
	<script language="javascript" type="text/javascript">
		function confirmdelete(roomgroupid){
			var answer = confirm("Are you sure you would like to delete this group?\n\nNOTE: Deleting a group will move all rooms that were in that group out of every group. You must associate rooms with a group before they can appear on the public system!");
			if(answer){
				window.location = "roomgroups.php?op=deletegroup&roomgroupid="+roomgroupid;
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
	<h3><a href="index.php">Administration</a> - Room Groups</h3>
	<table class="roomgroupslist">
		<?php
			$groupa = mysql_query("SELECT * FROM roomgroups;");
			while($group = mysql_fetch_array($groupa)){
				echo "<tr><td><form name=\"editroomgroup\" action=\"roomgroups.php\" method=\"POST\"><input type=\"text\" name=\"roomgroupname\" value=\"". $group["roomgroupname"] ."\"/></td><td><input type=\"hidden\" name=\"roomgroupid\" value=\"". $group["roomgroupid"] ."\" /><input type=\"hidden\" name=\"op\" value=\"editgroup\" /><input type=\"submit\" value=\"Save Changes\" /></td><td><a href=\"javascript:confirmdelete(". $group["roomgroupid"] .");\">Delete</a></form></td></tr>";
			}
		?>
	</table>
	<br/>
	<h4>Add Group</h4>
	<form name="addgroup" action="roomgroups.php" method="POST">
		<input type="text" name="roomgroupname" />
		<input type="hidden" name="op" value="addgroup" />
		<input type="submit" value="Add Group" />
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
