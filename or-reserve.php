<?php
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}
require_once("includes/or-dbinfo.php");
require_once("includes/ClockTime.php");

//Check if user is logged in. Set $username accordingly.
$username = isset($_SESSION["username"]) ? $_SESSION["username"] : "";

//Check if user is an administrative user. Set $isadministrator accordingly.
$isadministrator = isset($_SESSION["isadministrator"]) ? $_SESSION["isadministrator"] : "FALSE";

//Only allow reservations if a user is logged in
if ($username != "") {
    //These three values must be sent with every reservation request
    $duration = filter_var((isset($_POST["duration"]) ? $_POST["duration"] : ""), FILTER_SANITIZE_NUMBER_INT);
    $roomid = filter_var((isset($_POST["roomid"]) ? $_POST["roomid"] : ""), FILTER_SANITIZE_NUMBER_INT);
    $starttime = filter_var((isset($_POST["starttime"]) ? $_POST["starttime"] : ""), FILTER_SANITIZE_NUMBER_INT);
    $endtime = $starttime + ($duration * 60);
    $capacity = filter_var((isset($_POST["capacity"]) ? $_POST["capacity"] : ""), FILTER_SANITIZE_NUMBER_INT);
    $fullcapacity = filter_var((isset($_POST["fullcapacity"]) ? $_POST["fullcapacity"] : ""), FILTER_SANITIZE_NUMBER_INT);
    //$onlychecking is used when only checking to see if a reservation is POSSIBLE and will not actually place it
    $onlychecking = (isset($_POST["onlychecking"]) ? $_POST["onlychecking"] : "FALSE");
    //$altusername is used when an administrator is reserving a room for a different user
    //This only needs to be used during the final phase of reserving, since admins are omitted from the rules
    //Therefore you don't need to replace all isntances of $username with this, only on the final inserts
    $altusername = (isset($_POST["altusername"]) ? $_POST["altusername"] : "");
    $emailconfirmation = (isset($_POST["emailconfirmation"]) ? $_POST["emailconfirmation"] : "yes");
    $emailconfirmation = (isset($_POST["multipleReservation"]) ? $_POST["emailconfirmation"] : "yes");
    $isFromMultipleReservations = isset($_POST["isFromMultipleReservations"]) ? $_POST["isFromMultipleReservations"] : "false";
    if (isset($onlychecking) && ($onlychecking == "TRUE" || $onlychecking == "multireserve")) {
        $capacity = 1;
        $fullcapacity = 1;
    }

    //Make sure these values have been set
    if ($duration != "" && $roomid != "" && $starttime != "" && $capacity != "" && (int)$capacity > 0 && $fullcapacity != "" && $capacity <= $fullcapacity) {
        //optional fields
        //Grab all optional field records from optionalfields table. Use this
        //information to pull the correct fields from POST and to determine required fields
        $errormsg = "";

        if ($onlychecking != "TRUE") {
            $optionalfieldsarraytemp = mysqli_query($GLOBALS["___mysqli_ston"], "SELECT * FROM optionalfields ORDER BY optionorder ASC;");
            while ($optionalfield = mysqli_fetch_array($optionalfieldsarraytemp)) {
                //Store sanitized user values in array for later use
                if (isset($_POST[$optionalfield["optionformname"]])) {
                    $optional_field_values[$optionalfield["optionformname"]] = mysqli_real_escape_string($GLOBALS["___mysqli_ston"], $_POST[$optionalfield["optionformname"]]);
                } else {
                    $optional_field_values[$optionalfield["optionformname"]] = mysqli_real_escape_string($GLOBALS["___mysqli_ston"], "");
                }

                //If value is required make sure there is something there
                if ($optionalfield["optionrequired"] == 1) {
                    if ($_POST[$optionalfield["optionformname"]] == "") {
                        $errormsg .= $optionalfield["optionname"] . " was left blank.<br/>";
                    }
                }

                //If optionalfield is a choice field, make sure it is one of the available choices
                if ($optionalfield["optiontype"] == 1) {
                    $availablechoices = explode(";", $optionalfield["optionchoices"]);
                    $isachoice = 0;
                    foreach ($availablechoices as $availablechoice) {
                        if ($availablechoice == $_POST[$optionalfield["optionformname"]]) {
                            $isachoice = 1;
                        }
                    }
                    if ($isachoice == 0) {
                        $errormsg .= $optionalfield["optionname"] . " is invalid.<br/>";
                    }
                }
            }
        }

        //$optional_field_values is already sanitized so begin checking the reservation for collisions
        //echo $duration ." ". $roomid ." ". $starttime ." ". $endtime ."<br/>";
        //foreach($optional_field_values as $key => $ofvalue){
        //	echo $key ." ". $ofvalue ."<br/>";
        //}
        //See if any reservations for this room exist during the reservation's period
        $_POST["fromrange"] = $starttime;
        $_POST["torange"] = $endtime - 1; //(must -1 to ensure no undesired collisions)
        ob_start();
        include("or-getdatarange.php");    //Get any reservation data during the reservation's period
        $getdatarange = ob_get_contents();
        ob_end_clean();
        $xmlreservations = new SimpleXMLElement($getdatarange);
        foreach ($xmlreservations->reservation as $reservation) {
            if ($reservation->roomid == $roomid) {
//                $errormsg .= "Found an existing reservation: <br/> "
//                    . "Room ID: "
//                    . $reservation->roomid
//                    . " for "
//                    . $reservation->username
//                    . " made at "
//                    . $reservation->timeofrequest
//                    . " <br />";
                $errormsg .= "Another reservation exists for this room at this time.<br/>";
            }
            if ($errormsg == "") {
                if ($reservation->username == $username && $isadministrator != "TRUE" && $settings["allow_simultaneous_reservations"] == "false") {
                    $errormsg .= "You have already reserved another room during this time. Please select a different time and try again.<br/>";
                }
            }
        }
        //Make sure the room is open (including specialhours) during the entirity of reservation's period
        //Basically scan through this room by interval from starttime to endtime and make sure the room is open

        $current_check_start = $starttime;
        $collision_array = array();

        while ($current_check_start < $endtime) {
            $current_check_end = $current_check_start + ($settings["interval"]) * 60 - 1;
            $current_check_wkdy = strtolower(date("l", $current_check_start));

            //Fix POST vars to span from 00:00:00 to 23:59:59 on the current date
            $_POST["fromrange"] = mktime(0, 0, 0, date("m", $starttime), date("j", $starttime), date("Y", $starttime));
            $_POST["torange"] = mktime(0, 0, 0, date("m", $endtime - 1), date("j", $endtime - 1), date("Y", $endtime - 1));

            ob_start();
            include("or-getroominfo.php");
            $getroominfo = ob_get_contents();
            ob_end_clean();
            $xmlroominfo = new SimpleXMLElement($getroominfo);

            //Fetch xml record for this room
            $thisroom = "";
            foreach ($xmlroominfo->room as $room) {
                if ($room->id == $roomid) {
                    $thisroom = $room;
                }
            }
            //If a matching room was found
            if ($thisroom != "") {
                $ccsct = new ClockTime(0, 0, 0);
                $ccsct->setMySQLTime(date("H:i:s", $current_check_start));
                $ccect = new ClockTime(0, 0, 0);
                $ccect->setMySQLTime(date("H:i:s", $current_check_end));

                //Gather its hours for the current time's weekday and special hours
                // eval("\$roomhours = \$thisroom->hours->" . $current_check_wkdy . "->hourset;");
                $roomhours = $thisroom->hours->$current_check_wkdy->hourset;
                $specialroomhours = $thisroom->specialhours->hourset;

                $collision = "";

                foreach ($roomhours as $hourset) {
                    $roomstart = new ClockTime(0, 0, 0);
                    $roomstart->setMySQLTime((string)$hourset->start);
                    $roomstop = new ClockTime(0, 0, 0);
                    $roomstop->setMySQLTime((string)$hourset->end);
                    //echo $roomstart->getTime() ." ". $roomstop->getTime() ." ". $ccsct->getTime() ." ". $ccect->getTime() ."<br/>";
                    //If good collision (bat, spelunker, salamander) has been previously reached skip this step
                    if ($collision != "bat" && $collision != "spelunker" && $collision != "salamander") {
                        $collision = collisionCave($roomstart, $roomstop, $ccsct, $ccect);
                    }
                }

                //If special hours exist for this day, throw away previous results and check special hours instead.
                if ((string)$specialroomhours->start[0] != "") {
                    $collision = "";
                    foreach ($specialroomhours as $hourset) {
                        $roomstart = new ClockTime(0, 0, 0);
                        $roomstart->setMySQLTime((string)$hourset->start);
                        $roomstop = new ClockTime(0, 0, 0);
                        $roomstop->setMySQLTime((string)$hourset->end);
                        //echo $roomstart->getTime() ." ". $roomstop->getTime() ." ". $ccsct->getTime() ." ". $ccect->getTime() ."<br/>";
                        //good collision (bat, spelunker, salamander)
                        if ($collision != "bat" && $collision != "spelunker" && $collision != "salamander") {
                            $collision = collisionCave($roomstart, $roomstop, $ccsct, $ccect);
                        }
                    }
                }
            }
            //Add collision to array
            $collision_array[] = $collision;
            //Increment for loop
            $current_check_start += ($settings["interval"]) * 60;
        }

        //Loop through collision array
        foreach ($collision_array as $collision) {
            //If collision is NOT bat, spelunker or salamander, set error and break out of the loop because it extends beyond business hours
            if ($collision != "bat" && $collision != "spelunker" && $collision != "salamander") {
                $errormsg .= "This reservation can not be created as it extends beyond business hours.<br/>";
                break 1;
            }
        }


        //Check LIMITS for this user and make sure they are allowed to make the reservation
        //First check frequency (get all reservations within the specified time range and count the reservations)
        //Administrators are not affected by these limits
        if ($isadministrator != "TRUE") {
            $settings_frequency = unserialize($settings["limit_frequency"]);
            $sf_count = $settings_frequency[0];
            $sf_freq = $settings_frequency[1];
            $res_count = 0;
            if ($sf_count != 0) {
                switch ($sf_freq) {
                    case "day":
                        //Calculate midnight and last second from the reservation's starttime
                        $_POST["fromrange"] = mktime(0, 0, 0, date("m", $starttime), date("j", $starttime), date("Y", $starttime));
                        $_POST["torange"] = mktime(23, 59, 59, date("m", $starttime), date("j", $starttime), date("Y", $starttime));
                        break;

                    case "week":
                        //Calculate midnight and last second from the previous Sunday to the following Saturday
                        if (date("l", $starttime) == "Sunday") {
                            $_POST["fromrange"] = mktime(0, 0, 0, date("m", $starttime), date("j", $starttime), date("Y", $starttime));
                        } else {
                            $_POST["fromrange"] = strtotime("last Sunday 00:00:00", $starttime);
                        }
                        if (date("l", $starttime) == "Saturday") {
                            $_POST["torange"] = mktime(23, 59, 59, date("m", $starttime), date("j", $starttime), date("Y", $starttime));
                        } else {
                            $_POST["torange"] = strtotime("next Saturday 23:59:59", $starttime);
                        }
                        break;

                    case "month":
                        //Calculate midnight and last second from the first to last day of the month
                        $_POST["fromrange"] = mktime(0, 0, 0, date("m", $starttime), 1, date("Y", $starttime));
                        $_POST["torange"] = mktime(23, 59, 59, date("m", $starttime), date("t", $starttime), date("Y", $starttime));
                        break;

                    case "year":
                        //Calculate midnight and last second from the first to last day of the year
                        $_POST["fromrange"] = mktime(0, 0, 0, 1, 1, date("Y", $starttime));
                        $_POST["torange"] = mktime(23, 59, 59, 12, 31, date("Y", $starttime));
                        break;
                }
                ob_start();
                include("or-getdatarange.php");
                $getdatarange = ob_get_contents();
                ob_end_clean();
                $xmlreservations = new SimpleXMLElement($getdatarange);
                //Now count how many are owned by this user
                foreach ($xmlreservations->reservation as $reservation) {
                    if ($reservation->username == $username) {
                        $res_count++;
                    }
                }
                if ($res_count >= $sf_count) {
                    $errormsg .= "You may only make " . $sf_count . " reservations per " . $sf_freq . ".<br/>";
                }
            }

            //Then in-the-past?
            $sapr = $settings["allow_past_reservations"];
            if ($sapr != "true") {
                $nowtime = time();
                if ($starttime < $nowtime) {
                    $errormsg .= "You may not make reservations in the past.<br/>";
                }
            }

            //Then before Opening Day?
            $openingday = $settings["limit_openingday"];
            if ($openingday != "") {
                $openingdaytime = strtotime($openingday);
                if ($starttime < $openingdaytime) {
                    $errormsg .= "You may not make reservations prior to " . $openingday . ".<br/>";
                }
            }

            //Then total
            $settings_total = unserialize($settings["limit_total"]);
            $st_total = $settings_total[0];
            $st_freq = $settings_total[1];
            $res_total = 0;
            if ($st_total != 0) {
                switch ($st_freq) {
                    case "day":
                        //Calculate midnight and last second from the reservation's starttime
                        $_POST["fromrange"] = mktime(0, 0, 0, date("m", $starttime), date("j", $starttime), date("Y", $starttime));
                        $_POST["torange"] = mktime(23, 59, 59, date("m", $starttime), date("j", $starttime), date("Y", $starttime));
                        break;

                    case "week":
                        //Calculate midnight and last second from the previous Sunday to the following Saturday
                        if (date("l", $starttime) == "Sunday") {
                            $_POST["fromrange"] = mktime(0, 0, 0, date("m", $starttime), date("j", $starttime), date("Y", $starttime));
                        } else {
                            $_POST["fromrange"] = strtotime("last Sunday 00:00:00", $starttime);
                        }
                        if (date("l", $starttime) == "Saturday") {
                            $_POST["torange"] = mktime(23, 59, 59, date("m", $starttime), date("j", $starttime), date("Y", $starttime));
                        } else {
                            $_POST["torange"] = strtotime("next Saturday 23:59:59", $starttime);
                        }
                        break;

                    case "month":
                        //Calculate midnight and last second from the first to last day of the month
                        $_POST["fromrange"] = mktime(0, 0, 0, date("m", $starttime), 1, date("Y", $starttime));
                        $_POST["torange"] = mktime(23, 59, 59, date("m", $starttime), date("t", $starttime), date("Y", $starttime));
                        break;

                    case "year":
                        //Calculate midnight and last second from the first to last day of the year
                        $_POST["fromrange"] = mktime(0, 0, 0, 1, 1, date("Y", $starttime));
                        $_POST["torange"] = mktime(23, 59, 59, 12, 31, date("Y", $starttime));
                        break;
                }
                ob_start();
                include("or-getdatarange.php");
                $getdatarange = ob_get_contents();
                ob_end_clean();
                $xmlreservations = new SimpleXMLElement($getdatarange);
                //Now count how many seconds are being used by this user
                foreach ($xmlreservations->reservation as $reservation) {
                    if ($reservation->username == $username) {
                        $res_total += ((int)$reservation->end + 1) - (int)$reservation->start;
                    }
                }
                if ((($res_total / 60) + $duration) > $st_total) {
                    $errormsg .= "You may only make " . $st_total . " minutes worth of reservations per " . $st_freq . ".<br/>";
                }
            }


            //Then duration
            if ($duration > $settings["limit_duration"]) {
                $errormsg .= "Each reservation may only be a maximum of " . $settings["limit_duration"] . " minutes.<br/>";
            }


            //Then Window
            $window = unserialize($settings["limit_window"]);
            $win_amount = (int)$window[0];
            $win_type = (string)$window[1];
            //If Window amount is 0, then type should contain date
            if ($win_amount == 0) {
                $win_array = explode("/", $win_type);
                $win_date = mktime(0, 0, 0, $win_array[0], $win_array[1], $win_array[2]);
                if ($starttime >= $win_date) {
                    $errormsg .= "You may not make reservations on or after " . $win_type . ".<br/>";
                }
            } else {
                $s_str = ($win_amount > 1) ? "s" : "";
                $end_time = strtotime("+" . $win_amount . " " . $win_type . $s_str);
                if ($starttime >= $end_time) {
                    $errormsg .= "You may not make reservations more than " . $win_amount . " " . $win_type . $s_str . " in advance.<br/>";
                }
            }
        }//end if $isadministrator != "true"
        //else is an administrator
        else {
            if ($altusername != "") {
                $username = $altusername;
            }
        }

        //Save everything to the db (if there weren't any errors) and display a success or failure message to the user
        if ($errormsg == "") {
            //MAKE SURE TO END RESERVATIONS ONE MINUTE BEFORE THE SELECTED END TIME FOR COLLISION'S SAKE
            //First insert the reservation itself
            if ($onlychecking != "TRUE") {
                $ins_res = mysqli_query($GLOBALS["___mysqli_ston"], "INSERT INTO reservations(start,end,roomid,username,numberingroup) VALUES('" . date("Y-m-d H:i:s", $starttime) . "','" . date("Y-m-d H:i:s", ($endtime - 1)) . "','" . $roomid . "','" . $username . "','" . $capacity . "');");
                if ($ins_res) {
                    //Grab the new reservationid by grabbing the most recently entered reservation (this one)
                    $id_res = mysqli_query($GLOBALS["___mysqli_ston"], "SELECT * FROM reservations ORDER BY timeofrequest DESC;");
                    if ($id_res) {
                        $id_a = mysqli_fetch_array($id_res);
                        $reservationid = $id_a["reservationid"];
                        //Then insert the optional field values (reservationoptions table)
                        if (isset($optional_field_values)) {
                            foreach ($optional_field_values as $key => $ofvalue) {
                                //Get the option's name
                                $opt_name_res = mysqli_query($GLOBALS["___mysqli_ston"], "SELECT * FROM optionalfields WHERE optionformname='" . $key . "';");
                                if ($opt_name_res) {
                                    $opt_name_a = mysqli_fetch_array($opt_name_res);
                                    $opt_name = $opt_name_a["optionname"];
                                    $fixedofvalue = htmlspecialchars($ofvalue, ENT_QUOTES);
                                    $fixedofvalue = str_replace("\\", "", $fixedofvalue);

                                    $opt_res = mysqli_query($GLOBALS["___mysqli_ston"], "INSERT INTO reservationoptions VALUES('" . $opt_name . "','" . $reservationid . "','" . $fixedofvalue . "');");
                                } else {
                                    //Optional fields not selectable, remove reservation
                                    $errormsg .= "Error in reserving room. Please try again. If you continue to have problems, please contact an administrator.<br/>";
                                }
                            }
                        }
                    } else {
                        //Reservation id not selectable, error out
                        $errormsg .= "Error in reserving room. Please try again. If you continue to have problems, please contact an administrator.<br/>";
                    }
                } else {
                    //Reservation could not be made
                    $errormsg .= "Error in reserving room. Please try again. If you continue to have problems, please contact an administrator.<br/>";
                }

                if ($errormsg == "") {
                    //Success!
                    //Run on-success code (send out appropriate emails, etc.)
                    $email_res_verbose = implode(",", unserialize($settings["email_res_verbose"]));
                    $email_res_terse = implode(",", unserialize($settings["email_res_terse"]));
                    $email_res_gef = implode(",", unserialize($settings["email_res_gef"]));
                    $email_cond_verbose = implode(",", unserialize($settings["email_cond_verbose"]));
                    $email_cond_terse = implode(",", unserialize($settings["email_cond_terse"]));
                    $email_cond_gef = implode(",", unserialize($settings["email_cond_gef"]));
                    $email_system = $settings["email_system"];

                    //Get user's email address
                    //If using login_method ldap just use the user's username and the ldap_baseDN dc's
                    //If using login_method normal you must grab the user's email property from the users table
                    $user_real = "";
                    $user_email = "";
                    $domain = "";
                    if ($settings["login_method"] == "ldap") {
                        // $ldapdn = explode(",", $settings["ldap_baseDN"]);
                        // $count = 0;
                        // foreach($ldapdn as $dn){
                        // 	if(substr($dn,0,3) == "dc="){
                        // 		if($count > 0){
                        // 			$dotstr = ".";
                        // 		}
                        // 		$domain .= $dotstr . substr($dn,3);
                        // 		$count++;
                        // 	}
                        // }
                        // $user_email = $username ."@". $domain;
                        // $user_real = $_SESSION["displayname"];
                        // $user_real_str = "Name: ". $user_real ."\n\n";
                        // $user_real_gef = "<b>Name</b>: ". $user_real ."<br/><br/>";
                        if ($username == $_SESSION["username"]) {
                            $user_email = $_SESSION["emailaddress"];
                            $user_real = $_SESSION["displayname"];
                        } else {
                            require_once(__DIR__ . '/vendor/autoload.php');
                            $user = new model\User($username);
                            $user_email = $user->get_emailaddress();
                            $user_real = $user->get_displayname();
                        }
                        $user_real_str = "Name: " . $user_real . "\n\n";
                        $user_real_gef = "<b>Name</b>: " . $user_real . "<br/><br/>";
                    }
                    if ($settings["login_method"] == "normal") {
                        // $emailrecord = mysqli_query($GLOBALS["___mysqli_ston"], "SELECT * FROM users WHERE username='" . $username . "';");
                        // if ($emailrecord) {
                        //     $user_emaila = mysqli_fetch_array($emailrecord);
                        //     $user_email = $user_emaila["email"];
                        // }
                        if(\model\User::exists($username))
                        {
                            $user = \model\User::get_a_specific_user(trim($username));
                            $user_email = $user->get_emailaddress();
                            $user_real = $user->get_displayname();
                            $user_real_str = "Name: " . $user_real . "\n\n";
                            $user_real_gef = "<b>Name</b>: " . $user_real . "<br/><br/>";
                        }
                    }

                    //Create verbose, terse and GEF messages.
                    //VERBOSE
                    if ($isFromMultipleReservations != "true") {
                        $verbose_msg = "Your room has been reserved!\n\n" .
                            $user_real_str .
                            "Username: " . $username . "\n\n" .
                            "E-mail: " . $user_email . "\n\n" .
                            "Room: " . $thisroom->name . "\n\n" .
                            "Date and Time: " . date("F j, Y g:i a", $starttime) . " - " . date("F j, Y g:i a", $endtime) . "\n\n" .
                            "Number in Group: " . $capacity . "\n\n";

                            foreach ($optional_field_values as $key => $ofval) {
                                $opname = mysqli_fetch_array(mysqli_query($GLOBALS["___mysqli_ston"], "SELECT * FROM optionalfields WHERE optionformname='" . $key . "';"));
                                $opname = $opname["optionname"];
                                $verbose_msg .= $opname . ": " . str_replace("\\", "", $ofval) . "\n\n";
                                $gef_msg_of .= "<b>" . $opname . "</b>: " . str_replace("\\", "", $ofval) . "<br/><br/>";
                            }

                        $terse_msg = $verbose_msg;
                        $verbose_msg .= $settings["policies"] . "\n\n";

                        $gef_msg = "<html><body>" . $user_real_gef . "<b>Date and Time</b>: " . date("F j, Y", $starttime) . " " . date("g:i a", $starttime) . " - " . date("F j, Y", $endtime) . " " . date("g:i a", $endtime) . "<br/><br/><b>Username</b>: " . $username . "<br/><br/>" . $gef_msg_of . "</body></html>";

                        $bccstr = "";
                        if ($email_res_verbose != "") {
                            $bccstr = "\r\nBcc: " . $email_res_verbose;
                        }

                        if ($emailconfirmation != "no") {
                            mail($user_email, $settings["instance_name"] . " Reservation", $verbose_msg, "From: " . $email_system . "\r\nReturn-Path: " . $email_system . "\r\nReply-To: " . $email_system . $bccstr);
                        } else {
                            mail($email_res_verbose, $settings["instance_name"] . " Reservation", $verbose_msg, "From: " . $email_system . "\r\nReturn-Path: " . $email_system . "\r\nReply-To: " . $email_system);
                        }
                        mail($email_res_terse, $settings["instance_name"] . " Reservation", $terse_msg, "From: " . $email_system . "\r\nReturn-Path: " . $email_system . "\r\nReply-To: " . $email_system);
                        mail($email_res_gef, "Room: " . $thisroom->name, $gef_msg, "MIME-Version: 1.0\r\nContent-type: text/html; charset=iso-8859-1\r\nFrom: " . $email_system . "\r\nReturn-Path: " . $email_system . "\r\nReply-To: " . $email_system);

                        //On Condition emails
                        //Get the current email_condition and email_value
                        //If condition == "none" skip this, if it is "duration" or "capacity" check those values
                        //If it is something else, check that particular optional field
                        if ($settings["email_condition"] != "none") {
                            if ($settings["email_condition"] == "duration" && $duration >= $settings["email_condition_value"]) {
                                mail($email_cond_verbose, $settings["instance_name"] . " Reservation (Condition Met)", $verbose_msg, "From: " . $email_system . "\r\nReturn-Path: " . $email_system . "\r\nReply-To: " . $email_system);
                                mail($email_cond_terse, $settings["instance_name"] . " Reservation (Condition Met)", $terse_msg, "From: " . $email_system . "\r\nReturn-Path: " . $email_system . "\r\nReply-To: " . $email_system);
                                mail($email_cond_gef, "Room: " . $thisroom->name, $gef_msg, "MIME-Version: 1.0\r\nContent-type: text/html; charset=iso-8859-1\r\nFrom: " . $email_system . "\r\nReturn-Path: " . $email_system . "\r\nReply-To: " . $email_system);
                            } elseif ($settings["email_condition"] == "capacity" && $capacity >= $settings["email_condition_value"]) {
                                mail($email_cond_verbose, $settings["instance_name"] . " Reservation (Condition Met)", $verbose_msg, "From: " . $email_system . "\r\nReturn-Path: " . $email_system . "\r\nReply-To: " . $email_system);
                                mail($email_cond_terse, $settings["instance_name"] . " Reservation (Condition Met)", $terse_msg, "From: " . $email_system . "\r\nReturn-Path: " . $email_system . "\r\nReply-To: " . $email_system);
                                mail($email_cond_gef, "Room: " . $thisroom->name, $gef_msg, "MIME-Version: 1.0\r\nContent-type: text/html; charset=iso-8859-1\r\nFrom: " . $email_system . "\r\nReturn-Path: " . $email_system . "\r\nReply-To: " . $email_system);

                            } else {
                                $thecond = $settings["email_condition"];
                                if (isset($optional_field_values) && $optional_field_values[$thecond] == $settings["email_condition_value"]) {
                                    mail($email_cond_verbose, $settings["instance_name"] . " Reservation (Condition Met)", $verbose_msg, "From: " . $email_system . "\r\nReturn-Path: " . $email_system . "\r\nReply-To: " . $email_system);
                                    mail($email_cond_terse, $settings["instance_name"] . " Reservation (Condition Met)", $terse_msg, "From: " . $email_system . "\r\nReturn-Path: " . $email_system . "\r\nReply-To: " . $email_system);
                                    mail($email_cond_gef, "Room: " . $thisroom->name, $gef_msg, "MIME-Version: 1.0\r\nContent-type: text/html; charset=iso-8859-1\r\nFrom: " . $email_system . "\r\nReturn-Path: " . $email_system . "\r\nReply-To: " . $email_system);
                                }
                            }
                        }
                    }
                    $tempstr = "Your reservation has been made!<br/>";
                    if ($onlychecking != "multireserve") {
                        $tempstr .= "|" . $starttime . "|" . mktime(23, 59, 59, date("m", $starttime), date("d", $starttime), date("Y", $starttime));
                    }
                    echo $tempstr;
                } else {
                    echo "<strong>Error</strong><br/>" . $errormsg . "|" . $starttime . "|" . mktime(23, 59, 59, date("m", $starttime), date("d", $starttime), date("Y", $starttime));
                }
            }//end if onlychecking != true
            else {
                echo "Your reservation has been made!<br/>";
            }
        } else {
            echo "<strong>Error</strong><br/>" . $errormsg . "|" . $starttime . "|" . mktime(23, 59, 59, date("m", $starttime), date("d", $starttime), date("Y", $starttime));
        }
    } //Else required info wasn't given
    else {
        echo "<strong>Error</strong>: There was an error in processing this request as some required information was not provided. Please try again.";
    }
} //Else no user was logged in
else {
    echo "<strong>Error</strong>: User is not logged in.";
}
?>
