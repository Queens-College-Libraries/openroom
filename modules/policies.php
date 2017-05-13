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
require_once(__DIR__ . '/../vendor/autoload.php');
$setting = model\Setting::fetch('policies');
$policies = nl2br($setting->get_value());
echo $policies;
?>
<br/>
<center>
    <a href="javascript:window.close();">Close</a>
</center>
</body>
</html>
