<?php
	session_start();
	
	require_once("or-dbinfo.php");
	
	$op = isset($_POST["op"])?$_POST["op"]:"";
	
	
	$duration = is_numeric($_POST["duration"])?$_POST["duration"]:0;
	$size = is_numeric($_POST["size"])?$_POST["size"]:0;
	
	$time = isset($_POST["time"])?explode(":",$_POST["time"]):"";
	$ampm = isset($_POST["ampm"])?$_POST["ampm"]:"";
	if($ampm == "pm"){
		if($time[0] < 12){
			$time[0] = $time[0] + 12;
		}
	}elseif($ampm == "am"){
		if($time[0] == 12){
			$time[0] = 0;
		}
	}
	
	$from = mktime($time[0], $time[1], 0, $_POST["month"], $_POST["day"], $_POST["year"]);
	$to = $from + ($duration * 60) - 1;


	switch($op){
		case "reservation_check":
			$startTime = date("Y-m-d H:i:s", $from);
			$endTime = date("Y-m-d H:i:s", $to);
			
			if($time != "" && $ampm != "" && $duration != 0 && $size != 0){
				/*
				 * Select all rooms that can fit the size of the group
				 * and do not have a reservation during this time
				*/
				$non_reserved_rooms = "SELECT * FROM rooms
					WHERE rooms.roomcapacity >= ". $size ." 
					AND rooms.roomid not in(
						SELECT reservations.roomid FROM reservations 
						WHERE(
							(reservations.start between '".$startTime."' AND '".$endTime."')
							OR
							(reservations.end between '".$startTime."' AND '".$endTime."')
							OR
							(reservations.start <= '".$startTime."' AND reservations.end > '".$startTime."')
							OR
							(reservations.start <= '".$endTime."' AND reservations.end > '".$endTime."') 
						)
					)
				ORDER BY roomname;";
					
				
				
				$available_rooms = mysql_query($non_reserved_rooms);
				
				echo "<span id=\"instructions\">";
				if(mysql_num_rows($available_rooms) < 1){
					echo "No rooms are available with these requirements. Please change the fields above and try again.";
				}else{
					echo "Select a room below to make your reservation.";
				}
				echo "</span>";
				
				$norooms = true;
				
				while($available_room = mysql_fetch_array($available_rooms)){
					//Can this reservation be made in this room?
					$_POST["ajax_indicator"] = "FALSE";	
					$_POST["roomid"] = $available_room["roomid"];
					$_POST["starttime"] = $from;
					$_POST["duration"] = $duration;
					$_POST["onlychecking"] = "TRUE";
					
					ob_start();
						include("../or-reserve.php");
						$res_check = ob_get_contents();
					ob_end_clean();
					
					if($res_check == "Your reservation has been made!<br/>"){
					$norooms = false;
					?>
						<div class="room_button" onClick="make_reservation(<?php echo $available_room["roomid"]; ?>);">
							<table cellpadding="0" cellspacing="0">
								<tr valign="middle">
									<td>
										<span class="room_name"><?php echo $available_room["roomname"]; ?></span><br/>
										<span class="room_description"><?php echo $available_room["roomdescription"]; ?></span>
									</td>
									<td class="room_reserve_arrow">
										&rarr;
									</td>
								</tr>
							</table>
						</div>
					<?php
					}
				}
			}else{
				echo "<div id=\"error_msg\">All fields are required. Please make sure you have completed the form above and try again.</div>";
			}
			if($norooms){
				echo "<div id=\"error_msg\">No rooms are available with these requirements. Please change the fields above and try again.</div>";
			}
			break;
		
		
		case "make_reservation":
			
			$room_info = mysql_query("SELECT * FROM rooms WHERE roomid = ". $_POST["roomid"] .";");
			$room_info = mysql_fetch_array($room_info);
			
			echo "starttime=". $from ."&fullcapacity=". $room_info["roomcapacity"];
			
			$optionalfieldsarraytemp = mysql_query("SELECT * FROM optionalfields ORDER BY optionorder ASC;");
			while($optionalfield = mysql_fetch_array($optionalfieldsarraytemp)){
				echo "&". $optionalfield["optionformname"] ."=". $_POST[$optionalfield["optionformname"]];
			}
			break;
		
		
		
		default:
			break;
	}

?>
