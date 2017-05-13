<?php
require_once 'vendor/autoload.php';
echo preg_replace('/\v+|\\\r\\\n/','<br/>',model\Setting::fetchValue(\model\Db::getInstance(), 'policies'));
