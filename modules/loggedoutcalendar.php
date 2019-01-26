<?php
require_once "vendor/autoload.php";
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}
$tomorrow = (new DateTime())->add(new DateInterval('P1D'));
$loader = new Twig_Loader_Filesystem(__DIR__ . "/../themes/default/desktop/");
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
        'reservations' => \model\Reservation::getAllReservationsBetween(
            \model\Db::getInstance(),
            date("Y-m-d H:i:s"),
            date_format($tomorrow,"Y-m-d H:i:s"))
    )
);