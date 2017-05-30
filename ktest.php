<?php
require_once 'vendor/autoload.php';
model\Setting::update(\model\Db::getInstance(), 'policies', 'I\'ve got values. They stack up nicely.');
echo preg_replace('/\v+|\\\r\\\n/','<br/>',model\Setting::fetchValue(\model\Db::getInstance(), 'policies'));
