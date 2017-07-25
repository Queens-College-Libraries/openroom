<?php
if (trim(model\Setting::fetchValue(\model\Db::getInstance(), 'remindermessage')) != "") {
    $reminder_string = htmlentities(model\Setting::fetchValue(\model\Db::getInstance(), 'remindermessage'), ENT_COMPAT, 'UTF-8');
    echo "<div id=\"remindermessage\"><span class=\"remindermessage\">" . $reminder_string . "</span></div>";
}
