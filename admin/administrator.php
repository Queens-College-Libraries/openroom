<?php
require_once "../vendor/autoload.php";
$loader = new Twig_Loader_Filesystem(__DIR__ . "/../themes/kushal/");

$twig = new Twig_Environment($loader, array('debug' => true));
$twig->addExtension(new Twig_Extension_Debug());
try {
    $template = $twig->load('administrator.html');
} catch (Twig_Error_Loader $e) {
    error_log("twig Error Loader error " . $e, 0);
} catch (Twig_Error_Runtime $e) {
    error_log("twig Error Runtime error " . $e, 0);
} catch (Twig_Error_Syntax $e) {
    error_log("twig Error Syntax error " . $e, 0);
}
echo $template->render(array('title' => \model\Setting::find("instance_name")->get_value(),
    'page_title' => "Administer administrators", 'administrators' => \model\Administrator::all()));