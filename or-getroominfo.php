<?php
session_start();
/*
 * or-getroominfo.php(POST:ajax_indicator,[roomid],[roomgroup],[fromrange],[torange])
 * 
 * Returns: By default: XML representation of all rooms including room groupings, room features, room's normal hours for each weekday, etc.
 * 		If [roomid] is supplied, returns this information specifically for that room.
 * 		If [fromrange] and [torange] are supplied as timestamps, returns this information, and room hour information associated with those dates, including any special hours, for all rooms.
 * 
 * Note: In order to return special room hours (such as closures or holiday hours) it is REQUIRED to supply [fromrange] and [torange]. Failure to supply both values will result in only default hours.
 * 
 * <roominfo>
 * 	<room position="">					Only list room if id is provided, list all rooms if none provided
 * 		<id>x</id>
 * 		<name>y</name>
 * 		<capacity>#</capacity>
 * 		<description>z</description>
 * 		<hours>
 * 			<sunday>
 * 				<hourset>
 * 					<start>00:00</start>
 * 					<end>03:00</end>
 * 				</hourset>
 * 				<hourset>
 * 					<start>09:00</start>
 * 					<end>24:00</end>
 * 				</hourset>
 * 			</sunday>
 * 			.
 * 			.
 * 			.
 * 		</hours>
 * 		<specialhours>
 * 			<hourset>					Only list specialhours within the specified range for this room. Don't list special hours if no range is specified
 * 				<fromrange>(timestamp)</fromrange>
 * 				<torange>(timestamp of last day in effect)</torange>
 *				<start>00:00</start>
 *				<end>03:00</end>
 * 			</hourset>
 * 			<hourset>
 * 				<fromrange>(timestamp)</fromrange>
 * 				<torange>(timestamp)</torange>
 * 				<start>10:00</start>
 * 				<end>15:00</end>
 *			</hourset>
 * 			.
 * 			.
 * 			.
 * 		</specialhours>
 * 		<groups>
 * 			<group>
 * 				<groupid></groupid>
 * 				<groupname></groupname>
 * 			</group>
 * 		</groups>
 * 	</room>
 * </roominfo>
*/

require_once("includes/or-dbinfo.php");

//Check if user is logged in. Set $username accordingly.
$username = isset($_SESSION["username"])?$_SESSION["username"]:"";

//Check if user is an administrative user. Set $isadministrator accordingly.
$isadministrator = isset($_SESSION["isadministrator"])?$_SESSION["isadministrator"]:"FALSE";

//Check AJAX use indication.
$ajax_indicator = isset($_POST["ajax_indicator"])?$_POST["ajax_indicator"]:"TRUE";

//Check roomid
$roomid = isset($_POST["roomid"])?(int)$_POST["roomid"]:"";
$roomstring = ($roomid != "")?"WHERE roomid=". $roomid:"";

//Check fromrange and torange.
$fromrange = isset($_POST["fromrange"])?(int)$_POST["fromrange"]:0;
$torange = isset($_POST["torange"])?(int)$_POST["torange"]:0;

//Check group number
$group = isset($_POST["group"])?(int)$_POST["group"]:"";

if($group != ""){
	$grpstr = "WHERE roomgroupid = ". $group ." ";
}
else{
	$grpstr = "";
}

//Setup output string
$output = "<roominfo>\n";

	$room_result = mysql_query("SELECT * FROM rooms ". $roomstring ." ". $grpstr ."ORDER BY roomposition ASC;");
	//For each room
	while($record = mysql_fetch_array($room_result)){
		$output .= "\t<room position=\"". $record["roomposition"] ."\">\n\t\t<id>". $record["roomid"] ."</id>\n\t\t<name>". $record["roomname"] ."</name>\n\t\t<capacity>". $record["roomcapacity"] ."</capacity>\n\t\t<description>". $record["roomdescription"] ."</description>\n\t\t<hours>\n";
		//Get default hours for this room
		$dhours_result = mysql_query("SELECT * FROM roomhours WHERE roomid=". $record["roomid"] ." ORDER BY dayofweek, start ASC;");
		$prevwkdy = "";
		while($dhours = mysql_fetch_array($dhours_result)){
			if($prevwkdy != $dhours["dayofweek"] && $prevwkdy != ""){
				$output .= "\t\t\t</". $wkdystr .">\n";
			}
			$wkdystr = "";
			switch($dhours["dayofweek"]){
				case 0:
					$wkdystr = "sunday";
					break;
				case 1:
					$wkdystr = "monday";
					break;
				case 2:
					$wkdystr = "tuesday";
					break;
				case 3:
					$wkdystr = "wednesday";
					break;
				case 4:
					$wkdystr = "thursday";
					break;
				case 5:
					$wkdystr = "friday";
					break;
				case 6:
					$wkdystr = "saturday";
					break;
				default:
					$wkdystr = "";
					break;
			}
			if($prevwkdy != $dhours["dayofweek"]){
				$output .= "\t\t\t<". $wkdystr .">\n";
			}
			
			$output .= "\t\t\t\t<hourset>\n\t\t\t\t\t<start>". $dhours["start"] ."</start>\n\t\t\t\t\t<end>". $dhours["end"] ."</end>\n\t\t\t\t</hourset>\n";
			
			$prevwkdy = $dhours["dayofweek"];
		}
		if($prevwkdy != $dhours["dayofweek"]){
			$output .= "\t\t\t</". $wkdystr .">\n";
		}
		$output .= "\t\t</hours>\n\t\t<specialhours>\n";
		
		//Fetch any specialhours for this room that are within the given range
		//$shours_result = mysql_query("SELECT UNIX_TIMESTAMP(fromrange),UNIX_TIMESTAMP(torange),start,end FROM roomspecialhours WHERE roomid=". $record["roomid"] ." AND ((fromrange >= FROM_UNIXTIME(". $fromrange .") AND torange <= FROM_UNIXTIME(". $torange .")) OR (fromrange >= FROM_UNIXTIME(". $fromrange .") AND fromrange <= FROM_UNIXTIME(". $torange .")) OR (torange >= FROM_UNIXTIME(". $fromrange .") AND torange <= FROM_UNIXTIME(". $torange ."))) ORDER BY fromrange ASC;");
		$shours_result = mysql_query("SELECT UNIX_TIMESTAMP(fromrange),UNIX_TIMESTAMP(torange),start,end FROM roomspecialhours WHERE roomid=". $record["roomid"] ." AND ((fromrange < FROM_UNIXTIME(". $fromrange .") AND torange > FROM_UNIXTIME(". $torange .")) OR (fromrange >= FROM_UNIXTIME(". $fromrange .") AND fromrange <= FROM_UNIXTIME(". $torange .")) OR (torange >= FROM_UNIXTIME(". $fromrange .") AND torange <= FROM_UNIXTIME(". $torange ."))) ORDER BY fromrange ASC;");
																																										//Special Hours start AND end in this day													//Special Hours start in this day																//Special Hours end in this day
		while($shours = mysql_fetch_array($shours_result)){
			$output .= "\t\t\t<hourset>\n";
			
			$output .= "\t\t\t\t<fromrange>". $shours["UNIX_TIMESTAMP(fromrange)"] ."</fromrange>\n\t\t\t\t<torange>". $shours["UNIX_TIMESTAMP(torange)"] ."</torange>\n\t\t\t\t<start>". $shours["start"] ."</start>\n\t\t\t\t<end>". $shours["end"] ."</end>\n\t\t\t</hourset>\n";
		}
		
		$output .= "\t\t</specialhours>\n\t\t<groups>\n";
		
		$groups_result = mysql_query("SELECT * FROM roomgroups WHERE roomgroupid = ". $record["roomgroupid"] .";");
		while($groups = mysql_fetch_array($groups_result)){
			$output .= "\t\t\t<group>\n\t\t\t\t<groupid>". $groups["roomgroupid"] ."</groupid>\n\t\t\t\t<groupname>". $groups["roomgroupname"] ."</groupname>\n\t\t\t</group>\n";
		}
		
		$output .= "\t\t</groups>\n\t</room>\n";
	}

$output .= "</roominfo>";

if($ajax_indicator == "TRUE"){
	header("content-type: text/xml");
	echo $output;
}
elseif($onlychecking == "TRUE" || $onlychecking == "multireserve"){
	echo $output;
}
else{
	return $output;
}
?>
