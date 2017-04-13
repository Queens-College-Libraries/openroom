<?php
	session_start();
	
	include("../includes/or-dbinfo.php");
	include("../includes/ClockTime.php");
	
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
		$anchorname = isset($_REQUEST["anchorname"])?$_REQUEST["anchorname"]:"";
		
		$successmsg = "";
		$errormsg = "";
		
		switch($op){
			case "deletehours":
				$roomhoursid = isset($_REQUEST["roomhoursid"])?$_REQUEST["roomhoursid"]:"";
				if(mysql_query("DELETE FROM roomhours WHERE roomhoursid=". $roomhoursid .";")){
					$successmsg = "Hours deleted.";
				}
				else{
					$errormsg = "Unable to delete these hours! Please try again.";
				}
				break;
			case "addhours":
				$shour = isset($_REQUEST["shour"])?$_REQUEST["shour"]:"";
				$sminute = isset($_REQUEST["sminute"])?$_REQUEST["sminute"]:"";
				$ehour = isset($_REQUEST["ehour"])?$_REQUEST["ehour"]:"";
				$eminute = isset($_REQUEST["eminute"])?$_REQUEST["eminute"]:"";
				$roomid = isset($_REQUEST["roomid"])?$_REQUEST["roomid"]:"";
				$wkdy = isset($_REQUEST["wkdy"])?$_REQUEST["wkdy"]:"";
				
				$starttime = new ClockTime($shour, $sminute, 0);
				$endtime = new ClockTime($ehour, $eminute, 0);
				
				//Make sure starttime is less than endtime
				if($endtime->isGreaterThan($starttime)){
					//Ensure that this new range does not conflict with existing ranges
					$allhoursr = mysql_query("SELECT * FROM roomhours WHERE roomid=". $roomid ." AND dayofweek=". $wkdy ." ORDER BY start ASC;");
					$ccflag = 0;
					while($record = mysql_fetch_array($allhoursr)){
						$tstart = new ClockTime();
						$tstart->setMySQLTime($record["start"]);
						$tend = new ClockTime();
						$tend->setMySQLTime($record["end"]);
						$ccresult = collisionCave($tstart, $tend, $starttime, $endtime);
						//acceptable results: sunmilk, ceiling, moonmilk, floor
						//if ANY other result occurs during this loop, this time is not acceptable
						if($ccresult != "sunmilk" && $ccresult != "moonmilk" && $ccresult != "ceiling" && $ccresult != "floor" && $ccflag != 1){
							$ccflag = 1;
						}
					}
					if($ccflag){
						$errormsg = "Can't add new hours as they conflict with existing hours for this room.";
					}
					else{
						//Add hours
						if(mysql_query("INSERT INTO roomhours(roomid,dayofweek,start,end) VALUES(". $roomid .",'". $wkdy ."','". $starttime->getTime() ."','". $endtime->getTime() ."');")){
							$successmsg = "New hours added!";
						}
						else{
							$errormsg = "There was a problem adding the new hours. Please try again.";
						}
					}
				}
				else{
					$errormsg = "Can't add new hours. The Start time must occur before the End time.";
				}
				
				break;
		}
		
		
		?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.1//EN" "http://www.w3.org/TR/xhtml11/DTD/xhtml11.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en" lang="en">

<head>
	<title><?php echo $settings["instance_name"]; ?> - Administration - Default Hours</title>
	<link rel="stylesheet" type="text/css" href="adminstyle.css" />
	<meta http-equiv="Content-Script-Type" content="text/javascript" />
	<script language="javascript" type="text/javascript">
		function deletehrs(roomhoursid,anchorname){
			var answer = confirm("Are you sure you would like to delete these hours?\n\nNOTE: Modifying hours will NOT delete room reservations. For special hours (such as holidays, etc.) please use the Special Hours section in administration.");
			if(answer){
				window.location = "defaulthours.php?op=deletehours&roomhoursid="+roomhoursid+"&anchorname="+anchorname;
			}
			else{
				
			}
		}
		
		function jumpToAnchor(){
			var anchorpoint = "<?php echo $anchorname; ?>";
			if(anchorpoint != ""){
				window.location = window.location + "#" + anchorpoint;
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
	<h3><a href="index.php">Administration</a> - Default Hours</h3>
	<table class="defaulthourslist">
		<?php
			$hourstr = "";
			for($hr=0;$hr<=24;$hr++){
				$hourstr .= "<option value=\"$hr\">". $hr ."</option>\n";
			}
			$minstr = "";
			for($min=0;$min<=59;$min++){
				$minstr .= "<option value=\"$min\">". $min ."</option>\n";
			}
			
			$pgroupname = "";
			$rooms = mysql_query("SELECT * FROM rooms ORDER BY roomgroupid ASC, roomposition ASC;");
			while($room = mysql_fetch_array($rooms)){
				$cgroupname = $room["roomgroupid"];
				if($pgroupname != $cgroupname){
					$roomgroupname = mysql_query("SELECT * FROM roomgroups WHERE roomgroupid=". $cgroupname .";");
					$rgn = mysql_fetch_array($roomgroupname);
					echo "<tr><td colspan=\"8\" class=\"tabletitle\">". $rgn["roomgroupname"] ."</td></tr>";
					echo "<tr><td class=\"tableheader\">Room Name</td><td class=\"tableheader\">Sunday</td><td class=\"tableheader\">Monday</td><td class=\"tableheader\">Tuesday</td><td class=\"tableheader\">Wednesday</td><td class=\"tableheader\">Thursday</td><td class=\"tableheader\">Friday</td><td class=\"tableheader\">Saturday</td></tr>";
				}
				$pgroupname = $cgroupname;
				$roomid = $room["roomid"];			
				
				echo "<tr><td><a name=\"". $room["roomname"] ."\"></a><strong>". $room["roomname"] ."</strong></td>";
				
				for($wkdy = 0;$wkdy <= 6;$wkdy++){
					echo "<td><table class=\"timeblock\">";
					$thisday = mysql_query("SELECT * FROM roomhours WHERE roomid=". $roomid ." AND dayofweek=". $wkdy ." ORDER BY start ASC;");
					while($rec = mysql_fetch_array($thisday)){
						echo "<tr><td>". substr($rec["start"],0,-3) ."-". substr($rec["end"],0,-3) ." <a href=\"javascript:deletehrs(". $rec["roomhoursid"] .",'". $room["roomname"] ."');\">x</a></td></tr>";
					}
					echo "<tr><td><hr/><span class=\"timeblocktext\"><strong>Add Hours</strong></span><br/><span class=\"timeblocktext\">Start</span><br/><form name=\"adddefaulthours\" action=\"defaulthours.php\" method=\"POST\"><input type=\"hidden\" name=\"anchorname\" value=\"". $room["roomname"] ."\" /><input type=\"hidden\" name=\"op\" value=\"addhours\" /><input type=\"hidden\" name=\"roomid\" value=\"". $roomid ."\" /><input type=\"hidden\" name=\"wkdy\" value=\"". $wkdy ."\" /><select name=\"shour\">". $hourstr ."</select>:<select name=\"sminute\">". $minstr ."</select><br/><span class=\"timeblocktext\">End</span><br/><select name=\"ehour\">". $hourstr ."</select>:<select name=\"eminute\">". $minstr ."</select><input type=\"submit\" value=\"Add\" /></form></td></tr></table>";
					echo "</td>";
				}
				
				echo "</tr>\n";
			}
		?>
	</table>
	<br/><br/>
	<?php
	}
	?>
	</div>
</body>
</html>
		<?php
	}
?>
