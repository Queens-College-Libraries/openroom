<?php
session_start();
/*
*or-getdatarange.php(POST:fromrange,torange,ajax_indicator)
*
*Returns: XML representation of all reservations between the two ranges. Reservations not owned by the user will contain only public details, while reservations owned by the user will contain all details.
*<reservations>
*	<reservation>
* 		<id></id>
*		<start></start>
*		<end></end>
*		<roomid></roomid>
*		<username></username> (if current user is this user)
*		<timeofrequest></timeofrequest> (is current user is administrator)
*		<options>
*			<option> (if not private) (if current user is administrator private options appear as well)
*				<optionname></optionname>
*				<optionvalue></optionvalue>
*			</option>
*			.
*			.
*			.
*		</options>
*	</reservation>
*</reservations>
*/
require_once("includes/or-dbinfo.php");

//Check if user is logged in. Set $username accordingly.
$username = isset($_SESSION["username"])?$_SESSION["username"]:"";

//Check if user is an administrative user. Set $isadministrator accordingly.
$isadministrator = isset($_SESSION["isadministrator"])?$_SESSION["isadministrator"]:"FALSE";

//Check AJAX use indication.
$ajax_indicator = isset($_POST["ajax_indicator"])?$_POST["ajax_indicator"]:"TRUE";

//Check fromrange and torange.
$fromrange = isset($_POST["fromrange"])?(int)$_POST["fromrange"]:0;
$torange = isset($_POST["torange"])?(int)$_POST["torange"]:0;
//$fromrange = 1;
//$torange =  strtotime("2009-04-30 10:00");

//Setup output string
$output = "<reservations>\n";

//If either parameter isn't not sent, send error and exit.
if($fromrange == 0 || $torange == 0){
	$output .= "<errormessage>One or both parameters are missing: fromrange, torange</errormessage>\n";
}
else{
	//Grab all reservations from DB with start OR end times between fromrange and torange
	$reservations_result = mysql_query("SELECT reservationid, UNIX_TIMESTAMP(start), UNIX_TIMESTAMP(end), roomid, username, timeofrequest FROM reservations WHERE (UNIX_TIMESTAMP(start) >= ". $fromrange ." AND UNIX_TIMESTAMP(start) <= ". $torange .") OR (UNIX_TIMESTAMP(end) >= ". $fromrange ." AND UNIX_TIMESTAMP(end) <= ". $torange .") OR (UNIX_TIMESTAMP(end) >= ". $torange ." AND UNIX_TIMESTAMP(start) <= ". $fromrange .") ORDER BY roomid, start ASC;");
	while($record = mysql_fetch_array($reservations_result)){
		$output .= "<reservation>\n<id>". $record["reservationid"] ."</id>\n<start>". $record["UNIX_TIMESTAMP(start)"] ."</start>\n<end>". $record["UNIX_TIMESTAMP(end)"] ."</end>\n<roomid>". $record["roomid"] ."</roomid>\n<username>". (($record["username"] == $username || $isadministrator == "TRUE")?$record["username"]:"") ."</username>\n";
		if($isadministrator == "TRUE"){
			$output .= "<timeofrequest>". $record["timeofrequest"] ."</timeofrequest>\n";
		}
		$output .= "<optionalfields>";
		//displayprivateoptions by default only shows public optional fields
		$displayprivateoptions = " AND optionalfields.optionprivate = 0";
		//if user is an administrator all options, public or private, are displayed
		if($isadministrator == "TRUE"){
			$displayprivateoptions = "";
		}
		//Retrieve optional field data
		$ofdr = mysql_query("SELECT * FROM reservationoptions LEFT JOIN optionalfields ON reservationoptions.optionname = optionalfields.optionname WHERE reservationoptions.reservationid = '". $record["reservationid"] ."'". $displayprivateoptions .";");
		while($ofd = mysql_fetch_array($ofdr)){
			$output .= "<optionalfield>\n<optionname>". $ofd["optionname"] ."</optionname>\n<optionvalue>". $ofd["optionvalue"] ."</optionvalue>\n</optionalfield>\n";
		}
		$output .= "</optionalfields>\n</reservation>";
	}
}

$output .= "</reservations>";

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
