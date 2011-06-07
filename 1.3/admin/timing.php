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
			case "allowsimultaneousreservations":
				$allowsimultaneousreservations = isset($_REQUEST["allowsimultaneousreservations"])?$_REQUEST["allowsimultaneousreservations"]:"";
				if($allowsimultaneousreservations == "true" || $allowsimultaneousreservations == "false"){
					if(mysql_query("UPDATE settings SET settingvalue='". $allowsimultaneousreservations ."' WHERE settingname='allow_simultaneous_reservations';")){
						$successmsg = "Simultaneous Reservations setting has been set.";
					}
					else{
						$errormsg = "Unable to update Simultaneous Reservation setting. Please try again.";
					}
				}
				else{
					$errormsg = "Unable to update Simultaneous Reservation setting. Make sure you've made a selection and try again.";
				}
				break;
			case "allowpastreservations":
				$allowpastreservations = isset($_REQUEST["allowpastreservations"])?$_REQUEST["allowpastreservations"]:"";
				if($allowpastreservations == "true" || $allowpastreservations == "false"){
					if(mysql_query("UPDATE settings SET settingvalue='". $allowpastreservations ."' WHERE settingname='allow_past_reservations';")){
						$successmsg = "Past Reservations setting has been set.";
					}
					else{
						$errormsg = "Unable to update Past Reservation setting. Please try again.";
					}
				}
				else{
					$errormsg = "Unable to update Past Reservation setting. Make sure you've made a selection and try again.";
				}
				break;
			case "interval":
				$interval = isset($_REQUEST["interval"])?$_REQUEST["interval"]:"";
				if(preg_match("/^\\d*$/", $interval) && $interval != ""){
					if(mysql_query("UPDATE settings SET settingvalue='". $interval ."' WHERE settingname='interval';")){
						$successmsg = "Interval has been updated to ". $interval ." minutes.";
					}
					else{
						$errormsg = "Unable to update Interval. Try again.";
					}
				}
				else{
					$errormsg = "Interval can only be a number.";
				}
				break;
			case "time_format":
				$time_format = isset($_REQUEST["time_format"])?$_REQUEST["time_format"]:"";
				if($time_format != ""){
					if(mysql_query("UPDATE settings SET settingvalue='". $time_format ."' WHERE settingname='time_format';")){
						$successmsg = "Time Format changed to ". $time_format .".";
					}
					else{
						$errormsg = "Unable to set Time Format. Please try again.";
					}
				}
				else{
					$errormsg = "Unable to set Time Format. Please try again.";
				}
				break;
			case "limit_duration":
				$limit_duration = isset($_REQUEST["limit_duration"])?$_REQUEST["limit_duration"]:"";
				if(preg_match("/^\\d*$/", $limit_duration) && $limit_duration != ""){
					if(mysql_query("UPDATE settings SET settingvalue='". $limit_duration ."' WHERE settingname='limit_duration';")){
						$successmsg = "Duration Limit has been updated to ". $limit_duration ." minutes.";
					}
					else{
						$errormsg = "Unable to update Duration Limit. Try again.";
					}
				}
				else{
					$errormsg = "Duration Limit can only be a number.";
				}
				break;
			case "limit_total":
				$limit_total = isset($_REQUEST["limit_total"])?$_REQUEST["limit_total"]:"";
				$limit_total_period = isset($_REQUEST["limit_total_period"])?$_REQUEST["limit_total_period"]:"";
				if(preg_match("/^\\d*$/", $limit_total) && $limit_total != "" && $limit_total_period != ""){
					if($limit_total_period == "day" || $limit_total_period == "week" || $limit_total_period == "month" || $limit_total_period == "year"){
						$limit_total_arr = array($limit_total, $limit_total_period);
						$limit_total_arr = serialize($limit_total_arr);
						if(mysql_query("UPDATE settings SET settingvalue='". $limit_total_arr ."' WHERE settingname='limit_total';")){
							$successmsg = "Total Limit set to ". $limit_total ." minutes per ". $limit_total_period .".";
						}
						else{
							$errormsg = "Unable to set Total Limit. Please try again.";
						}
					}
					else{
						$errormsg = "Total Limit period may only be Day, Week, Month or Year.";
					}
				}
				else{
					$errormsg = "Unable to set Total Limit. Please try again.";
				}
				break;
			case "limit_frequency":
				$limit_frequency = isset($_REQUEST["limit_frequency"])?$_REQUEST["limit_frequency"]:"";
				$limit_frequency_period = isset($_REQUEST["limit_frequency_period"])?$_REQUEST["limit_frequency_period"]:"";
				if(preg_match("/^\\d*$/", $limit_frequency) && $limit_frequency != "" && $limit_frequency_period != ""){
					if($limit_frequency_period == "day" || $limit_frequency_period == "week" || $limit_frequency_period == "month" || $limit_frequency_period == "year"){
						$limit_frequency_arr = array($limit_frequency, $limit_frequency_period);
						$limit_frequency_arr = serialize($limit_frequency_arr);
						if(mysql_query("UPDATE settings SET settingvalue='". $limit_frequency_arr ."' WHERE settingname='limit_frequency';")){
							$successmsg = "Frequency Limit set to ". $limit_frequency ." reservation(s) per ". $limit_frequency_period .".";
						}
						else{
							$errormsg = "Unable to set Frequency Limit. Please try again.";
						}
					}
					else{
						$errormsg = "Frequency Limit period may only be Day, Week, Month or Year.";
					}
				}
				else{
					$errormsg = "Unable to set Frequency Limit. Please try again.";
				}
				break;
			case "limit_window":
				$limit_window_type = isset($_REQUEST["limit_window_type"])?$_REQUEST["limit_window_type"]:"";
				if($limit_window_type != ""){
					if($limit_window_type == "permanent"){
						$limit_window_date = isset($_REQUEST["limit_window_date"])?$_REQUEST["limit_window_date"]:"";
						if(preg_match("/^[0-9]{1,2}\/[0-9]{1,2}\/[0-9]{4}/", $limit_window_date) && $limit_window_date != ""){
							$limit_window_arr = array(0, $limit_window_date);
							$limit_window_arr = serialize($limit_window_arr);
							if(mysql_query("UPDATE settings SET settingvalue='". $limit_window_arr ."' WHERE settingname='limit_window';")){
								$successmsg = "Window Limit successfully changed to Permanent: ". $limit_window_date .".";
							}
							else{
								$errormsg = "Unable to set Window Limit. Please try again.";
							}
						}
						else{
							$errormsg = "For Permaent Windows, date must be in the formst mm/dd/yyyy. Please use the calendar to select a date.";
						}
					}
					elseif($limit_window_type == "sliding"){
						$limit_window_range = isset($_REQUEST["limit_window_range"])?$_REQUEST["limit_window_range"]:"";
						$limit_window_period = isset($_REQUEST["limit_window_period"])?$_REQUEST["limit_window_period"]:"";
						if(preg_match("/^\\d*$/", $limit_window_range) && $limit_window_range != "" && $limit_window_range > 0 && $limit_window_period != ""){
							if($limit_window_period == "day" || $limit_window_period == "week" || $limit_window_period == "month" || $limit_window_period == "year"){
								$limit_window_arr = array($limit_window_range, $limit_window_period);
								$limit_window_arr = serialize($limit_window_arr);
								if(mysql_query("UPDATE settings SET settingvalue='". $limit_window_arr ."' WHERE settingname='limit_window';")){
									$successmsg = "Window Limit set to Sliding: ". $limit_window_range ." ". $limit_window_period ."s.";
								}
								else{
									$errormsg = "Unable to set Window Limit. Please try again.";
								}
							}
							else{
								$errormsg = "Window Limit period may only be Day, Week, Month or Year.";
							}
						}
						else{
							$errormsg = "Unable to set Window Limit. Please try again.";
						}
					}
					else{
						$errormsg = "Unable to set Window Limit. Please try again.";
					}
				}
				else{
					$errormsg = "Unable to set Window Limit. Please try again.";
				}
				break;
			case "limit_openingday":
				$limit_openingday = isset($_REQUEST["limit_openingday"])?$_REQUEST["limit_openingday"]:"";
				if(preg_match("/^[0-9]{1,2}\/[0-9]{1,2}\/[0-9]{4}/", $limit_openingday) || $limit_openingday == ""){
					if(mysql_query("UPDATE settings SET settingvalue='". $limit_openingday ."' WHERE settingname='limit_openingday';")){
						$successmsg = "Opening Date was set successfully!";
					}
					else{
						$errormsg = "Unable to set Opening Date. Please try again.";
					}
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
	<title><?php echo $settings["instance_name"]; ?> - Administration - Timing and Limitations</title>
	<link rel="stylesheet" type="text/css" href="adminstyle.css" />
	<meta http-equiv="Content-Script-Type" content="text/javascript" />
	<script language="javascript" type="text/javascript">
		function confirmdelete(roomgroupid){
			var answer = confirm("Are you sure?");
		}
	</script>
	<script src="../includes/datechooser/date-functions.js" type="text/javascript"></script>
	<script src="../includes/datechooser/datechooser.js" type="text/javascript"></script>
	<link rel="stylesheet" type="text/css" href="../includes/datechooser/datechooser.css">
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
	?>
	</center>
	<h3><a href="index.php">Administration</a> - Timing and Limitations</h3>
	<ul id="settingsul">
		<li>
			Allow Past Reservations? - <span class="notetext">Allow reservations to be made in the past?</span>
				<ul>
					<li>
						<form name="allowpastreservations" action="timing.php" method="POST">
							<input type="hidden" name="op" value="allowpastreservations" />
							<?php
								$trueselect = "";
								$falseselect = "";
								if($settings["allow_past_reservations"] == "true"){
									$trueselect = "checked";
								}
								else{
									$falseselect = "checked";
								}
							?>
							<input type="radio" name="allowpastreservations" value="true" <?php echo $trueselect; ?>>Yes<br/>
							<input type="radio" name="allowpastreservations" value="false" <?php echo $falseselect; ?>> No<br/>
							<input type="submit" value="Save" />
						</form><br/>
					</li>
				</ul>
		</li>
		<li>
			Allow Simultaneous Reservations? - <span class="notetext">Allow two reservations for different rooms to occur at the same time for one user?</span>
				<ul>
					<li>
						<form name="allowsimultaneousreservations" action="timing.php" method="POST">
							<input type="hidden" name="op" value="allowsimultaneousreservations" />
							<?php
								$trueselect = "";
								$falseselect = "";
								if($settings["allow_simultaneous_reservations"] == "true"){
									$trueselect = "checked";
								}
								else{
									$falseselect = "checked";
								}
							?>
							<input type="radio" name="allowsimultaneousreservations" value="true" <?php echo $trueselect; ?>>Yes<br/>
							<input type="radio" name="allowsimultaneousreservations" value="false" <?php echo $falseselect; ?>> No<br/>
							<input type="submit" value="Save" />
						</form><br/>
					</li>
				</ul>
		</li>
		<li>
			Interval - <span class="notetext">The number of minutes each row represents (default: 30).</span>
				<ul>
					<li>
						<form name="interval" action="timing.php" method="POST">
							<input type="hidden" name="op" value="interval" />
							<input type="text" name="interval" value="<?php echo $settings["interval"]; ?>" />
							<input type="submit" value="Save" />
						</form><br/>
					</li>
				</ul>
		</li>
		<li>
			Time Format - <span class="notetext">Default "g:i a" will appear as "11:48 pm". See <a href="http://us.php.net/manual/en/function.date.php">PHP.net's Date() article</a> for how to format this string.</span>
				<ul>
					<li>
						<form name="time_format" action="timing.php" method="POST">
							<input type="hidden" name="op" value="time_format" />
							<input type="text" name="time_format" value="<?php echo $settings["time_format"]; ?>" /> minutes
							<input type="submit" value="Save" />
						</form><br/>
					</li>
				</ul>
		</li>
		<li>
			Duration Limit - <span class="notetext">Maximum amount of each reservation in minutes. Default: 240. Set to 0 for no limit.</span>
				<ul>
					<li>
						<form name="limit_duration" action="timing.php" method="POST">
							<input type="hidden" name="op" value="limit_duration" />
							<input type="text" name="limit_duration" value="<?php echo $settings["limit_duration"]; ?>" /> minutes
							<input type="submit" value="Save" />
						</form><br/>
					</li>
				</ul>
		</li>
		<li>
			Total Limit - <span class="notetext">Maximum amount of total reservation time in minutes per period. Default: 240/day. Set to 0 for no limit.</span>
				<ul>
					<li>
						<form name="limit_total" action="timing.php" method="POST">
							<input type="hidden" name="op" value="limit_total" />
							<?php
								$limit_total = unserialize($settings["limit_total"]);
								$daystr = "";
								$weekstr = "";
								$monthstr = "";
								$yearstr = "";
								if($limit_total[1] == "day") $daystr = "selected";
								if($limit_total[1] == "week") $weekstr = "selected";
								if($limit_total[1] == "month") $monthstr = "selected";
								if($limit_total[1] == "year") $yearstr = "selected";
							?>
							<input type="text" name="limit_total" value="<?php echo $limit_total[0]; ?>" />minutes per
							<select name="limit_total_period">
								<option value="day" <?php echo $daystr; ?>>Day</option>
								<option value="week" <?php echo $weekstr; ?>>Week</option>
								<option value="month" <?php echo $monthstr; ?>>Month</option>
								<option value="year" <?php echo $yearstr; ?>>Year</option>
							</select>
							<input type="submit" value="Save" />
						</form><br/>
					</li>
				</ul>
		</li>
		<li>
			Frequency Limit - <span class="notetext">Maximum number of reservations per period. Default: 0. Set to 0 for no limit.</span>
				<ul>
					<li>
						<form name="limit_frequency" action="timing.php" method="POST">
							<input type="hidden" name="op" value="limit_frequency" />
							<?php
								$limit_frequency = unserialize($settings["limit_frequency"]);
								$daystr = "";
								$weekstr = "";
								$monthstr = "";
								$yearstr = "";
								if($limit_frequency[1] == "day") $daystr = "selected";
								if($limit_frequency[1] == "week") $weekstr = "selected";
								if($limit_frequency[1] == "month") $monthstr = "selected";
								if($limit_frequency[1] == "year") $yearstr = "selected";
							?>
							<input type="text" name="limit_frequency" value="<?php echo $limit_frequency[0]; ?>" />reservations per
							<select name="limit_frequency_period">
								<option value="day" <?php echo $daystr; ?>>Day</option>
								<option value="week" <?php echo $weekstr; ?>>Week</option>
								<option value="month" <?php echo $monthstr; ?>>Month</option>
								<option value="year" <?php echo $yearstr; ?>>Year</option>
							</select>
							<input type="submit" value="Save" />
						</form><br/>
					</li>
				</ul>
		</li>
		<li>
			Window Limit - <span class="notetext">Allows users to make reservations only within a certain time range. This allows you to prevent users from making reservations, say, 10 years into the future, that they can't fulfill.</span>
				<ul>
					<li>
						<span class="notetext">Windows come in two forms: <strong>Permanent</strong> and <strong>Sliding</strong>.<br/>
						<strong>Permanent Windows</strong> are based on a specific date, after which reservations may no longer be made. (Example: 5/25/2025)<br/>
						<strong>Sliding Windows</strong> are based on a time period in the future, based on the current day, after which reservations may no longer be made. (Example: 6 months from today)</span>
						<form name="limit_window" action="timing.php" method="POST">
							<input type="hidden" name="op" value="limit_window" />
							<?php
								$limit_window = unserialize($settings["limit_window"]);
								$permstr = "";
								$slidstr = "";
								if($limit_window[0] == "0"){
									$permstr = "checked";
									$permval = $limit_window[1];
								}
								else{
									$slidstr = "checked";
									$slidval = $limit_window[1];
									if($slidval == "day") $daystr = "selected";
									if($slidval == "week") $weekstr = "selected";
									if($slidval == "month") $monthstr = "selected";
									if($slidval == "year") $yearstr = "selected";
								}
							?>
							<input type="radio" name="limit_window_type" value="permanent" <?php echo $permstr; ?>/>Permanent
								<ul>
									<li>
										<input id="limit_window_date" size="10" maxlength="10" name="limit_window_date" type="text" value="<?php echo $permval; ?>">
										<img src="../includes/datechooser/calendar.gif" onclick="showChooser(this, 'limit_window_date', 'chooserSpan3', 1950, 2060, Date.patterns.ShortDatePattern, false);">
										<div id="chooserSpan3" class="dateChooser select-free" style="display: none; visibility: hidden; width: 160px;"></div>
									</li>
								</ul>
							<br/>
							<input type="radio" name="limit_window_type" value="sliding" <?php echo $slidstr; ?>/>Sliding - <span class="notetext">Must be greater than 0.</span>
								<ul>
									<li>
										<input type="text" size="10" name="limit_window_range" value="<?php echo $limit_window[0]; ?>" />
										<select name="limit_window_period">
											<option value="day" <?php echo $daystr; ?>>Days</option>
											<option value="week" <?php echo $weekstr; ?>>Weeks</option>
											<option value="month" <?php echo $monthstr; ?>>Months</option>
											<option value="year" <?php echo $yearstr; ?>>Years</option>
										</select>
									</li>
								</ul>
							<br/>
							<input type="submit" value="Save" /><br/><br/>
						</form>
					</li>
				</ul>
		</li>
		<li>
			Opening Day Limit - <span class="notetext">Will not allow users to make reservations PRIOR TO the Opening Day. Default: None (leave blank)</span>
				<ul>
					<li>
						<form name="limit_openingday" action="timing.php" method="POST">
							<input type="hidden" name="op" value="limit_openingday" />
							<input id="limit_openingday" size="10" maxlength="10" name="limit_openingday" type="text" value="<?php echo $settings["limit_openingday"]; ?>">
							<img src="../includes/datechooser/calendar.gif" onclick="showChooser(this, 'limit_openingday', 'chooserSpan3', 1950, 2060, Date.patterns.ShortDatePattern, false);">
							<div id="chooserSpan3" class="dateChooser select-free" style="display: none; visibility: hidden; width: 160px;"></div>
							<br/>
							<input type="submit" value="Save" /><br/><br/>
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
	<br/><br/><br/><br/><br/><br/><br/><br/><br/><br/><br/>
</body>
</html>
		<?php
	}
?>
