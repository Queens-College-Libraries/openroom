<?php
	require_once("../includes/or-dbinfo.php");
	//This "module" is meant to be loaded as a standalone pop-up page.
?>

<html>

<head>
	<title>Policies</title>
</head>

<body>
<center>
	<a href="javascript:window.close();">Close</a>
</center>
<h2>Policies</h2>
<?php
	$policies = mysql_fetch_array(mysql_query("SELECT * FROM settings WHERE settingname = 'policies';"));
	$policies = nl2br($policies["settingvalue"]);
	echo $policies;
?>
<br/><center>
<a href="javascript:window.close();">Close</a>
</center>
</body>
</html>
