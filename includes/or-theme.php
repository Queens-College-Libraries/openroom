<?php
	session_start();

	require_once("includes/or-dbinfo.php");
	require_once("Mobile_Detect.php");

	/*
	*Simply include this file and it will set SESSION["device"] appropriately.
	*This file determines the type of device through a simple detection script.
	*This information is then used along with the settings table to set the
	*correct theme path in the SESSION. If no theme is specified 
	*themes/default is used.
	*/

	$detect = new Mobile_Detect();
	if($_SESSION["device"] != "mobile" && $_SESSION["device"] != "desktop"){
		$_COOKIE["theme"] = "";
	}
	
	$_SESSION["device"] = "";

	if($detect->isAndroid() ||
		$detect->isAndroidtablet() ||
		$detect->isIphone() ||
		$detect->isIpad() ||
		$detect->isWindowsphone()
	){
		$_SESSION["device"] = "mobile";
	}else{
		$_SESSION["device"] = "desktop";
	}
	
	if($_COOKIE["theme"] == "mobile" || $_COOKIE["theme"] == "desktop"){
		$_SESSION["device"] = $_COOKIE["theme"];
	}

	if($settings["theme"] == "") $settings["theme"] = "default";

	$_SESSION["themepath"] = "themes/". $settings["theme"] ."/". $_SESSION["device"] ."/";
?>
