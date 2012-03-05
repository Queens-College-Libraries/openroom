<?php
	session_start();
	
	unset($_SESSION["themepath"]);
	unset($_SESSION["username"]);
	unset($_SESSION["isadministrator"]);
	unset($_SESSION["isreporter"]);
	
	header("Location:../index.php");
?>
