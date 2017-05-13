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
$db = \model\Db::getInstance();
$policies = nl2br(model\Setting::fetchValue($db, 'policies'));
echo $policies;
?>
<br/>
<center>
    <a href="javascript:window.close();">Close</a>
</center>
</body>
</html>
