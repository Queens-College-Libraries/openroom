<?php
require_once('vendor/autoload.php');
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


/**
 * @param string $username
 * @param string $password
 * @param array $settings
 * @return bool
 */
function AuthenticateUser(string $username, string $password, string $ldap_baseDN, string $service_username, string $service_password): bool
{
    if (\model\User::ConnectLdap($username, $password, $ldap_baseDN)) {
        return true;
    }
    return false;
}


$username = isset($_POST["username"]) ? $_POST["username"] : "";
$password = isset($_POST["username"]) ? $_POST["password"] : "";
$ajax_indicator = isset($_POST["ajax_indicator"]) ? $_POST["ajax_indicator"] : "FALSE";
$output = "<?xml version=\"1.0\" encoding=\"ISO-8859-1\"?>\n<authresponse>\n";
if ($username != "" && $password != "" && $ajax_indicator != "") {
    if (model\Setting::fetchValue(\model\Db::getInstance(), 'login_method') == "ldap") {
        $ldap_baseDN = model\Setting::fetchValue(\model\Db::getInstance(), 'ldap_baseDN');
        $service_username = model\Setting::fetchValue(\model\Db::getInstance(), 'service_username');
        $service_password = model\Setting::fetchValue(\model\Db::getInstance(), 'service_password');
        if (AuthenticateUser($username, $password, $ldap_baseDN, $service_username, $service_password)) {
            $isAuthenticated = true;
        } else {
            $isAuthenticated = false;
            $output .= "\t<errormessage>" . "Sorry, authentication failed." . "</errormessage>\n";
        }
        if (!$isAuthenticated) {
            $output .= "\t<authenticated>false</authenticated>\n";
        } else {
            if (\model\User::fetchByUsername($db, $username)->getIsBanned() != true) {
                $_SESSION["systemid"] = model\Setting::fetchValue(\model\Db::getInstance(), 'systemid');
                $_SESSION["username"] = $username;
                $_SESSION["displayname"] = \model\User::ReturnDisplayName($db, $username, $ldap_baseDN, $service_username, $service_password);
                $_SESSION["emailaddress"] = \model\User::ReturnEmailAddress($db, $username, $ldap_baseDN, $service_username, $service_password);
                $output .= "\t<errormessage></errormessage>\n";
                $output .= "\t<authenticated>true</authenticated>\n";
                //Check if logged in user is an administrator
                if (\model\User::fetchByUsername($db, $username)->getIsAdministrator() == true) {
                    $_SESSION["isadministrator"] = "TRUE";
                    $output .= "\t<isadministrator>true</isadministrator>\n";
                } else {
                    $_SESSION["isadministrator"] = "FALSE";
                    $output .= "\t<isadministrator>false</isadministrator>\n";
                }
                //Check if logged in user is a reporter
                $rresult = mysql_query("SELECT * FROM reporters WHERE username='" . $username . "';");
                if (mysql_num_rows($rresult) == 1) {
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
    elseif (model\Setting::fetchValue(\model\Db::getInstance(), 'login_method') == "normal") {
//        $encpass = sha1($password);
        $claimed_user = \model\User::fetchByUsername(\model\Db::getInstance(), $username);
        if ($claimed_user->verifyPassword($password)) {
            $claimed_user->setIsActive(true);
            if (!$claimed_user->getIsBanned()) {
                $claimed_user->setLastLogin(date("Y-m-d H:i:s"));
                $_SESSION["systemid"] = model\Setting::fetchValue(\model\Db::getInstance(), "systemid");
                $_SESSION["username"] = $username;
                if ($claimed_user->getIsAdministrator()) {
                    $_SESSION["isadministrator"] = "TRUE";
                    $output .= "\t<isadministrator>true</isadministrator>\n";
                } else {
                    $_SESSION["isadministrator"] = "FALSE";
                    $output .= "\t<isadministrator>false</isadministrator>\n";
                }
                if ($claimed_user->getIsReporter()) {
                    $_SESSION["isreporter"] = "TRUE";
                    $output .= "\t<isreporter>true</isreporter>\n";
                } else {
                    $_SESSION["isreporter"] = "FALSE";
                    $output .= "\t<isreporter>false</isreporter>\n";
                }
            } else {
                $output .= "\t<errormessage>This user has been banned or has not activated their account. Please contact an administrator to fix this problem.</errormessage>\n";
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