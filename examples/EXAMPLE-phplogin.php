<?php
	$_POST["username"] = "test";
	$_POST["password"] = "test";
	$_POST["ajax_indicator"] = "FALSE";
	$test = include("../or-authenticate.php");
	$xmltest = simplexml_load_string($test);
	echo $test;
?>
