<?php
require_once "../vendor/autoload.php";
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}
$loader = new Twig_Loader_Filesystem(__DIR__ . "/../themes/kushal/");
$twig = new Twig_Environment($loader, array('debug' => true));
$twig->addExtension(new Twig_Extension_Debug());

try {
    $template = $twig->load('public_reservation.html');
} catch (Twig_Error_Loader $e) {
    error_log("twig Error Loader error " . $e, 0);
} catch (Twig_Error_Runtime $e) {
    error_log("twig Error Runtime error " . $e, 0);
} catch (Twig_Error_Syntax $e) {
    error_log("twig Error Syntax error " . $e, 0);
}
echo $template->render(array('title' => \model\Setting::find("instance_name")->get_value(),
        'page_title' => "Reservations",
        'reservations' => \model\Reservation::getAllReservationsSinceStartDate(
            \model\Db::getInstance(),
            date("Y-m-d H:i:s"))
//        'reservations'=> \model\Reservation::all(\model\Db::getInstance())
    )
);