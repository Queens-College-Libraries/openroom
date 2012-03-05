<?php

include("configuration.php");
include("includes/or-dbinfo.php");

$successmsg = "";
$errormsg = "";

//$admin_user = "admin";
if($admin_user != ""){
	if(mysql_query("INSERT INTO administrators VALUES('". $admin_user ."');")){
		$successmsg .= "Administrative user ". $admin_user ." added!<br/><br/>";
	}else{
		$errormsg .= "Unable to add Administrative user.<br/><br/>";
	}
}else{
	$errormsg .= "Unable to add Administrative user.<br/><br/>";
}

//$instance_name = "OpenRoom";
if($instance_name != "" && $errormsg == ""){
	if(mysql_query("UPDATE settings SET settingvalue='". $instance_name ."' WHERE settingname = 'instance_name';")){
		$successmsg .= "Instance Name set to ". $instance_name ."!<br/><br/>";
	}else{
		$errormsg .= "Unable to set Instance Name.<br/><br/>";
	}
}else{
	$errormsg .= "Unable to set Instance Name.<br/><br/>";
}

//$instance_url = "www.example.com/openroom/";
if($instance_url != "" && $errormsg == ""){
	if(mysql_query("UPDATE settings SET settingvalue='". $instance_url ."' WHERE settingname = 'instance_url';")){
		$successmsg .= "Instance URL set to ". $instance_url ."!<br/><br/>";
	}else{
		$errormsg .= "Unable to set Instance URL.<br/><br/>";
	}
}else{
	$errormsg .= "Unable to set Instance URL.<br/><br/>";
}

//$theme = "default";
if($theme != "" && $errormsg == ""){
	if(mysql_query("UPDATE settings SET settingvalue='". $theme ."' WHERE settingname = 'theme';")){
		$successmsg .= "Theme set to ". $theme ."!<br/><br/>";
	}else{
		$errormsg .= "Unable to set Theme.<br/><br/>";
	}
}else{
	$errormsg .= "Unable to set Theme.<br/><br/>";
}

//$https = "true";
if($https != "" && $errormsg == ""){
	if(mysql_query("UPDATE settings SET settingvalue='". $https ."' WHERE settingname = 'https';")){
		$successmsg .= "SSL set to ". $https ."!<br/><br/>";
	}else{
		$errormsg .= "Unable to set SSL.<br/><br/>";
	}
}else{
	$errormsg .= "Unable to set SSL.<br/><br/>";
}

//$login_method = "ldap";
if($login_method != "" && $errormsg == ""){
	if(mysql_query("UPDATE settings SET settingvalue='". $login_method ."' WHERE settingname = 'login_method';")){
		$successmsg .= "Login Method set to ". $login_method ."!<br/><br/>";
	}else{
		$errormsg .= "Unable to set Login Method.<br/><br/>";
	}
}else{
	$errormsg .= "Unable to set Login Method.<br/><br/>";
}

//$ldap_host = "ldap.bsu.edu";
//$ldap_baseDN = "cn=users,dc=bsu,dc=edu";
if($login_method == "ldap" && $errormsg == ""){
	if($ldap_host != "" && $ldap_baseDN != "" && $errormsg == ""){
		if(mysql_query("UPDATE settings SET settingvalue='". $ldap_host ."' WHERE settingname = 'ldap_host';")){
			$successmsg .= "LDAP Host set to ". $ldap_host ."!<br/><br/>";
		}else{
			$errormsg .= "Unable to set LDAP Host.<br/><br/>";
		}
		if(mysql_query("UPDATE settings SET settingvalue='". $ldap_baseDN ."' WHERE settingname = 'ldap_baseDN';")){
			$successmsg .= "LDAP baseDN set to ". $ldap_baseDN ."!<br/><br/>";
		}else{
			$errormsg .= "Unable to set LDAP baseDN.<br/><br/>";
		}
	}else{
		$errormsg .= "Unable to set LDAP settings.<br/><br/>";
	}
}else{
	$successmsg .= "LDAP settings not specified.<br/><br/>";
}

//$email_filter = array("bsu.edu");
if($email_filter != "" && $errormsg == ""){
	$email_filter = serialize($email_filter);
	if(mysql_query("UPDATE settings SET settingvalue='". $email_filter ."' WHERE settingname = 'email_filter';")){
		$successmsg .= "Email Filter set!<br/><br/>";
	}else{
		$errormsg .= "Unable to set Email Filter.<br/><br/>";
	}
}else{
	$successmsg .= "Email Filter not specified.<br/><br/>";
}

//$interval = 30;
if($interval != "" && $errormsg == ""){
	if(mysql_query("UPDATE settings SET settingvalue='". $interval ."' WHERE settingname = 'interval';")){
		$successmsg .= "Interval set to ". $interval ."!<br/><br/>";
	}else{
		$errormsg .= "Unable to set Interval.<br/><br/>";
	}
}else{
	$errormsg .= "Unable to set Interval.<br/><br/>";
}

//$time_format = "g:i a";
if($time_format != "" && $errormsg == ""){
	if(mysql_query("UPDATE settings SET settingvalue='". $time_format ."' WHERE settingname = 'time_format';")){
		$successmsg .= "Time Format set!<br/><br/>";
	}else{
		$errormsg .= "Unable to set Time Format.<br/><br/>";
	}
}else{
	$errormsg .= "Unable to set Time Format.<br/><br/>";
}

//$limit_duration = 240;
if($limit_duration != "" && $errormsg == ""){
	if(mysql_query("UPDATE settings SET settingvalue='". $limit_duration ."' WHERE settingname = 'limit_duration';")){
		$successmsg .= "Limit Duration set!<br/><br/>";
	}else{
		$errormsg .= "Unable to set Limit Duration.<br/><br/>";
	}
}else{
	$errormsg .= "Unable to set Limit Duration.<br/><br/>";
}

//$limit_total = array(240,"day");
if($limit_total != "" && $errormsg == ""){
	$limit_total = serialize($limit_total);
	if(mysql_query("UPDATE settings SET settingvalue='". $limit_total ."' WHERE settingname = 'limit_total';")){
		$successmsg .= "Limit Total set!<br/><br/>";
	}else{
		$errormsg .= "Unable to set Limit Total.<br/><br/>";
	}
}else{
	$errormsg .= "Unable to set Limit Total.<br/><br/>";
}

//$limit_frequency = array(0,"day");
if($limit_frequency != "" && $errormsg == ""){
	$limit_frequency = serialize($limit_frequency);
	if(mysql_query("UPDATE settings SET settingvalue='". $limit_frequency ."' WHERE settingname = 'limit_frequency';")){
		$successmsg .= "Limit Frequency set!<br/><br/>";
	}else{
		$errormsg .= "Unable to set Limit Frequency.<br/><br/>";
	}
}else{
	$errormsg .= "Unable to set Limit Frequency.<br/><br/>";
}

//$limit_window = array(6,"month");
if($limit_window != "" && $errormsg == ""){
	$limit_window = serialize($limit_window);
	if(mysql_query("UPDATE settings SET settingvalue='". $limit_window ."' WHERE settingname = 'limit_window';")){
		$successmsg .= "Limit Window set!<br/><br/>";
	}else{
		$errormsg .= "Unable to set Limit Window.<br/><br/>";
	}
}else{
	$errormsg .= "Unable to set Limit Window.<br/><br/>";
}

//Set random 10-character systemid
$random_array = array("1","2","3","4","5","6","7","8","9","0","a","b","","c","d","e","f","g","h","i","j","k","l","m","n","o","p","q","r","s","t","u","v","w","x","y", "z");
$systemid = "";
for($i=0;$i<10;$i++){
	$systemid = $systemid . $random_array[rand(0, count($random_array))];
}
if(mysql_query("UPDATE settings SET settingvalue='". $systemid ."' WHERE settingname = 'systemid';")){
	$successmsg .= "System ID set!<br/><br/>";	
}else{
	$errormsg .= "Unable to set System ID.<br/><br/>";
}

?>

<html>
<head>
	<title>Installing...</title>
</head>
<body>
<h3>Installing OpenRoom...</h3>
<?php 
	if($successmsg != "") echo "<div style=\"background-color: #aaffaa;\">". $successmsg ."</div>";
	if($errormsg != "") echo "<div style=\"background-color: #ffaaaa;\">". $errormsg ."</div>";
?>
</body>
</html>
