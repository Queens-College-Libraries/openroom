<?php
require_once "../vendor/autoload.php";
$loader = new Twig_Loader_Filesystem(__DIR__ . "/../themes/kushal/");
$twig = new Twig_Environment($loader, array('debug' => true));
$twig->addExtension(new Twig_Extension_Debug());

if (!(isset($_SESSION["username"])) || $_SESSION["username"] == "") {
    try {
        $template = $twig->load('notLoggedIn.html');
    } catch (Twig_Error_Loader $e) {
        var_dump($e);
    } catch (Twig_Error_Runtime $e) {
        var_dump($e);
    } catch (Twig_Error_Syntax $e) {
        var_dump($e);
    }
    echo $template->render(array('title' => \model\Setting::find("instance_name")->get_value(),
        'page_title' => "Please log in"));
} elseif ($_SESSION["isadministrator"] != "TRUE") {
    try {
        $template = $twig->load('notLoggedIn.html');
    } catch (Twig_Error_Loader $e) {
        var_dump($e);
    } catch (Twig_Error_Runtime $e) {
        var_dump($e);
    } catch (Twig_Error_Syntax $e) {
        var_dump($e);
    }
    echo $template->render(array('title' => \model\Setting::find("instance_name")->get_value(),
        'page_title' => "Not authorized"));
} elseif ($_SESSION["systemid"] != $settings["systemid"]) {
    echo "You are not logged in. Please <a href=\"../index.php\">click here</a> and login with an account that is an authorized administrator or reporter.";
} else {
    try {
        $template = $twig->load('reservation.html');
    } catch (Twig_Error_Loader $e) {
        var_dump($e);
    } catch (Twig_Error_Runtime $e) {
        var_dump($e);
    } catch (Twig_Error_Syntax $e) {
        var_dump($e);
    }
    echo $template->render(array('title' => \model\Setting::find("instance_name")->get_value(),
        'page_title' => "Reservations", 'reservation' => \model\Reservation::getSpecificReservation(\model\Db::getInstance(), 324), 'reservations' => \model\Reservation::all(\model\Db::getInstance())));
}