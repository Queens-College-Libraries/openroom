<?php

/****************************************
This class describes durative time in the format of hours:minutes:seconds (with 0 padding)
This class can be used with the MySQL TIME datatype for modifying those values and storing them back
in the database.  Modification consists of adding amounts of time in the hours:minutes:seconds format.
Hours must be an integer, minutes between 0 and 59 and seconds between 0 and 59.
****************************************/


class ClockTime{

//class vars
var $hours;
var $minutes;
var $seconds;


//constructor
function ClockTime($h,$m,$s){
	if($h < 0) $h*(-1);
	if($m < 0) $m*(-1);
	if($s < 0) $s*(-1);

	$this->setTime($h,$m,$s);
}





//methods
function getTime(){
	return $this->pad($this->hours) .":". $this->pad($this->minutes) .":". $this->pad($this->seconds);
}


function getHours(){
	return $this->hours;
}

function getMinutes(){
	return $this->minutes;
}

function getSeconds(){
	return $this->seconds;
}




function setTime($h, $m, $s){
	if($h < 0) $h*-1;
	if($m < 0) $m*-1;
	if($s < 0) $s*-1;
		
	$this->hours = $h;
	$this->minutes = $m;
	$this->seconds = $s;
}




function setMySQLTime($hhmmss){
	if(is_string($hhmmss)){
		//Set vars by stringpos using : as delimiter
		$firstColon = strpos($hhmmss, ":");
		$secondColon = strpos($hhmmss, ":", $firstColon+1);
		
		//+ 0 strips padded 0's converts from string to int
		$this->hours = substr($hhmmss, 0, $firstColon) + 0;
		$this->minutes = substr($hhmmss, $firstColon+1, 2) + 0;
		$this->seconds = substr($hhmmss, $secondColon+1, 2) + 0;
	}
}




function pad($i){
	$padded = "";
	
	if($i < 10){
		$padded = "0". $i;
	}
	else $padded = $i;
	
	return $padded;
}






function addHours($hrs){
	$this->hours += $hrs;
}




function addMinutes($mins){
	//First add the specified amount of minutes to $this->minutes, then convert these to hours leaving the remainer in $this->minutes
	$this->minutes += $mins;
	if($this->minutes >= 60){
		$minutesRemaining = $this->minutes % 60;
		$hoursToAdd = ($this->minutes - $minutesRemaining) / 60;
		$this->addHours($hoursToAdd);
		$this->minutes = $minutesRemaining;
	}
}




function addSeconds($secs){
	//First add the specified amount of seconds to $this->seconds, then convert these to minutes and run addMinutes() with the minutes you get, leaving the remainder in $this->seconds
	$this->seconds += $secs;
	if($this->seconds >= 60){
		$secondsRemaining = $this->seconds % 60;
		$minutesToAdd = ($this->seconds - $secondsRemaining) / 60;
		$this->addMinutes($minutesToAdd);
		$this->seconds = $secondsRemaining;
	}
}






function addTime($hrs, $mins, $secs){
	$this->addSeconds($secs);
	$this->addMinutes($mins);
	$this->addHours($hrs);
}





function addMySQLTime($hhmmss){
	$firstColon = strpos($hhmmss, ":");
	$secondColon = strpos($hhmmss, ":", $firstColon+1);
	
	$hrs = substr($hhmmss, 0, $firstColon);
	$mins = substr($hhmmss, $firstColon+1, 2);
	$secs = substr($hhmmss, $secondColon+1, 2);
	
	$this->addTime($hrs, $mins, $secs);
}





function isGreaterThan($clockTime){
	//If this->hours is greater we know this is true
	//If this->hours is equal, we need to check minutes
	//	If this->minutes is greater we know this is true
	//	If this->minutes is equal, we need to check seconds
	//		If this->seconds is greater we know this is true
	//		If not, it's false
	
	if($this->hours > $clockTime->hours){
		return true;
	}
	elseif($this->hours == $clockTime->hours){
		if($this->minutes > $clockTime->minutes){
			return true;
		}
		elseif($this->minutes == $clockTime->minutes){
			if($this->seconds > $clockTime->seconds){
				return true;
			}
			else{
				return false;
			}
		}
	}
	else{
		return false;
	}
}





function isEqualTo($clockTime){
	if($this->hours == $clockTime->hours){
		if($this->minutes == $clockTime->minutes){
			if($this->seconds == $clockTime->seconds){
				return true;
			}
			else{
				return false;
			}
		}
		else{
			return false;
		}
	}
	else{
		return false;
	}
}



}//end class





/*
 * collisionCave
 * Given a range of ClockTimes for a Cave and an Intruder, collisionCave
 * returns one of 11 different collision states for these two events.
 * sunmilk,ceiling,stalactite,bat,spelunker,salamander,stalagmite,floor,moonmilk,pillar,wall
 * These states can be used to determine if an appropriate collision is detected
 * between the two events.
 * In the case of OpenRoom, the "Cave" would be the range of the current interval
 * being populated, and the "Intruder" would be a reservation.
*/
function collisionCave($cavestart, $cavestop, $intruderstart, $intruderstop){
	//Sun Milk
	if($cavestart->isGreaterThan($intruderstop) && !($cavestart->isEqualTo($intruderstop))){
		return "sunmilk";
	}
	//Ceiling
	elseif($cavestart->isEqualTo($intruderstop)){
		return "ceiling";
	}
	//Stalactite
	elseif($cavestart->isGreaterThan($intruderstart) && $intruderstop->isGreaterThan($cavestart)){
		return "stalactite";
	}
	//Bat
	elseif($cavestart->isEqualTo($intruderstart) && $cavestop->isGreaterThan($intruderstop)){
		return "bat";
	}
	//Spelunker
	elseif($intruderstart->isGreaterThan($cavestart) && $cavestop->isGreaterThan($intruderstop)){
		return "spelunker";
	}
	//Salamander
	elseif($intruderstart->isGreaterThan($cavestart) && $cavestop->isEqualTo($intruderstop)){
		return "salamander";
	}
	//Floor
	elseif($cavestop->isEqualTo($intruderstart) && $intruderstop->isGreaterThan($cavestop)){
		return "floor";
	}
	//Moon Milk
	elseif($intruderstart->isGreaterThan($cavestop) && $intruderstop->isGreaterThan($cavestop)){
		return "moonmilk";
	}
	//Pillar
	elseif($cavestart->isGreaterThan($intruderstart) && $intruderstop->isGreaterThan($cavestop)){
		return "pillar";
	}
	//Wall
	elseif($cavestart->isEqualTo($intruderstart) && $cavestop->isEqualTo($intruderstop)){
		return "wall";
	}
	else{
		return "empty";
	}
}//end CollisionCave
?>
