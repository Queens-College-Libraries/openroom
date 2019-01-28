<?php
$op = $_GET["op"];

switch ($op) {
    case "makereservation":
        ?>
        <script type="text/javascript">
            function reservation_check(formObj) {
                var form_data = $("form[name=" + formObj.name + "]").serialize();
                $("#results").html("");
                $("#loader").html("<img src='<?php echo $_SESSION["themepath"]; ?>/images/ajax-loader.gif' />");
                $.ajax({
                    type: "POST",
                    url: "includes/mobile.php",
                    data: "op=reservation_check&" + form_data,
                    success: function (msg) {
                        $("#loader").html("");
                        $("#results").html(msg);
                        $('html, body').animate({
                            scrollTop: $("#results").offset().top + 'px'
                        }, 'slow');
                    }
                });
            }

            function make_reservation(room_id) {
                var form = $("form[name=makereservationform]")[0];
                var form_data = $("form[name=makereservationform]").serialize();
                $("#results").html("<img src='<?php echo $_SESSION["themepath"]; ?>/images/ajax-loader.gif' /><br/>Reserving...");
                $.ajax({
                    type: "POST",
                    url: "includes/mobile.php",
                    data: "op=make_reservation&roomid=" + room_id + "&" + form_data,
                    success: function (msg) {
                        $.ajax({
                            type: "POST",
                            url: "or-reserve.php",
                            dataType: "html",
                            data: "ajax_indicator=TRUE&duration=" + form.duration.value + "&roomid=" + room_id + "&capacity=" + form.size.value + "&" + msg,
                            success: function (result) {
                                result = result.split("|");
                                if (result[0] == "Your reservation has been made!<br/>") {
                                    $("#makereservation").html("<div id='success_msg'>Reservation was made successfully!</div>");
                                    $("#results").html("");
                                } else {
                                    $("#results").html("<div id='error_msg'>" + result[0] + "</div>");
                                }
                            }
                        });
                    }
                });
            }
        </script>
        <div id="makereservation">
            <form name="makereservationform" onSubmit="reservation_check(this);return false;">
                <span class="mobilelabel">I need a reservation on...</span><br/>

                <select name="month">
                    <?php
                    $now_month = date("n");
                    $month_array = array("Jan", "Feb", "Mar", "Apr", "May", "Jun", "Jul", "Aug", "Sep", "Oct", "Nov", "Dec");
                    for ($i = 1; $i <= 12; $i++) {
                        echo "<option ";
                        if ($i == $now_month) {
                            echo "selected ";
                        }
                        echo "value=\"" . $i . "\">" . $month_array[$i - 1] . "</option>";
                    }
                    ?>
                </select>/<select name="day">
                    <?php
                    $day = date("j");
                    for ($i = 1; $i <= 31; $i++) {
                        echo "<option ";
                        if ($i == $day) {
                            echo "selected ";
                        }
                        echo "value=\"" . $i . "\">" . $i . "</option>";
                    }
                    ?>
                </select>/<select name="year">
                    <?php
                    //From current year to last year in Window Limit
                    $year = date("Y");
                    $end_year = $year;
                    $limit_window_value = unserialize($settings["limit_window"]);

                    if ($limit_window_value[0] == 0) {
                        //If permanent window
                        $end_date = explode("/", $limit_window_value[1]);
                        $end_year = $end_date[2];
                    } else {
                        //If sliding window
                        $end_year = strtotime("+" . $limit_window_value[0] . " " . $limit_window_value[1]);
                        $end_year = date("Y", $end_year);
                    }

                    while ($year <= $end_year) {
                        echo "<option value=\"" . $year . "\">" . $year . "</option>";
                        $year++;
                    }
                    ?>
                </select>

                <br/>

                <span class="mobilelabel">At the following time...</span><br/>
                <select name="time">
                    <?php
                    require_once("includes/ClockTime.php");
                    $ctime = new ClockTime(1, 0, 0);
                    $ntime = new ClockTime(12, 59, 59);
                    $now = new ClockTime(0, 0, 0);
                    $now->setMySQLTime(date("h:i:s"));
                    $selected_flag = false;
                    $selected = "";

                    while ($ntime->isGreaterThan($ctime)) {
                        if (!$selected_flag) {
                            if ($ctime->isGreaterThan($now) || $ctime->isEqualTo($now)) {
                                $selected = " selected";
                                $selected_flag = true;
                            }
                        }
                        echo "<option" . $selected . " value=\"" . $ctime->getHours() . ":" . $ctime->pad($ctime->getMinutes()) . "\">" . $ctime->getHours() . ":" . $ctime->pad($ctime->getMinutes()) . "</option>";
                        $selected = "";
                        $ctime->addMinutes($settings["interval"]);
                    }
                    ?>
                </select><select name="ampm">
                    <option value="am" <?php if (date("a") == "am") {
                        echo "selected ";
                    } ?>>AM
                    </option>
                    <option value="pm" <?php if (date("a") == "pm") {
                        echo "selected ";
                    } ?>>PM
                    </option>
                </select>

                <select name="duration">
                    <option>How long is your meeting?</option>
                    <?php
                    for ($dur = $settings["interval"]; $dur <= $settings["limit_duration"]; $dur += $settings["interval"]) {
                        echo "<option value=\"" . $dur . "\">" . $dur . " minutes</option>";
                    }
                    ?>
                </select>
                <select name="size">
                    <option>How many people in your group?</option>
                    <?php
                    $max_capacity = mysqli_fetch_array(mysqli_query($GLOBALS["___mysqli_ston"], "SELECT roomcapacity FROM rooms ORDER BY roomcapacity DESC;"));
                    $max_capacity = $max_capacity["roomcapacity"];
                    for ($cap = 1; $cap <= $max_capacity; $cap++) {
                        echo "<option value=\"" . $cap . "\">" . $cap . "</option>";
                    }
                    ?>
                </select>
                <?php
                //List required optionalfields here
                $optional_fields = mysqli_query($GLOBALS["___mysqli_ston"], "SELECT * FROM optionalfields WHERE optionrequired = 1 ORDER BY optionorder ASC;");
                while ($optional_field = mysqli_fetch_array($optional_fields)) {
                    if ($optional_field["optiontype"] == 0) {
                        echo $optional_field["optionquestion"] .
                            "<input type=\"text\" class=\"mobiletextfield\" name=\"" . $optional_field["optionformname"] . "\" />";
                    } elseif ($optional_field["optiontype"] == 1) {
                        echo $optional_field["optionquestion"] . "<select name=\"" . $optional_field["optionformname"] . "\">";

                        $choices = explode(";", $optional_field["optionchoices"]);
                        foreach ($choices as $choice) {
                            echo "<option value=\"" . $choice . "\">" . $choice . "</option>";
                        }

                        echo "</select>";
                    }
                }
                ?>
                <br/>
                <div class="note">Note: All fields are required!</div>
                <div id="loader"></div>
                <input id="find_room_button" class="find_room_button" type="submit"
                       onClick="reservation_check(this.form);" value="Find me a room"/>
            </form>

            <br/><br/>
        </div>
        <div id="results"></div>

        <?php
        break;


    case "viewreservations":
    default:
        ?>
        <script type="text/javascript">
            function confirm_cancel(reservationid) {
                if (reservationid != -1) {
                    var offset = $("#reservation_" + reservationid).offset();
                    $("#confirm").offset({top: offset.top});
                    $("#confirm").html("Are you sure you want to cancel this reservation?<br/><br/><button onClick='cancel_reservation(" + reservationid + ")'>Yes</button><button onClick='confirm_cancel(-1)'>No</button>");
                    $("#confirm").show();
                } else {
                    $("#confirm").hide();
                }
            }

            function cancel_reservation(reservationid) {
                $("#confirm").hide();
                $("#reservation_" + reservationid).html("<img src='<?php echo $_SESSION["themepath"]; ?>/images/ajax-loader.gif' /><br/>Cancelling...");
                $.ajax({
                    type: "POST",
                    url: "or-cancel.php",
                    data: "reservationid=" + reservationid,
                    success: function (result) {
                        result = result.split("|");
                        if (result[0] == "This reservation has been cancelled!") {
                            window.location = "index.php";
                        } else {
                            $("#reservation_" + reservationid).html(result[0]);
                        }
                    }
                });
            }
        </script>
        <div id="confirm"></div>
        <span class="mobilelabel">Your Reservations</span>
        <?php
        
        $your_reservations = \model\Reservation::getAllReservationsForUser(\model\Db::getInstance(), $_SESSION["username"]);
        
        if (sizeof($your_reservations) < 1) {
            ?>
            <div id="noreservations">
                You have no upcoming reservations.
            </div>
            <?php
        }
        
        foreach($your_reservations as $your_res) {
            $start_timestamp = strtotime($your_res["start"]);
            $end_timestamp = strtotime($your_res["end"]);
            $duration = ($end_timestamp - $start_timestamp + 1) / 60;
        $option_fields = mysqli_query($GLOBALS["___mysqli_ston"], "SELECT * FROM reservationoptions WHERE reservationid=" . $your_res["reservationid"] . ";");
            ?>
            <div id="reservation_<?php echo $your_res["reservationid"]; ?>" class="reservation_button">
                <table cellpadding="0" cellspacing="0">
                    <tr valign="middle">
                        <td class="reservation_button_left">
                            <?php
                            echo "<span class=\"roomname\">" . $your_res["roomname"] . "</span><br/>";
                            echo "<span class=\"resdate\">" . date("M j, Y", $start_timestamp) . " at " . date("g:i a", $start_timestamp) . "</span><br/>";
                            echo "<span class=\"resduration\">Duration: " . $duration . " minutes</span><br/>";

                            while ($option_field = mysqli_fetch_array($option_fields)) {
                                echo "<span class=\"resoption\">" . $option_field["optionname"] . ": " . $option_field["optionvalue"] . "</span><br/>";
                            }
                            ?>
                        </td>
                        <td class="reservation_button_middle">
                            <?php
                            echo $your_res["roomdescription"] . "<br/>";
                            ?>
                        </td>
                        <td class="reservation_button_right"
                            onClick="confirm_cancel(<?php echo $your_res["reservationid"]; ?>)">
                            Cancel
                        </td>
                    </tr>
                </table>
            </div>
            <?php
        }

        break;
}
?>
