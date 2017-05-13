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
echo preg_replace('/\v+|\\\r\\\n/','<br/>',model\Setting::fetchValue(\model\Db::getInstance(), 'policies'));
?>
<br/>
<center>
    <a href="javascript:window.close();">Close</a>
</center>
</body>
</html>
