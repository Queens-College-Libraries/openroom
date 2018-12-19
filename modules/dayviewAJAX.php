<?php
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}
require_once("../includes/ClockTime.php");
require_once("../includes/or-dbinfo.php");
//If $_POST["fromrange"] and/or $_POST["torange"] aren't set, or manually set to 0, set them to today
//Whether they're set or not, make sure they are from 00:00:00 on the fromrange day and to 23:59:59 on the torange day so all reservations for the day appear
$_POST["fromrange"] = (isset($_POST["fromrange"]) && $_POST["fromrange"] != 0) ? mktime(0, 0, 0, date("n", $_POST["fromrange"]), date("j", $_POST["fromrange"]), date("Y", $_POST["fromrange"])) : mktime(0, 0, 0, date("n"), date("j"), date("Y"));
$_POST["torange"] = (isset($_POST["torange"]) && $_POST["torange"] != 0) ? mktime(23, 59, 59, date("n", $_POST["torange"]), date("j", $_POST["torange"]), date("Y", $_POST["torange"])) : mktime(23, 59, 59, date("n"), date("j"), date("Y"));
$_POST["group"] = (isset($_POST["group"])) ? $_POST["group"] : "";
if ($_POST["group"] == "") {
    $groups = mysqli_query($GLOBALS["___mysqli_ston"], "SELECT * FROM roomgroups ORDER BY roomgroupid ASC;");
    $group = mysqli_fetch_array($groups);
    $_POST["group"] = $group["roomgroupid"];
}
//Pull reservations and room information from XML API
$getdatarange = include("../or-getdatarange.php");
$getroominfo = include("../or-getroominfo.php");
$xmlreservations = new SimpleXMLElement($getdatarange);
$xmlroominfo = new SimpleXMLElement($getroominfo);
$current_time = new ClockTime((int)\model\Setting::find("starttime")->get_value(), 0, 0 ?? 8, 0, 0);
$last_time = new ClockTime((int)\model\Setting::find("endtime")->get_value(), 0, 0 ?? 23, 59, 59);
$currentweekday = strtolower(date('l', $_POST["fromrange"]));
$currentmdy = date('l, F d, Y', $_POST["fromrange"]);
if ($_SESSION["username"] != "") {
    //Get all groups from DB to create Group Selector
    $groups = mysqli_query($GLOBALS["___mysqli_ston"], "SELECT * FROM roomgroups ORDER BY roomgroupid ASC;");
    /*$group_str = "<select id=\"groupselector\" onchange=\"dayviewer('". $_POST["fromrange"] ."','". $_POST["torange"] ."',this.value,'');\">";
    while($group = mysql_fetch_array($groups)){
        $selected_str = "";
        if($group["roomgroupid"] == $_POST["group"]) $selected_str = "selected";
        $group_str .= "<option value=\"". $group["roomgroupid"] ."\" ". $selected_str .">". $group["roomgroupname"] ."</option>";
    }
    $group_str .= "</select>";*/
    $group_str = "<table><tr>";
    while ($group = mysqli_fetch_array($groups)) {
        $selected_str = "class=\"grouptab\"";
        if ($group["roomgroupid"] == $_POST["group"]) $selected_str = "class=\"selected\"";
        $group_str .= "<td onClick=\"dayviewer('" . $_POST["fromrange"] . "','" . $_POST["torange"] . "','" . $group["roomgroupid"] . "','');\" " . $selected_str . ">" . $group["roomgroupname"] . "</td>";
    }
    $group_str .= "</tr></table>";
    $dvout = "<div id=\"dayviewheader\">" . $currentmdy . "</div>" . $group_str;
    $dvout .= "<table id=\"dayviewTable\" cellpadding=\"0\" cellspacing=\"0\">";
    //Create optional field form items string for reservation form
    //Select all records from optionalfields table in order of optionorder ascending
    $optionalfields_string = "";
    $optionalfields_array = mysqli_query($GLOBALS["___mysqli_ston"], "SELECT * FROM optionalfields ORDER BY optionorder ASC;");
    while ($optionalfield = mysqli_fetch_array($optionalfields_array)) {
        //Determine if required
        if ($optionalfield["optionrequired"] == 1) {
            $optionalfields_string .= "<strong><span class=\'requiredmarker\'>*</span>";
        } else {
            $optionalfields_string .= "<strong>";
        }
        //Print field question
        $optionalfields_string .= $optionalfield["optionquestion"] . "</strong>: ";
        //Determine if this field is a text field or a select field
        if ($optionalfield["optiontype"] == 0) {
            $optionalfields_string .= "<input type=\'text\' name=\'" . $optionalfield["optionformname"] . "\' /><br/>";
        } else {
            $optionalfields_string .= "<select name=\'" . $optionalfield["optionformname"] . "\'>";
            $optionchoices = explode(";", $optionalfield["optionchoices"]);
            foreach ($optionchoices as $choice) {
                $optionalfields_string .= "<option value=\'" . $choice . "\'>" . $choice . "</option>";
            }
            $optionalfields_string .= "</select><br/>";
        }
    }
    //Construct table header
    $dvout .= "<tr><th>&nbsp;</th>";
    foreach ($xmlroominfo->room as $room) {
        $dvout .= "<th>" . $room->name . "</th>";
    }
    $dvout .= "<th>&nbsp;</th>";
    $dvout .= "</tr>";
    while ($last_time->isGreaterThan($current_time)) {
        //Format time string
        $time_format = $settings["time_format"];
        $current_time_exploded = explode(":", $current_time->getTime());
        $current_time_tf = mktime($current_time_exploded[0], $current_time_exploded[1], $current_time_exploded[2], date("n", $_POST["fromrange"]), date("j", $_POST["fromrange"]), date("Y", $_POST["fromrange"]));
        $time_str = date($time_format, $current_time_tf);
        $dvout .= "<tr onMouseOver=\"javascript:this.className='mousedoverrow';\" onMouseOut=\"javascript:this.className='mousedoutrow';\"><td class=\"dayviewTime\">" . $time_str . "</td>";
        $current_stop = new ClockTime(0, 0, 0);
        $current_stop->setMySQLTime((string)$current_time->getTime());
        $current_stop->addMinutes($settings["interval"] - 1);
        foreach ($xmlroominfo->room as $room) {
            // eval("\$roomhours = \$room->hours->" . $currentweekday . "->hourset;");
            $roomhours = $room->hours->$currentweekday->hourset;
            $specialroomhours = $room->specialhours->hourset;
            $collision = "";
            //Loop runs for all hoursets of this room on this day
            //Proceed only is room has default hours
            if (isset($roomhours)) {
                foreach ($roomhours as $hourset) {
                    $roomstart = new ClockTime(0, 0, 0);
                    $roomstart->setMySQLTime((string)$hourset->start);
                    $roomstop = new ClockTime(0, 0, 0);
                    $roomstop->setMySQLTime((string)$hourset->end);
                    //echo $collision .", ";
                    //If a good collision (stalactite, bat, spelunker, salamander, stalagmite) has already occured, don't run this function
                    if ($collision != "bat" && $collision != "stalactite" && $collision != "spelunker" && $collision != "salamander" && $collision != "stalagmite") {
                        $collision = collisionCave($roomstart, $roomstop, $current_time, $current_stop);
                    }
                    //echo $roomstart->getTime() .", ". $roomstop->getTime() .", ". $current_time->getTime() .", ". $current_stop->getTime() .", ". $room->name .", ". $collision ."<br/>";
                }
            }
            //If special hours exist for this day, throw away previous results and
            //check special hours instead.
            if ((string)$specialroomhours->start[0] != "") {
                $collision = "";
                foreach ($specialroomhours as $hourset) {
                    $roomstart = new ClockTime(0, 0, 0);
                    $roomstart->setMySQLTime((string)$hourset->start);
                    $roomstop = new ClockTime(0, 0, 0);
                    $roomstop->setMySQLTime((string)$hourset->end);
                    //echo $collision .", ";
                    //If a good collision (stalactite, bat, spelunker, salamander, stalagmite) has already occured, don't run this function
                    if ($collision != "bat" && $collision != "stalactite" && $collision != "spelunker" && $collision != "salamander" && $collision != "stalagmite") {
                        $collision = collisionCave($roomstart, $roomstop, $current_time, $current_stop);
                    }
                    //echo $roomstart->getTime() .", ". $roomstop->getTime() .", ". $current_time->getTime() .", ". $current_stop->getTime() .", ". $room->name .", ". $collision ."<br/>";
                }
            }
            //If final collision state is stalactite, bat, spelunker, salamander, or stalagmite, the room is open during this time interval.
            //Check to see if there are any reservations that collide with this time.
            $rescol = FALSE;
            if ($collision == "stalactite" || $collision == "bat" || $collision == "spelunker" || $collision == "salamander" || $collision == "stalagmite") {
                //Go through each reservation in $xmlreservations, converting start and end to ClockTimes
                //Then run collisionCave against them to see if a reservation exists here. Refer to
                //reservations by their reservationid when linking to them.
                //Use XPath to reduce $xmlreservations to a smaller array of reservations that are only for the current room
                $reduced_reservations = $xmlreservations->xpath("/reservations/reservation[roomid=" . $room->id . "]");
                foreach ($reduced_reservations as $reservation) {
                    //foreach($xmlreservations as $reservation){
                    $reservationstart = new ClockTime(0, 0, 0);
                    $reservationstart->setMySQLTime(date('H:i:s', (string)$reservation->start));
                    $reservationend = new ClockTime(0, 0, 0);
                    $reservationend->setMySQLTime(date('H:i:s', (string)$reservation->end));
                    //If the timestamp for the reservation extends beyond the day's 23:59:59 timestamp ($_POST["torange"], change reservationend to 23:59:59
                    if ((int)$reservation->end > $_POST["torange"]) {
                        $reservationend->setTime(23, 59, 59);
                    }
                    //If the timestamp for the reservation begins prior to the day's 00:00:00 timestamp ($_POST["fromrange"], change reservationstart to 00:00:00
                    if ($_POST["fromrange"] > (int)$reservation->start) {
                        $reservationstart->setTime(0, 0, 0);
                    }
                    $res_collision = collisionCave($reservationstart, $reservationend, $current_time, $current_stop);
                    //echo $res_collision .", ". $current_time->getTime() .", ". $current_stop->getTime() .", ". $reservationstart->getTime() .", ". $reservationend->getTime() .", ". $reservation->id ."<br/>";
                    if ((int)$reservation->roomid == (int)$room->id && ($res_collision == "stalactite" || $res_collision == "bat" || $res_collision == "spelunker" || $res_collision == "salamander" || $res_collision == "stalagmite")) {
                        //Determine if this reservation is the current user's or not
                        $info = "";
                        if ($reservation->username != "") {
                            $info .= "<strong>Username</strong>: " . $reservation->username . "<br/>";
                        }
                        foreach ($reservation->optionalfields->optionalfield as $option) {
                            $strip = array("'", "\"");
                            $strip_rep = array("\'", "\'");
                            $info .= "<strong>" . $option->optionname . "</strong>: " . str_replace($strip, $strip_rep, $option->optionvalue) . "<br/>";
                        }
                        if ($_SESSION["username"] != (string)$reservation->username && $isadministrator != "TRUE") {
                            //Display "taken" button that shows public info.
                            $collision = "<img style=\"cursor: pointer;\" src=\"" . $_SESSION["themepath"] . "images/takenbutton.png\" border=\"0\" onClick=\"showPopUp(this,'" . $info . "');\" />";
                        } else {
                            if ($isadministrator == "TRUE" || $_SESSION["username"] == (string)$reservation->username) $info .= "<strong>Time of Request</strong>: " . $reservation->timeofrequest . "<br/><br/><center>Cancel this reservation? <a href=\'javascript:cancel(" . $reservation->id . "," . $_POST["group"] . ");\'>Yes</a> <a href=\'javascript:closePopUp();\'>No</a></center>";
                            //Display "cancel" button that shows cancellation confirmation.
                            $collision = "<img style=\"cursor: pointer;\" src=\"" . $_SESSION["themepath"] . "images/cancelbutton.png\" border=\"0\" onClick=\"showPopUp(this,'" . $info . "');\" />";
                        }
                        $rescol = TRUE;
                    }
                }
            }
            if ($rescol && $collision == "stalactite" || $collision == "bat" || $collision == "spelunker" || $collision == "salamander" || $collision == "stalagmite") {
                //Display "reserve" button that shows reservation form.
                $limit_total = unserialize($settings["limit_total"]);
                $limit_frequency = unserialize($settings["limit_frequency"]);
                $current_duration = $settings["interval"];
                $durationhtml = "";
                while ($current_duration <= $settings["limit_duration"]) {
                    $durationhtml .= "<option value=\'" . $current_duration . "\'>" . $current_duration . " mins</option>";
                    $current_duration += $settings["interval"];
                }
                $capacity = $room->capacity;
                $capacity_string = "";
                for ($cc = 1; $cc <= $capacity; $cc++) {
                    $capacity_string .= "<option value=\'" . $cc . "\'>" . $cc . "</option>";
                }
                //If this user is an administrator, give them the option of inputting and altusername
                $altusernamestr = "";
                if ($isadministrator == "TRUE") {
                    $altusernamestr = "<strong>Username</strong>: <input type=\'text\' name=\'altusername\' /><br/><strong>Email Confirmation</strong>: <select name=\'emailconfirmation\'><option value=\'no\'>No</option><option value=\'yes\'>Yes</option></select><br/>";
                }
                $info = "<strong>Room</strong>: " . $room->name . "<br/><strong>Start Time</strong>: " . $time_str . "<br/><form name=\'reserve\' action=\'javascript:reserve(" . $_POST["group"] . ");\'>" . $altusernamestr . "<input type=\'hidden\' name=\'roomid\' value=\'" . $room->id . "\' /><input type=\'hidden\' name=\'starttime\' value=\'" . strtotime($currentmdy . " " . $current_time->getTime()) . "\' /><input type=\'hidden\' name=\'fullcapacity\' value=\'" . $capacity . "\' /><strong><span class=\'requiredmarker\'>*</span>Duration</strong>: <select name=\'duration\'>" . $durationhtml . "</select><br/><strong><span class=\'requiredmarker\'>*</span>Number in group</strong>: <select name=\'capacity\'>" . $capacity_string . "</select><br/>" . $optionalfields_string . "<br/><center><strong>Reserve this room?</strong>: <a href=\'javascript:reserve(" . $_POST["group"] . ");\'>Yes</a> <a href=\'javascript:closePopUp();\'>No</a></center></form><br/><span class=\'requirednote\'><span class=\'requiredmarker\'>*</span> denotes a required field</span>";
                //$collision = "<img style=\"cursor: pointer;\" src=\"". $_SESSION["themepath"] ."images/reservebutton.png\" border=\"0\" onClick=\"showPopUp(this,'". $info ."');\" />";
                $collision = "<img style=\"cursor: pointer;\" src=\"" . $_SESSION["themepath"] . "images/reservebutton.png\" border=\"0\" onClick=\"showPopUpReserve(this,'" . $room->name . "','" . $time_str . "','" . $_POST["group"] . "','" . $altusernamestr . "','" . $room->id . "','" . strtotime($currentmdy . " " . $current_time->getTime()) . "','" . $capacity . "','" . $durationhtml . "','" . $capacity_string . "','" . $optionalfields_string . "');\" />\n";
            } elseif (!$rescol) {
                //Display "closed" button that is not interactive.
                $collision = "<img src=\"" . $_SESSION["themepath"] . "images/closedbutton.png\" />";
            }
            $dvout .= "<td class=\"dayviewTD\" onMouseOver=\"roomDetails('<span id=\'roomdetailsname\'>" . $room->name . "</span><br/><span id=\'roomdetailscapacitylabel\'>Capacity: </span><span id=\'roomdetailscapacity\'>" . $room->capacity . "</span><br/>" . $room->description . "');\">" . $collision . "</td>";
        }
        $dvout .= "<td class=\"dayviewTime\">" . $time_str . "</td>";
        $dvout .= "</tr>";
        //Increment time by Interval
        $current_time->addMinutes($settings["interval"]);
    }
    $dvout .= "</table>";
    echo $dvout;
} //User isn't logged in
else {
    echo "Error: User is not logged in.";
}
?>
