<?php
//configuration.php
/*
*This file contains configuration information required for OpenRoom's install.php
*/

//Administrative User
/*
 * This will set the administrative user.
 * You only need to set the username. Once the system is installed, register a new
 * user using this username, and it will become an administrator.
 * (For LDAP authentication, you must provide a username for the person that you
 * wish to be the initial administrator.)
*/
$admin_user = "admin";

//Name
/*
 * This will set the name of this instance of OpenRoom.
 * Default is "OpenRoom".
*/
$instance_name = "OpenRoom";

//URL
/*
 * This is the URL you will use to access OpenRoom.
 * This should be the same address you provide to users.
 * DO NOT include protocol (http:// or https://) or filenames (index.html).
*/
$instance_url = "www.example.com/openroom/";

//Theme
/*
 * This will set the theme of the system to any custom theme you have installed under
 * the themes directory. The name of the theme should just be the name of the folder.
 * This is set to "default" by default.
*/
$theme = "default";

//SSL
/*
************IMPORTANT************
*Set this value to FALSE if you are NOT using a secure connection (https).
*WARNING: SETTING THIS VALUE TO FALSE WILL CAUSE THIS APPLICATION TO TRANSMIT PASSWORDS AS PLAIN TEXT,
*COMPROMISING SECURITY. PLEASE LEAVE THIS AT ITS DEFAULT SETTING UNLESS YOU HAVE NO OTHER CHOICE.
*Setting this value to TRUE will add the https protocol where appropriate to insure security.
*/
$https = "true";


//Login Method
/*
*"normal"
*Users will need to register within the system in order to log in.
*"ldap"
*Users will be granted access as long as they authenticate against your LDAP server.
*/
$login_method = "ldap";


//LDAP Settings
/*
*$host contains the host name of your ldap server
*$baseDN contains the base dn settings for you ldap server
*/
$ldap_host = "";
$ldap_baseDN = "";


//Email Filter
/*
*Please change this setting to the domain name you expect your users to use when
*registering with an email address. Do NOT include an "@" symbol.
*Example: yourdomain.com
*If you would like to allow ANY email address, leave this value blank ("");
*If you have more than one domain to filter, see the example below:
*$email_filter = array("domain1.com", "domain2.com", "domain3.edu");
*WHEN USING THE "normal" LOGIN METHOD ABOVE, PLEASE PROVIDE AN EMAIL FILTER.
*LEAVING THE EMAIL FILTER BLANK WHEN USING THE "normal" LOGIN METHOD MAY COMPROMISE SECURITY.
*THIS SETTING ALLOWS YOU TO RESTRICT USERS TO ONLY THOSE WHO USE YOUR EMAIL SYSTEM.
*/
$email_filter = array("bsu.edu");



//Interval
/*
 * Default: 30 minutes
 * This value, in minutes, changes the way the DayView calendar is displayed and controls the
 * granularity between reservations. ONLY change this if you intend to allow
 * reservations of different durations than 30 minute blocks.
*/
$interval = 30;



//Time Format
/*
 * Default: "g:i a" - presents time in the fashion of "8:32 am" "6:30 pm"
 * This string uses the same predefined date characters as the PHP date()
 * function ( http://us2.php.net/manual/en/function.date.php ).
*/
$time_format = "g:i a";


//Reservation Limits
/*
 * This section includes settings for limiting users on how many or how long
 * their reservations may be.
 * There are three ways to limit users: duration, total, frequency, and window.
 * 
 * Duration
 * Limiting duration will place a limit on how long a single reservation may be.
 * Example: Users can make reservations at a maximum duration of 4 hours each.
 * Duration must be specified in minutes. 0 means there is no limit. (Not recommended.)
 * 
 * Total
 * Limiting totals will place a limit on the total amount of time that may be reserved
 * during a specified time period. The available periods are day, week, month, and year.
 * Example: Users can make any combination of reservations that total up to no more
 * than 8 hours per week.
 * Total must be specified in minutes. 0 means there is no limit.
 * 
 * Frequency
 * Limiting frequency will place a limit on how many reservations may be made during
 * a specified time period. The available periods are day, week, month, and year.
 * Example: Users can make a maximum of 6 reservations per week.
 * Frequency must be specified in maximum number of reservations. 0 means there is no limit.
 * 
 * Reservations are counted by their start date and time. So if a reservation runs
 * into the next day, it does not count for that day, only for the day it started on.
 * 
 * Window
 * The Window limit allows users to make reservations only within a certain time range.
 * This allows you to prevent users from making reservations 10 years into the future
 * that they can't fulfill. The Window range always starts at the current time, and
 * ends at either a specified date, or a dynamic duration.
 * For example, if the Window is specified to be 5/28/2010, reservations will be denied
 * after that date. If the Window is set to 7 days, reservations will be denied 7 days
 * away from the current time.
 * The Window range is specified like so: a number indicating a duration, and day, week,
 * month, or year indicating a type. When specifying a date (such as 5/28/2010), the number
 * should be 0, and the date ([m]m/[d]d/yyyy) (NO leading zeroes) should replace type.
 * Example1: array(6,"month")  The window ends 6 months from the current time.
 * Example2: array(0,"5/28/2010")  The window ends on 5/28/2010.
 * 
 * COMBINATIONS
 * If more than one of these settings is configured, combinations work thusly:
 * When a reservation is made, first the Frequency is checked, then the total, then duration.
 * If any of these checks fail, the reservation can not be made.
 * 
 * In the default values below, users may make reservations of a lengh of up to 4 hours each,
 * and may make no more than 4 hours (240) worth or reservations per day.
*/
$limit_duration = 240;
$limit_total = array(240,"day");
$limit_frequency = array(0,"day");
$limit_window = array(6,"month");
?>
