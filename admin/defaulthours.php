<?php
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}
include("../includes/or-dbinfo.php");
include("../includes/ClockTime.php");
if (!(isset($_SESSION["username"])) || $_SESSION["username"] == "") {
    echo "You are not logged in. Please <a href=\"../index.php\">click here</a> and login with an account that is an authorized administrator or reporter.";
} elseif ($_SESSION["isadministrator"] != "TRUE") {
    echo "You must be authorized as an administrator to view this page. Please <a href=\"../index.php\">go back</a>.<br/>If you believe you received this message in error, contact an administrator.";
} elseif ($_SESSION["systemid"] != $settings["systemid"]) {
    echo "You are not logged in. Please <a href=\"../index.php\">click here</a> and login with an account that is an authorized administrator or reporter.";
} else {
    $op = isset($_REQUEST["op"]) ? $_REQUEST["op"] : "";
    $successmsg = "";
    $errormsg = "";
    switch ($op) {
        case "adddefaulthours":
            $starthour = isset($_REQUEST["starthour"]) ? $_REQUEST["starthour"] : "";
            $startminute = isset($_REQUEST["startminute"]) ? $_REQUEST["startminute"] : "";
            $endhour = isset($_REQUEST["endhour"]) ? $_REQUEST["endhour"] : "";
            $endminute = isset($_REQUEST["endminute"]) ? $_REQUEST["endminute"] : "";
            $startperiod = isset($_REQUEST["startperiod"]) ? $_REQUEST["startperiod"] : "";
            $endperiod = isset($_REQUEST["endperiod"]) ? $_REQUEST["endperiod"] : "";
            $affectedrooms = isset($_REQUEST["affectedrooms"]) ? $_REQUEST["affectedrooms"] : "";
            //days that the change applies to
            $affecteddays = isset($_REQUEST["affecteddays"]) ? $_REQUEST["affecteddays"] : "";
            if($startperiod == "PM" && $starthour != 12)
              $starthour += 12;
            if($endperiod == "PM" && $endhour != 12)
              $endhour += 12;
            //All fields required
            if ($starthour != "" && $startminute != "" && $endhour != "" && $endminute != "" && $affectedrooms != "" && is_array($affectedrooms) && $affecteddays != "" && is_array($affecteddays)) {
                //Make sure from and to are in proper formats
                        //Make sure endtime is greater than starttime
                        $starttime = new ClockTime($starthour, $startminute, 0);
                        $endtime = new ClockTime($endhour, $endminute, 0);
                        if (($endtime->isGreaterThan($starttime)) || ($starttime->getTime() == "00:00:00" && $endtime->getTime() == "00:00:00")) {
                            //Iterate through selected rooms
                            foreach ($affectedrooms as $aroom) {
                                //iterate through selected days
                                foreach($affecteddays as $aday) {
                                    ///get all the hours for the room on this day
                                    $allhoursr = mysqli_query($GLOBALS["___mysqli_ston"], "SELECT * FROM roomhours WHERE roomid=" . $aroom . " AND dayofweek=" . $aday . " ORDER BY start ASC;");
                                    $ccflag = 0;
                                    //check to see if there any conflicts
                                    while ($record = mysqli_fetch_array($allhoursr)) {
                                        $tstart = new ClockTime($starthour, $startminute, 0);
                                        $tstart->setMySQLTime($record["start"]);
                                        $tend = new ClockTime($endhour, $endminute, 0);
                                        $tend->setMySQLTime($record["end"]);
                                        $ccresult = collisionCave($tstart, $tend, $starttime, $endtime);
                                        //acceptable results: sunmilk, ceiling, moonmilk, floor
                                        //if ANY other result occurs during this loop, this time is not acceptable
                                        if ($ccresult != "sunmilk" && $ccresult != "moonmilk" && $ccresult != "ceiling" && $ccresult != "floor" && $ccflag != 1) {
                                            $ccflag = 1;
                                        }
                                    }
                                    if ($ccflag) {
                                        $errormsg = "Can't add new hours as they conflict with existing hours for this room.";
                                    } else {
                                        //Add hours
                                        if (mysqli_query($GLOBALS["___mysqli_ston"], "INSERT INTO roomhours(roomid,dayofweek,start,end) VALUES(" . $aroom . ",'" . $aday . "','" . $starttime->getTime() . "','" . $endtime->getTime() . "');")) {
                                            $successmsg = "New hours added!";
                                        } else {
                                            $room = mysqli_fetch_array(mysqli_query($GLOBALS["___mysqli_ston"], "SELECT * FROM rooms WHERE roomid=" . $aroom . ";"));
                                            $errormsg = "There was a problem adding the new hours. Please try again.";
                                            $errormsg .= "<br/>Unable to add default hours to room " . $room["roomname"] . ". Please try again!";
                                        }
                                    }
                                }
                            }
                        } else {
                            $errormsg .= "<br/>Opening time must occur before Closing time!";
                        }
            } else {
                $errormsg .= "<br/>Some parameters are missing. Make sure all form fields are filled out.";
            }
            break;
        case "deletedefaulthours":
            $roomhoursid = isset($_REQUEST["roomhoursid"]) ? $_REQUEST["roomhoursid"] : "";
            if (mysqli_query($GLOBALS["___mysqli_ston"], "DELETE FROM roomhours WHERE roomhoursid=" . $roomhoursid . ";")) {
                $successmsg = "Hours deleted.";
            } else {
                $errormsg = "Unable to delete these hours! Please try again.";
            }
            break;
    }
    ?>
    <!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.1//EN" "http://www.w3.org/TR/xhtml11/DTD/xhtml11.dtd">
    <html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en" lang="en">

    <head>
        <title><?php echo $settings["instance_name"]; ?> - Administration - Default Hours</title>
        <link rel="stylesheet" type="text/css" href="adminstyle.css"/>
        <meta http-equiv="Content-Script-Type" content="text/javascript"/>
        <script language="javascript" type="text/javascript">
            function deletehrs(roomhoursid, anchorname) {
                var answer = confirm("Are you sure you would like to delete these hours?\n\nNOTE: Modifying hours will NOT delete room reservations. For special hours (such as holidays, etc.) please use the Special Hours section in administration.");
                if (answer) {
                    window.location = "defaulthours.php?op=deletedefaulthours&roomhoursid=" + roomhoursid + "&anchorname=" + anchorname;
                }
                else {
                }
            }
        </script>

        <script src="../includes/datechooser/date-functions.js" type="text/javascript"></script>
        <script src="../includes/datechooser/datechooser.js" type="text/javascript"></script>
        <link rel="stylesheet" type="text/css" href="../includes/datechooser/datechooser.css">

    </head>

    <body onLoad="jumpToAnchor();">
    <div id="heading"><span
                class="username"><?php echo isset($_SESSION["username"]) ? "<strong>Logged in as</strong>: " . $_SESSION["username"] : "&nbsp;"; ?></span>&nbsp;<?php echo ($_SESSION["isadministrator"] == "TRUE") ? "<span class=\"isadministrator\">(Admin)</span>&nbsp;" : "";
        echo ($_SESSION["isreporter"] == "TRUE") ? "<span class=\"isreporter\">(Reporter)</span>&nbsp;" : ""; ?>
        |&nbsp;<a href="../index.php">Public View</a>&nbsp;|&nbsp;<a href="../modules/logout.php">Logout</a></div>
    <div id="container">
        <center>
            <?php if ($_SESSION["isadministrator"] == "TRUE"){
            if ($successmsg != "") {
                echo "<div id=\"successmsg\">" . $successmsg . "</div>";
            }
            if ($errormsg != "") {
                echo "<div id=\"errormsg\">" . $errormsg . "</div>";
            }
            ?>
        </center>
        <h3><a href="index.php">Administration</a> - Default Hours</h3>
        <br/>
        <hr/>
        <br/>
        <h3>Current Room Hours:</h3><br>
        <?php
            $rooms = mysqli_query($GLOBALS["___mysqli_ston"], "SELECT * FROM rooms ORDER BY roomgroupid ASC, roomposition ASC;");
            $roomgroups = mysqli_query($GLOBALS["___mysqli_ston"], "SELECT * FROM roomgroups;");
            while($group = mysqli_fetch_array($roomgroups)){
                echo "<h4><strong>" . $group["roomgroupname"] . ":</strong></h4>";
                echo "<table border=1 frame=void rules=rows>";
                echo "<tr><th>Room</th><th>Sunday</th><th>Monday</th><th>Tuesday</th><th>Wednesday</th><th>Thursday</th><th>Friday</th><th>Saturday</th></tr>";
                $rooms =  mysqli_query($GLOBALS["___mysqli_ston"], "SELECT * FROM rooms WHERE roomgroupid =" . $group["roomgroupid"] . ";");
                while($room = mysqli_fetch_array($rooms)){
                    echo "<tr>";
                    echo "<td width=500px align='center'>" . $room['roomname'] . "</td>";
                    for ($wkdy = 0; $wkdy <= 6; $wkdy++) {
                        echo "<td width=3000px align='center'>";
                        $thisday = mysqli_query($GLOBALS["___mysqli_ston"], "SELECT * FROM roomhours WHERE roomid=" . $room["roomid"] . " AND dayofweek=" . $wkdy . " ORDER BY start ASC;");
                        while ($rec = mysqli_fetch_array($thisday)) {
                            $start = substr($rec["start"], 0, -3);
                            $end = substr($rec["end"], 0, -3);
                            echo  date('h:ia', strtotime($start))."-".date('h:ia', strtotime($end))." <a href=\"javascript:deletehrs(" . $rec["roomhoursid"] . ",'" . $room["roomname"] . "');\">x\n</a>";
                        }
                        echo "</td>";
                    }
                    echo "</tr>";
                }
                echo "</table>";
            }
        ?>
        <br/>
        <hr/>
        <br/>

        <h3>Add Default Hours</h3><br/>
        <em>Note: Please be sure to cancel any current reservations that may be removed as a result of adding default
            hours. This will be automated in a future version of this system.</em><br/>
        <form name="adddefaulthours" action="defaulthours.php" method="POST">
            <table>
                <tr>
                    <td>
                        <strong>Open:</strong>
                    </td>
                    <td>
                        <select name="starthour">
                            <?php
                            for ($i = 1; $i <= 12; $i++) {
                                echo "<option value=\"" . $i . "\">" . $i . "</option>";
                            }
                            ?>
                        </select>:<select name="startminute">
                            <?php
                            for ($i = 0; $i <= 59; $i++) {
                                echo "<option value=\"" . $i . "\">" . $i . "</option>";
                            }
                            ?>
                        </select>
                      <select name="startperiod">
                          <?php
                          $timePeriods = ["AM" , "PM"];
                          for ($i = 0; $i < 2; $i++) {
                              echo "<option value=\"" . $timePeriods[$i] . "\">" .  $timePeriods[$i] . "</option>";
                          }
                          ?>
                      </select>
                    </td>
                </tr>
                <tr>
                    <td>
                        <strong>Close:</strong>
                    </td>
                    <td>
                        <select name="endhour">
                            <?php
                            for ($i = 1; $i <= 12; $i++) {
                                echo "<option value=\"" . $i . "\">" . $i . "</option>";
                            }
                            ?>
                        </select>:<select name="endminute">
                            <?php
                            for ($i = 0; $i <= 59; $i++) {
                                echo "<option value=\"" . $i . "\">" . $i . "</option>";
                            }
                            ?>
                        </select>
                        <select name="endperiod">
                            <?php
                            $timePeriods = ["AM" , "PM"];
                            for ($i = 0; $i < 2; $i++) {
                                echo "<option value=\"" . $timePeriods[$i] . "\">" .  $timePeriods[$i] . "</option>";
                            }
                            ?>
                        </select>
                    </td>
                </tr>
                <tr>
                    <td colspan="2"><em>(To close room for entire day, leave hours set to 00:00-00:00.)</em><br/><br/>
                    </td>
                </tr>
            </table>
            <strong>Days Affected:&nbsp;&nbsp;&emsp; </strong>
            <?php
                $weekdays = ["Sunday", "Monday", "Tuesday", "Wednesday", "Thursday", "Friday", "Saturday" ];
                for ($i = 0; $i <= 6; $i++) {
                    echo "<input type=\"checkbox\" name=\"affecteddays[]\" value=\"" . $i . "\" /><strong>" . $weekdays[$i] . "</strong>";
                }
            ?>
            <br><br><h4><strong>Rooms Affected: </strong></h4>
            <table>
                <?php
                $roomgroup = mysqli_query($GLOBALS["___mysqli_ston"], "SELECT * FROM roomgroups;");
                while ($group = mysqli_fetch_array($roomgroup)) {
                    echo "<h4>" . $group["roomgroupname"] . "</h4>";
                    echo "<table>";
                    $rooms = mysqli_query($GLOBALS["___mysqli_ston"], "SELECT * FROM rooms WHERE roomgroupid=" . $group["roomgroupid"] . ";");
                    while ($room = mysqli_fetch_array($rooms)){
                        echo "<tr><td><input type=\"checkbox\" name=\"affectedrooms[]\" value=\"" . $room["roomid"] . "\" /><strong>" . $room["roomname"] . "</strong></td></tr>\n";
                    }
                    echo "</table>";
                  }
                ?>
            </table>
            <br/>
            <input type="hidden" name="op" value="adddefaulthours"/>
            <input type="submit" value="Add Hours"/><br/><br/><br/>
        </form>

        <?php
        }
        ?>
    </div>
    </body>
    </html>
    <?php
}
?>