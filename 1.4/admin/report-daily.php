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
		
		$from = isset($_REQUEST["from"])?$_REQUEST["from"]:"";
		$to = isset($_REQUEST["to"])?$_REQUEST["to"]:"";
		$orderbywhat = isset($_REQUEST["orderbywhat"])?$_REQUEST["orderbywhat"]:" ";
		$direction = isset($_REQUEST["direction"])?$_REQUEST["direction"]:" ";
		$orderbystr = "";

		if(!((preg_match("/^[0-9]{1,2}\/[0-9]{1,2}\/[0-9]{4}/", $from)) && (preg_match("/^[0-9]{1,2}\/[0-9]{1,2}\/[0-9]{4}/", $to)))){
			$errormsg = "Dates are in an invalid format. Pleast try again.";
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
	<title><?php echo $settings["instance_name"]; ?> - Administration - Reports - Daily</title>
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
	<h3><a href="index.php">Administration</a> - Reports - Daily</h3>
	
	<br/><br/><strong>Daily Report for the period starting: <?php echo $from; ?> and ending: <?php echo $to; ?></strong><br/><br/>
	
	<table id="reporttable">
		<tr class="reportodd">
			<td><strong>Date</strong></td>
			<?php
				$rooms = mysql_query("SELECT * FROM rooms ORDER BY roomgroupid, roomname;");
				while($room = mysql_fetch_array($rooms)){
					$roomid_array[] = $room["roomid"];
					$roomname_array[] = $room["roomname"];
					$totals_array[] = 0;
				}
				foreach($roomname_array as $roomname){
					echo "<td><strong>". $roomname ."</strong></td>";
				}
				echo "<td><strong>Total</strong></td>";
			?>
		</tr>
				
		<?php
			$oddeven = 2;
			$fromstamp = strtotime($from);
			$tostamp = strtotime($to);
			$rowstr = "";
			$runningtotal = 0;
			while($fromstamp <= $tostamp){
				if($oddeven == 2){
					$rowstr = "reporteven";
					$oddeven = 1;
				}
				else{
					$rowstr = "reportodd";
					$oddeven = 2;
				}
				echo "<tr class=\"". $rowstr ."\"><td class=\"datecolumn\">". date("m/j/Y", $fromstamp) ."</td>";
				
				//For each room find this day's totals
				$rowtotal = 0;
				foreach($roomname_array as $key=>$roomid){
					$rescount = mysql_num_rows(mysql_query("SELECT reservationid, UNIX_TIMESTAMP(start), UNIX_TIMESTAMP(end), roomid, username, timeofrequest FROM reservations WHERE (UNIX_TIMESTAMP(start) >= ". $fromstamp ." AND UNIX_TIMESTAMP(start) < ". strtotime("+1 day", $fromstamp) .") AND roomid=". $roomid_array[$key] . $orderbystr .";"));
					echo "<td>". $rescount ."</td>";
					$totals_array[$key] += $rescount;
					$rowtotal += $rescount;
					$runningtotal += $rescount;
				}
				echo "<td>". $rowtotal ."</td></tr>";
				//Increment by one day
				$fromstamp = strtotime("+1 day", $fromstamp);
			}
			
			echo "<tr class=\"totalrow\"><td><strong>Total:</strong></td>";
			
			foreach($totals_array as $totals){
				echo "<td>". $totals ."</td>";
			}
			
			echo "<td>". $runningtotal ."</td></tr>";
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
