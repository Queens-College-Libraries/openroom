<?php
require_once "../vendor/autoload.php";
$loader = new Twig_Loader_Filesystem(__DIR__ . "/../themes/kushal/");

$success_message = "";
if (isset($administrator_name)) {
    if (model\Administrator::add($administrator_name)) {
        $success_message = $administrator_name . " has been added to the administrator list.";
    } else {
        if (model\Administrator::find($administrator_name)->username == $administrator_name) {
            $error_message .= "The records show that " . $administrator_name . " is already an administrator. ";
        }
        $error_message .= "Unable to add this administrator. Try again.";
    }
} else {
    $error_message = "Unable to add this administrator. Try again.";
}

$twig = new Twig_Environment($loader);
try {
    $template = $twig->load('administrator.html');
} catch (Twig_Error_Loader $e) {
    var_dump($e);
} catch (Twig_Error_Runtime $e) {
    var_dump($e);
} catch (Twig_Error_Syntax $e) {
    var_dump($e);
}
echo $template->render(array('title' => \model\Setting::find("instance_name")->get_value(),
    'page_title' => "Administrator", "error_message" => $error_message, "success_message" => $success_message));