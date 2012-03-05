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
			case "email_res_verbose":
				$email_res_verbose = isset($_REQUEST["email_res_verbose"])?$_REQUEST["email_res_verbose"]:"";
				
					$email_res_verbose = trim($email_res_verbose);
					$email_res_verbose = str_replace(" ", "", $email_res_verbose);
					$email_res_verbose = explode(",", $email_res_verbose);
					$email_res_verbose = serialize($email_res_verbose);
					if(mysql_query("UPDATE settings SET settingvalue='". $email_res_verbose ."' WHERE settingname='email_res_verbose';")){
						$successmsg = "OnReservations-Verbose has been updated.";
					}
					else{
						$errormsg = "Unable to update OnReservations-Verbose. Make sure each email address is separated by a comma.";
					}
				
				break;
			case "email_res_terse":
				$email_res_terse = isset($_REQUEST["email_res_terse"])?$_REQUEST["email_res_terse"]:"";
				
					$email_res_terse = trim($email_res_terse);
					$email_res_terse = str_replace(" ", "", $email_res_terse);
					$email_res_terse = explode(",", $email_res_terse);
					$email_res_terse = serialize($email_res_terse);
					if(mysql_query("UPDATE settings SET settingvalue='". $email_res_terse ."' WHERE settingname='email_res_terse';")){
						$successmsg = "OnReservations-Terse has been updated.";
					}
					else{
						$errormsg = "Unable to update OnReservations-Terse. Make sure each email address is separated by a comma.";
					}
				
				break;
			case "email_res_gef":
				$email_res_gef = isset($_REQUEST["email_res_gef"])?$_REQUEST["email_res_gef"]:"";
				
					$email_res_gef = trim($email_res_gef);
					$email_res_gef = str_replace(" ", "", $email_res_gef);
					$email_res_gef = explode(",", $email_res_gef);
					$email_res_gef = serialize($email_res_gef);
					if(mysql_query("UPDATE settings SET settingvalue='". $email_res_gef ."' WHERE settingname='email_res_gef';")){
						$successmsg = "OnReservations-GEF has been updated.";
					}
					else{
						$errormsg = "Unable to update OnReservations-GEF. Make sure each email address is separated by a comma.";
					}
				
				break;
			case "email_can_verbose":
				$email_can_verbose = isset($_REQUEST["email_can_verbose"])?$_REQUEST["email_can_verbose"]:"";
				
					$email_can_verbose = trim($email_can_verbose);
					$email_can_verbose = str_replace(" ", "", $email_can_verbose);
					$email_can_verbose = explode(",", $email_can_verbose);
					$email_can_verbose = serialize($email_can_verbose);
					if(mysql_query("UPDATE settings SET settingvalue='". $email_can_verbose ."' WHERE settingname='email_can_verbose';")){
						$successmsg = "OnCancellation-Verbose has been updated.";
					}
					else{
						$errormsg = "Unable to update OnCancellation-Verbose. Make sure each email address is separated by a comma.";
					}
				
				break;
			case "email_can_terse":
				$email_can_terse = isset($_REQUEST["email_can_terse"])?$_REQUEST["email_can_terse"]:"";
				
					$email_can_terse = trim($email_can_terse);
					$email_can_terse = str_replace(" ", "", $email_can_terse);
					$email_can_terse = explode(",", $email_can_terse);
					$email_can_terse = serialize($email_can_terse);
					if(mysql_query("UPDATE settings SET settingvalue='". $email_can_terse ."' WHERE settingname='email_can_terse';")){
						$successmsg = "OnCancellation-Terse has been updated.";
					}
					else{
						$errormsg = "Unable to update OnCancellation-Terse. Make sure each email address is separated by a comma.";
					}
				
				break;
			case "email_can_gef":
				$email_can_gef = isset($_REQUEST["email_can_gef"])?$_REQUEST["email_can_gef"]:"";
				
					$email_can_gef = trim($email_can_gef);
					$email_can_gef = str_replace(" ", "", $email_can_gef);
					$email_can_gef = explode(",", $email_can_gef);
					$email_can_gef = serialize($email_can_gef);
					if(mysql_query("UPDATE settings SET settingvalue='". $email_can_gef ."' WHERE settingname='email_can_gef';")){
						$successmsg = "OnCancellation-GEF has been updated.";
					}
					else{
						$errormsg = "Unable to update OnCancellation-GEF. Make sure each email address is separated by a comma.";
					}
				
				break;
			case "email_system":
				$email_system = isset($_REQUEST["email_system"])?$_REQUEST["email_system"]:"";
				if($email_system != "" && preg_match('/^([a-z0-9])(([-a-z0-9._])*([a-z0-9]))*\@([a-z0-9])(([a-z0-9-])*([a-z0-9]))+' . '(\.([a-z0-9])([-a-z0-9_-])?([a-z0-9])+)+$/i', $email_system)){
					if(mysql_query("UPDATE settings SET settingvalue='". $email_system ."' WHERE settingname='email_system';")){
						$successmsg = "System Email has been updated.";
					}
					else{
						$errormsg = "Unable to set System Email. Please try again.";
					}
				}
				else{
					$errormsg = "Unable to set System Email. Make sure the format is correct.";
				}
				break;
			case "condition":
				$email_condition = isset($_REQUEST["email_condition"])?$_REQUEST["email_condition"]:"";
				$email_condition_value = isset($_REQUEST["email_condition_value"])?$_REQUEST["email_condition_value"]:"";
				if((mysql_query("UPDATE settings SET settingvalue='". $email_condition ."' WHERE settingname='email_condition';")) && (mysql_query("UPDATE settings SET settingvalue='". $email_condition_value ."' WHERE settingname='email_condition_value';"))){
					$successmsg = "Condition has been updated.";
				}
				else{
					$errormsg = "Unable to update Condition. Please try again.";
				}
				break;
			case "email_cond_verbose":
				$email_cond_verbose = isset($_REQUEST["email_cond_verbose"])?$_REQUEST["email_cond_verbose"]:"";
				$email_cond_verbose = trim($email_cond_verbose);
				$email_cond_verbose = str_replace(" ", "", $email_cond_verbose);
				$email_cond_verbose = explode(",", $email_cond_verbose);
				$email_cond_verbose = serialize($email_cond_verbose);
				if(mysql_query("UPDATE settings SET settingvalue='". $email_cond_verbose ."' WHERE settingname='email_cond_verbose';")){
					$successmsg = "OnCondition-Verbose has been updated.";
				}
				else{
					$errormsg = "Unable to update OnCondition-Verbose. Make sure each email address is separated by a comma.";
				}
				break;
			case "email_cond_terse":
				$email_cond_terse = isset($_REQUEST["email_cond_terse"])?$_REQUEST["email_cond_terse"]:"";
				$email_cond_terse = trim($email_cond_terse);
				$email_cond_terse = str_replace(" ", "", $email_cond_terse);
				$email_cond_terse = explode(",", $email_cond_terse);
				$email_cond_terse = serialize($email_cond_terse);
				if(mysql_query("UPDATE settings SET settingvalue='". $email_cond_terse ."' WHERE settingname='email_cond_terse';")){
					$successmsg = "OnCondition-Terse has been updated.";
				}
				else{
					$errormsg = "Unable to update OnCondition-Terse. Make sure each email address is separated by a comma.";
				}
				break;
			case "email_cond_gef":
				$email_cond_gef = isset($_REQUEST["email_cond_gef"])?$_REQUEST["email_cond_gef"]:"";
				$email_cond_gef = trim($email_cond_gef);
				$email_cond_gef = str_replace(" ", "", $email_cond_gef);
				$email_cond_gef = explode(",", $email_cond_gef);
				$email_cond_gef = serialize($email_cond_gef);
				if(mysql_query("UPDATE settings SET settingvalue='". $email_cond_gef ."' WHERE settingname='email_cond_gef';")){
					$successmsg = "OnCondition-GEF has been updated.";
				}
				else{
					$errormsg = "Unable to update OnCondition-GEF. Make sure each email address is separated by a comma.";
				}
				break;
		}
		
		$lmresult = mysql_query("SELECT * FROM settings WHERE 1;");
		while($lmrecord = mysql_fetch_array($lmresult)){
			$settings[$lmrecord["settingname"]] = $lmrecord["settingvalue"];
		}
		?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.1//EN" "http://www.w3.org/TR/xhtml11/DTD/xhtml11.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en" lang="en">

<head>
	<title><?php echo $settings["instance_name"]; ?> - Administration - Email Setup</title>
	<link rel="stylesheet" type="text/css" href="adminstyle.css" />
	<meta http-equiv="Content-Script-Type" content="text/javascript" />
	<script language="javascript" type="text/javascript">
		function confirmdelete(roomgroupid){
			var answer = confirm("Are you sure?");
		}
	</script>
</head>

<body>
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
		
		$email_res_verbose = implode(",", unserialize($settings["email_res_verbose"]));
		$email_res_terse = implode(",", unserialize($settings["email_res_terse"]));
		$email_res_gef = implode(",", unserialize($settings["email_res_gef"]));
		$email_can_verbose = implode(",", unserialize($settings["email_can_verbose"]));
		$email_can_terse = implode(",", unserialize($settings["email_can_terse"]));
		$email_can_gef = implode(",", unserialize($settings["email_can_gef"]));
		$email_cond_verbose = implode(",", unserialize($settings["email_cond_verbose"]));
		$email_cond_terse = implode(",", unserialize($settings["email_cond_terse"]));
		$email_cond_gef = implode(",", unserialize($settings["email_cond_gef"]));
		
	?>
	</center>
	<h3><a href="index.php">Administration</a> - Email Setup</h3><br/>
	<span class="notetext">There are three types of emails: <strong>Verbose</strong> are fully-detailed messages, <strong>Terse</strong> are stripped down to only the most important details, and <strong>GEF (Gmail Event Format)</strong> is formatted to work with Gmail Events.</span>
	<ul id="settingsul">
		<li>
			On Reservations - <span class="notetext">This email is sent whenever a reservation is made.</span>
				<ul>
					<li><form name="onreserveverbose" action="email.php" method="POST">Verbose: <input type="text" name="email_res_verbose" value="<?php echo $email_res_verbose; ?>" /><input type="hidden" name="op" value="email_res_verbose" /><input type="submit" value="Save" /></form></li>
					<li><form name="onreserveterse" action="email.php" method="POST">Terse: <input type="text" name="email_res_terse" value="<?php echo $email_res_terse; ?>" /><input type="hidden" name="op" value="email_res_terse" /><input type="submit" value="Save" /></form></li>
					<li><form name="onreservegef" action="email.php" method="POST">GEF: <input type="text" name="email_res_gef" value="<?php echo $email_res_gef; ?>" /><input type="hidden" name="op" value="email_res_gef" /><input type="submit" value="Save" /></form></li>
				</ul><br/>
		</li>
		<li>
			On Condition - <span class="notetext">This email is sent whenever certain conditions are met when reservations or cancellations are made.<br/>(*This will NOT be sent to users.)<br/>(*When dealing with Duration and Number In Group, the condition is met when the user enters a value greater than or equal to the conditional value.)</span>
				<ul>
					<li>
						<form name="oncondition" action="email.php" method="POST">When <select name="email_condition">
							<option value="">None</option>
							<option value="duration"<?php if($settings["email_condition"] == "duration") echo " selected"; ?>>Duration</option>
							<option value="capacity"<?php if($settings["email_condition"] == "capacity") echo " selected"; ?>>Number In Group</option>
							<?php
								//Grab all optional fields
								$ofselected = "";
								$ofs = mysql_query("SELECT * FROM optionalfields;");
								while($of = mysql_fetch_array($ofs)){
									if($settings["email_condition"] == $of["optionformname"]){
										$ofselected = " selected";
									}
									echo "<option value=\"". $of["optionformname"] ."\"". $ofselected .">". $of["optionname"] ."</option>";
								}
							?>
						</select> = <input type="text" name="email_condition_value" value="<?php echo $settings["email_condition_value"]; ?>" />
						<input type="hidden" name="op" value="condition" />
						<input type="submit" value="Save" /></form>
						<ul>
							<li><form name="onconditionverbose" action="email.php" method="POST">Verbose: <input type="text" name="email_cond_verbose" value="<?php echo $email_cond_verbose; ?>" /><input type="hidden" name="op" value="email_cond_verbose" /><input type="submit" value="Save" /></form></li>
							<li><form name="onconditionterse" action="email.php" method="POST">Terse: <input type="text" name="email_cond_terse" value="<?php echo $email_cond_terse; ?>" /><input type="hidden" name="op" value="email_cond_terse" /><input type="submit" value="Save" /></form></li>
							<li><form name="onconditiongef" action="email.php" method="POST">GEF: <input type="text" name="email_cond_gef" value="<?php echo $email_cond_gef; ?>" /><input type="hidden" name="op" value="email_cond_gef" /><input type="submit" value="Save" /></form></li>
						</ul>
					</li>
				</ul><br/>
		</li>
		<li>
			On Cancellations - <span class="notetext">This email is sent whenever a reservation is cancelled.</span>
				<ul>
					<li><form name="oncancelverbose" action="email.php" method="POST">Verbose: <input type="text" name="email_can_verbose" value="<?php echo $email_can_verbose; ?>" /><input type="hidden" name="op" value="email_can_verbose" /><input type="submit" value="Save" /></form></li>
					<li><form name="oncancelterse" action="email.php" method="POST">Terse: <input type="text" name="email_can_terse" value="<?php echo $email_can_terse; ?>" /><input type="hidden" name="op" value="email_can_terse" /><input type="submit" value="Save" /></form></li>
					<li><form name="oncancelgef" action="email.php" method="POST">GEF: <input type="text" name="email_can_gef" value="<?php echo $email_can_gef; ?>" /><input type="hidden" name="op" value="email_can_gef" /><input type="submit" value="Save" /></form></li>
				</ul><br/>
		</li>
		<li>
			System Address - <span class="notetext">This address is used in the "from" and "reply-to" fields. It is also the address that will be used for users to contact administrators.</span>
				<ul>
					<li>
						<form name="systemaddress" action="email.php" method="POST">
							<input type="text" name="email_system" value="<?php echo $settings["email_system"]; ?>" />
							<input type="hidden" name="op" value="email_system" />
							<input type="submit" value="Save" />
						</form>
					</li>
				</ul>
		</li>
	</ul>
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
