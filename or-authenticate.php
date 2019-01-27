<?php
if (!isset($_SESSION)) {
    if (session_status() == PHP_SESSION_NONE) {
        session_start();
    }
}

$_SESSION["systemid"] = "";
$_SESSION["username"] = "";
$_SESSION["isadministrator"] = "FALSE";
$_SESSION["isreporter"] = "FALSE";


/*
*or-authenticate.php(POST:username,password,ajax_indicator)
*
*This file receives three parameters, a username, a password, and ajax_indicator from $_POST[].
*The file checks db->settings->login_method.
*If "normal" the username and password are checked against db->users.
*If "ldap" the username and password are checked against the provided ldap connection.
*An XML response is formed and the SESSION variable "username" is set on success.
*If ajax_indicator is TRUE(1) this file returns with headers type text/xml, allowing it to be used by AJAX.
*If ajax_indicator is FALSE(0) this file returns all text with no headers, allowing it to be used by PHP and converted to a string.
*
*USAGE
*To use this file with AJAX, simply call it using open() sending the following parameters over POST: username, password, TRUE.
*To pull this file's data into a string using PHP, set the POST variables before including the file:
*$_POST["username"] = "test";
*$_POST["password"] = "test";
*$_POST["ajax_indicator"] = FALSE;
*$xmloutput = include("or-authenticate.php");
*Then you may wish to convert $xmloutput into a simpleXML object
*/
require_once("includes/or-dbinfo.php");

/*
*AuthenticateUser()
*Function Written by: Tim Sprowl
*Date: 2008
*/
/**
 * @param $username
 * @param $password
 * @param $settings
 * @return bool
 * @throws Exception
 */

require_once 'ldap-authenticate.php';
/**
 * @param string $username
 * @param string $password
 * @param array $settings
 * @return bool
 */
function AuthenticateUser(string $username, string $password, array $settings): bool
{
    if (ConnectLdap($username, $password, $settings)) {
        return true;
    }
    return false;
}


$username = isset($_POST["username"]) ? $_POST["username"] : "";
$password = isset($_POST["username"]) ? $_POST["password"] : "";
$username = stripslashes($username);
$ajax_indicator = isset($_POST["ajax_indicator"]) ? $_POST["ajax_indicator"] : "FALSE";
$output = "<?xml version=\"1.0\" encoding=\"ISO-8859-1\"?>\n<authresponse>\n";
if ($username != "" && $password != "" && $ajax_indicator != "") {
    if ($settings["login_method"] == "ldap") {
        if (AuthenticateUser($username, $password, $settings)) {
            $isAuthenticated = true;
        } else {
            $isAuthenticated = false;
            $output .= "\t<errormessage>" . "Sorry, authentication failed." . "</errormessage>\n";
        }
        if (!$isAuthenticated) {
            $output .= "\t<authenticated>false</authenticated>\n";
        } else {
            if (mysqli_num_rows(mysqli_query($GLOBALS["___mysqli_ston"], "SELECT * FROM bannedusers WHERE username='" . $username . "';")) <= 0) {
                $_SESSION["systemid"] = $settings["systemid"];
                $_SESSION["username"] = $username;
                $_SESSION["displayname"] = ReturnDisplayName($username, $settings);
                $_SESSION["emailaddress"] = ReturnEmailAddress($username, $settings);
                $output .= "\t<errormessage></errormessage>\n";
                $output .= "\t<authenticated>true</authenticated>\n";
                //Check if logged in user is an administrator
                $aresult = mysqli_query($GLOBALS["___mysqli_ston"], "SELECT `username` FROM administrators WHERE username='" . $username . "';");
                if (mysqli_num_rows($aresult) == 1) {
                    $_SESSION["isadministrator"] = "TRUE";
                    $output .= "\t<isadministrator>true</isadministrator>\n";
                } else {
                    $_SESSION["isadministrator"] = "FALSE";
                    $output .= "\t<isadministrator>false</isadministrator>\n";
                }
                //Check if logged in user is a reporter
                $rresult = mysqli_query($GLOBALS["___mysqli_ston"], "SELECT * FROM reporters WHERE username='" . $username . "';");
                if (mysqli_num_rows($rresult) == 1) {
                    $_SESSION["isreporter"] = "TRUE";
                    $output .= "\t<isreporter>true</isreporter>\n";
                } else {
                    $_SESSION["isreporter"] = "FALSE";
                    $output .= "\t<isreporter>false</isreporter>\n";
                }
            } else {
                $output .= "\t<errormessage>This user has been banned. Please contact an administrator to fix this problem.</errormessage>\n";
                $output .= "\t<authenticated>false</authenticated>\n";
                $_SESSION["systemid"] = "";
                $_SESSION["username"] = "";
                $_SESSION["isadministrator"] = "FALSE";
                $_SESSION["isreporter"] = "FALSE";
            }
        }
    } //Normal
    elseif ($settings["login_method"] == "normal") {
        $hash = \model\User::getPasswordHash(\model\Db::getInstance(), $username);
        if (password_verify($password, $hash)) {
            $isBanned = \model\BannedUser::isBanned(\model\Db::getInstance(), $username);
            $isActive = \model\User::getIsActive(\model\db::getInstance(), $username);
            if (!$isBanned && $isActive == "0") {
                //Set lastlogin time
                $llresult = mysqli_query($GLOBALS["___mysqli_ston"], "UPDATE users SET lastlogin=NOW() WHERE username='" . $username . "';");
                if ($llresult) {
                    //Set session for user
                    $_SESSION["systemid"] = $settings["systemid"];
                    $_SESSION["username"] = $username;
                    $output .= "\t<errormessage></errormessage>\n";
                    $output .= "\t<authenticated>true</authenticated>\n";
                    //Check if logged in user is an administrator
                    $aresult = mysqli_query($GLOBALS["___mysqli_ston"], "SELECT * FROM administrators WHERE username='" . $username . "';");
                    if (mysqli_num_rows($aresult) == 1) {
                        $_SESSION["isadministrator"] = "TRUE";
                        $output .= "\t<isadministrator>true</isadministrator>\n";
                    } else {
                        $_SESSION["isadministrator"] = "FALSE";
                        $output .= "\t<isadministrator>false</isadministrator>\n";
                    }
                    //Check if logged in user is a reporter
                    $rresult = mysqli_query($GLOBALS["___mysqli_ston"], "SELECT * FROM reporters WHERE username='" . $username . "';");
                    if (mysqli_num_rows($rresult) == 1) {
                        $_SESSION["isreporter"] = "TRUE";
                        $output .= "\t<isreporter>true</isreporter>\n";
                    } else {
                        $_SESSION["isreporter"] = "FALSE";
                        $output .= "\t<isreporter>false</isreporter>\n";
                    }
                } else {
                    $output .= "\t<authenticated>false</authenticated>\n\t<errormessage>Could not set last login time.</errormessage>\n";
                }
            } else {
                $output .= "\t<errormessage>" . $isBanned . "This user has been banned or has not activated their account. Please contact an administrator to fix this problem.</errormessage>\n";
                $output .= "\t<authenticated>false</authenticated>\n";
                $_SESSION["systemid"] = "";
                $_SESSION["username"] = "";
                $_SESSION["isadministrator"] = "FALSE";
                $_SESSION["isreporter"] = "FALSE";
            }
        } else {
            $output .= "\t<authenticated>false</authenticated>\n\t<errormessage>Incorrect username or password. Please try again.</errormessage>\n";
        }
    }
} else {
    $output .= "\t<authenticated>false</authenticated>\n\t<errormessage>One or more parameters not provided.</errormessage>\n";
}

$output .= "</authresponse>";

if ($ajax_indicator == "TRUE") {
    header("content-type: text/xml");
    echo $output;
} else {
    return $output;
}

?>