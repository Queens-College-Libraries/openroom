<?php
	session_start();
	
	include("includes/or-theme.php");
	
	//Check for and enforce SSL
	if($settings["https"] == "true" && $_COOKIE["redirected"] != "true"){
		$op = isset($_GET["op"])?"?op=".$_GET["op"]:"";
		setcookie("redirected", "true");
		header("HTTP/1.1 301 Moved Permanently");
		header("Location: https://". $settings["instance_url"] . $op);
		exit();
	}
	if($_COOKIE["redirected"] == "true"){
		setcookie("redirected", "false");
	}
	
	include($_SESSION["themepath"] ."header.php");
	
	
	if(!(isset($_SESSION["username"])) || $_SESSION["username"] == ""){
		include("modules/login.php");
	}
	elseif($_SESSION["systemid"] == "" || !(isset($_SESSION["systemid"])) || $_SESSION["systemid"] != $settings["systemid"]){
		include("modules/login.php");
	}
	else{
		include($_SESSION["themepath"] ."content.php");
	}
	
	include($_SESSION["themepath"] ."footer.php");
?>
