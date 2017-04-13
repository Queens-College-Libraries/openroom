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
			case "instance_name":
				$instance_name = isset($_REQUEST["instance_name"])?$_REQUEST["instance_name"]:"";
				if($instance_name != ""){
					if(mysql_query("UPDATE settings SET settingvalue='". $instance_name ."' WHERE settingname='instance_name';")){
						$successmsg = "System Name updated successfully!";
					}
					else{
						$errormsg = "Unable to update System Name. Please try again.";
					}
				}
				break;
			case "instance_url":
				$instance_url = isset($_REQUEST["instance_url"])?$_REQUEST["instance_url"]:"";
				if($instance_url != ""){
					if(mysql_query("UPDATE settings SET settingvalue='". $instance_url ."' WHERE settingname='instance_url';")){
						$successmsg = "System URL updated successfully!";
					}
					else{
						$errormsg = "Unable to update System URL. Please try again.";
					}
				}
				break;
			case "https":
				$https = isset($_REQUEST["https"])?$_REQUEST["https"]:"";
				if($https != ""){
					if(mysql_query("UPDATE settings SET settingvalue='". $https ."' WHERE settingname='https';")){
						$successmsg = "HTTPS setting updated successfully!";
					}
					else{
						$errormsg = "Unable to update HTTPS setting. Please try again.";
					}
				}
				break;
			case "email_filter":
				$email_filter = isset($_REQUEST["email_filter"])?$_REQUEST["email_filter"]:"";
				if($email_filter != ""){
					$email_filter = trim($email_filter);
					$email_filter = str_replace(" ", "", $email_filter);
					$email_filter = explode(",", $email_filter);
					$email_filter = serialize($email_filter);
					if(mysql_query("UPDATE settings SET settingvalue='". $email_filter ."' WHERE settingname='email_filter';")){
						$successmsg = "Email Filter updated successfully!";
					}
					else{
						$errormsg = "Unable to update Email Filter. Please try again.";
					}
				}
				break;
			case "ldap_baseDN":
				$ldap_baseDN = isset($_REQUEST["ldap_baseDN"])?$_REQUEST["ldap_baseDN"]:"";
				if($ldap_baseDN != ""){
					if(mysql_query("UPDATE settings SET settingvalue='". $ldap_baseDN ."' WHERE settingname='ldap_baseDN';")){
						$successmsg = "BaseDN has been set successfully.";
					}
					else{
						$errormsg = "Unable to set BaseDN. Please try again.";
					}
				}
				break;
			case "ldap_host":
				$ldap_host = isset($_REQUEST["ldap_host"])?$_REQUEST["ldap_host"]:"";
				if($ldap_host != ""){
					if(mysql_query("UPDATE settings SET settingvalue='". $ldap_host ."'WHERE settingname='ldap_host';")){
						$successmsg = "Host has been set successfully.";
					}
					else{
						$errormsg = "Unable to set Host. Please try again.";
					}
				}
				break;
			case "theme":
				$theme = isset($_REQUEST["theme"])?$_REQUEST["theme"]:"";
				if($theme != ""){
					if(mysql_query("UPDATE settings SET settingvalue='". $theme ."' WHERE settingname='theme';")){
						$successmsg = "Theme updated successfully.";
					}
					else{
						$errormsg = "Unable to update Theme. Please try again.";
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
	<title><?php echo $settings["instance_name"]; ?> - Administration - Configuration</title>
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
	?>
	</center>
	<h3><a href="index.php">Administration</a> - Configuration</h3>
	<ul id="settingsul">
		<li>
			System Name - <span class="notetext">The name of this system. Appears as the title on all screens.</span>
			<ul>
				<li>
					<form name="instance_name" action="configuration.php" method="POST">
						<input type="hidden" name="op" value="instance_name" />
						<input type="text" name="instance_name" value="<?php echo $settings["instance_name"]; ?>" />
						<input type="submit" value="Save" />
					</form><br/>
				</li>
			</ul>
		</li>
		
		<li>
			System URL - <span class="notetext">The URL users use to access this system. For example: www.bsu.edu/libraries/openroom/ (Note: please do not include protocol such as "http://")</span>
			<ul>
				<li>
					<form name="instance_url" action="configuration.php" method="POST">
						<input type="hidden" name="op" value="instance_url" />
						<input type="text" name="instance_url" value="<?php echo $settings["instance_url"]; ?>" />
						<input type="submit" value="Save" />
					</form><br/>
				</li>
			</ul>
		</li>
		
		<li>
			Security Settings
			<ul>
				<li>
					SSL/HTTPS - <span class="notetext">Setting this value to TRUE will add the https protocol where appropriate to ensure security.</span>
					<ul>
						<li>
							<form name="https" action="configuration.php" method="POST">
								<input type="hidden" name="op" value="https" />
								<?php
									$trueselected = "";
									$falseselected = "";
									if($settings["https"] == "true") $trueselected = "checked";
									if($settings["https"] == "false") $falseselected = "checked";
								?>
								<input type="radio" name="https" value="true" <?php echo $trueselected; ?>/>Yes&nbsp;<input type="radio" name="https" value="false" <?php echo $falseselected; ?>/>No&nbsp;<input type="submit" value="Save" />
							</form><br/>
						</li>
					</ul>
				</li>
				
				<li>
					Email Filter - <span class="notetext">Enter the domain names you expect your users to use when registering with an email address.</span>
					<br/>NOTE: Please separate each domain with a comma ",".
					<ul>
						<li>
						<?php
							$emailfilters = unserialize($settings["email_filter"]);
							echo "<form name=\"email_filter\" action=\"configuration.php\" method=\"POST\"><input type=\"hidden\" name=\"op\" value=\"email_filter\" /><input type=\"text\" name=\"email_filter\" value=\"";
							$count = 0;
							foreach($emailfilters as $emailfilter){
								$comma = ",";
								if($count == count($emailfilters)-1) $comma = "";
								echo $emailfilter . $comma;
								$count++;
							}
							echo "\"/> <input type=\"submit\" value=\"Save\" /></form><br/>";
						?>
						</li>
					</ul>
				</li>
			</ul>
		</li>
		
		<li>
			Login Settings
			<ul>
				<li>Login Method: <?php echo $settings["login_method"]; ?> - <span class="notetext">This setting may not be changed. It is setup during the initial installation of OpenRoom.</span>
					<?php if($settings["login_method"] == "ldap"){ ?>
					<ul>
						<li>
							<form name="ldap_baseDN" action="configuration.php" method="POST">
								<input type="hidden" name="op" value="ldap_baseDN" />
								BaseDN: <input type="text" name="ldap_baseDN" value="<?php echo $settings["ldap_baseDN"]; ?>" /> <input type="submit" value="Save" />
							</form>
						</li>
						<li>
							<form name="ldap_host" action="configuration.php" method="POST">
								<input type="hidden" name="op" value="ldap_host" />
								Host: <input type="text" name="ldap_host" value="<?php echo $settings["ldap_host"]; ?>" /> <input type="submit" value="Save" />
							</form>
						</li>
					</ul>
					<?php } ?><br/><br/>
				</li>
			</ul>
		</li>
		
		<li>
			Theme - <span class="notetext">Type the name of your theme folder here.</span>
			<ul>
				<li>
					<form name="theme">
						<input type="hidden" name="op" value="theme" />
						<input type="text" name="theme" value="<?php echo $settings["theme"]; ?>" /> <input type="submit" value="Save" />
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
