<?php 
declare(strict_types=1);
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}
require_once('vendor/autoload.php');
include("includes/or-theme.php");
if(password_verify('eejohk3aer','$2y$10$cuOcw19BExoXTM8H3zfQtekhQoo8GKd9XDeGmY5fVusRTtAlwgqAm'))
{
    echo "good job!";
}

$data = \model\Reservation::getAllReservationsForUser(\model\Db::getInstance(), "kushal");

highlight_string("<?php\n\$data =\n" . var_export($data, true) . ";\n?>");

$starttime = strtotime($data[0]['start']);
$endtime = strtotime($data[0]['end']);

highlight_string("<?php\n\$starttime =\n" . var_export($starttime, true) . ";\n?>");
highlight_string("<?php\n\$endtime =\n" . var_export($endtime, true) . ";\n?>");

$interval = ($endtime - $starttime + 1) / 60;
highlight_string("<?php\n\$interval =\n" . var_export($interval, true) . ";\n?>");
