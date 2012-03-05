<?php
	session_start();
	
	include("../includes/or-dbinfo.php");
	
	if(!(isset($_SESSION["username"])) || $_SESSION["username"] == ""){
		echo "You are not logged in. Please <a href=\"../index.php\">click here</a> and login with an account that is an authorized administrator or reporter.";
	}
	elseif($_SESSION["isadministrator"] != "TRUE" && $_SESSION["isreporter"] != "TRUE"){
		echo "You must be authorized as an administrator or reporter to view this page. Please <a href=\"../index.php\">go back</a>.<br/>If you believe you received this message in error, contact an administrator.";
	}
	elseif($_SESSION["systemid"] != $settings["systemid"]){
		echo "You are not logged in. Please <a href=\"../index.php\">click here</a> and login with an account that is an authorized administrator or reporter.";
	}
	else{
				
		$successmsg = "";
		$errormsg = "";
		
		$lookupname = isset($_REQUEST["lookupname"])?$_REQUEST["lookupname"]:"";
		$orderbywhat = isset($_REQUEST["orderbywhat"])?$_REQUEST["orderbywhat"]:" ";
		$direction = isset($_REQUEST["direction"])?$_REQUEST["direction"]:" ";
		$orderbystr = "";

		if(!(preg_match("/^[A-Za-z0-9]+$/", $lookupname))){
			$errormsg = "Username is invalid!";
		}
		if(!(preg_match("/^[A-Za-z0-9]+$/", $orderbywhat))){
			$orderbywhat = " ";
		}
		else{
			$orderbystr = " ORDER BY ". $orderbywhat;
		}
		if(!(preg_match("/^[A-Za-z0-9]+$/", $direction))){
			$direction = "";
		}
		
		$orderbystr .= " ". $direction;
		
		?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.1//EN" "http://www.w3.org/TR/xhtml11/DTD/xhtml11.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en" lang="en">

<head>
	<title><?php echo $settings["instance_name"]; ?> - Administration - Reports - User Lookup</title>
	<link rel="stylesheet" type="text/css" href="adminstyle.css" />
	<meta http-equiv="Content-Script-Type" content="text/javascript" />
</head>

<body>
	<div id="heading"><span class="username"><?php echo isset($_SESSION["username"])?"<strong>Logged in as</strong>: ". $_SESSION["username"]:"&nbsp;"; ?></span>&nbsp;<?php echo ($_SESSION["isadministrator"] == "TRUE")?"<span class=\"isadministrator\">(Admin)</span>&nbsp;":""; echo ($_SESSION["isreporter"] == "TRUE")?"<span class=\"isreporter\">(Reporter)</span>&nbsp;":""; ?>|&nbsp;<a href="../index.php">Public View</a>&nbsp;|&nbsp;<a href="../modules/logout.php">Logout</a></div>
	<div id="container">
	<center>
	<?php if($_SESSION["isadministrator"] == "TRUE" || $_SESSION["isreporter"] == "TRUE"){
		if($successmsg != ""){
			echo "<div id=\"successmsg\">". $successmsg ."</div>";
		}
		if($errormsg != ""){
			echo "<div id=\"errormsg\">". $errormsg ."</div>";
		}
	?>
	</center>
	<h3><a href="index.php">Administration</a> - Reports - User Lookup</h3>
	
	<br/><br/><strong>User Lookup for: <?php echo $lookupname; ?></strong><br/><br/>
	
	<table id="reporttable">
		<tr class="reportodd">
			<td><strong>Room</strong>&nbsp;<a href="report-userlookup.php?lookupname=<?php echo $lookupname; ?>&orderbywhat=roomname&direction=ASC"><img src="images/moveup.gif" border="0" /></a><a href="report-userlookup.php?lookupname=<?php echo $lookupname; ?>&orderbywhat=roomname&direction=DESC"><img src="images/movedown.gif" border="0" /></a></td>
			<td><strong>Information</strong></td>
			<td><strong>Start Time</strong>&nbsp;<a href="report-userlookup.php?lookupname=<?php echo $lookupname; ?>&orderbywhat=start&direction=ASC"><img src="images/moveup.gif" border="0" /></a><a href="report-userlookup.php?lookupname=<?php echo $lookupname; ?>&orderbywhat=start&direction=DESC"><img src="images/movedown.gif" border="0" /></a></td>
			<td><strong>End Time</strong>&nbsp;<a href="report-userlookup.php?lookupname=<?php echo $lookupname; ?>&orderbywhat=end&direction=ASC"><img src="images/moveup.gif" border="0" /></a><a href="report-userlookup.php?lookupname=<?php echo $lookupname; ?>&orderbywhat=end&direction=DESC"><img src="images/movedown.gif" border="0" /></a></td>
			<td><strong>Number in Group</strong>&nbsp;<a href="report-userlookup.php?lookupname=<?php echo $lookupname; ?>&orderbywhat=numberingroup&direction=ASC"><img src="images/moveup.gif" border="0" /></a><a href="report-userlookup.php?lookupname=<?php echo $lookupname; ?>&orderbywhat=numberingroup&direction=DESC"><img src="images/movedown.gif" border="0" /></a></td>
			<td><strong>Time of Request</strong>&nbsp;<a href="report-userlookup.php?lookupname=<?php echo $lookupname; ?>&orderbywhat=timeofrequest&direction=ASC"><img src="images/moveup.gif" border="0" /></a><a href="report-userlookup.php?lookupname=<?php echo $lookupname; ?>&orderbywhat=timeofrequest&direction=DESC"><img src="images/movedown.gif" border="0" /></a></td>
		</tr>
		
		<?php
			$records = mysql_query("SELECT * FROM reservations,rooms WHERE reservations.username='". $lookupname ."' AND reservations.roomid = rooms.roomid". $orderbystr .";");
			$count = 2;
			while($record = mysql_fetch_array($records)){
				if($count == 2){
					echo "<tr class=\"reporteven\">";
					$count = 1;
				}
				else{
					echo "<tr class=\"reportodd\">";
					$count = 2;
				}
				echo "<td>". $record["roomname"] ."</td><td><div class=\"reportscroll\">";
				
				//Optional Fields
				$opfields = mysql_query("SELECT * FROM reservationoptions WHERE reservationid = ". $record["reservationid"] .";");
				while($opfield = mysql_fetch_array($opfields)){
					echo "<strong>". $opfield["optionname"] .": </strong>". $opfield["optionvalue"] ."<br/>";
				}
				
				echo "</div></td><td>". $record["start"] ."</td>".
				"<td>". $record["end"] ."</td>".
				"<td>". $record["numberingroup"] ."</td>".
				"<td>". $record["timeofrequest"] ."</td>".
				"</tr>";
			}
		
		?>
		
	</table>
	
	<br/>
	<?php
	}
	?>
	</div>
</body>
</html>
		<?php
	}
?>
