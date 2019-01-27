<?php 
declare(strict_types=1);
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}
require_once('vendor/autoload.php');

phpinfo();
