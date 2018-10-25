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
    var_dump($e);
} catch (Twig_Error_Runtime $e) {
    var_dump($e);
} catch (Twig_Error_Syntax $e) {
    var_dump($e);
}
echo $template->render(array('title' => \model\Setting::find("instance_name")->get_value(),
        'page_title' => "Reservations",
        'reservations' => \model\Reservation::getAllReservationsSinceStartDate(
            \model\Db::getInstance(),
            date("Y-m-d H:i:s"))
//        'reservations'=> \model\Reservation::all(\model\Db::getInstance())
    )
);