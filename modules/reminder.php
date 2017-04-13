<?php
if ($settings["remindermessage"] != "") {
    $reminder_string = htmlentities($settings["remindermessage"], ENT_COMPAT, 'UTF-8');
    echo "<div id=\"remindermessage\"><span class=\"remindermessage\">" . $reminder_string . "</span></div>";
}
?>
