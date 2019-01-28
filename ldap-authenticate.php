<?php
function ConnectLdap($name, $password, $settings)
{
    $ldapserver = $settings["ldap_baseDN"];;
    $qc_username = "qc\\";
    $instr_username = "instr\\";
    $name = trim(htmlspecialchars($name));
    $qc_username .= $name;
    $instr_username .= $name;
    $password = trim(htmlspecialchars($password));
    $ldap = ldap_connect($ldapserver);
    if (!IsNotNullOrEmptyString($name) && !IsNotNullOrEmptyString($password)) {
        if ($bind = ldap_bind($ldap, $qc_username, $password)) {
            return true;
        } else if ($bind = ldap_bind($ldap, $instr_username, $password)) {
            return true;
        } else {
            return false;
        }
    }
    ldap_close($ldap);
    return false;
}

function ReturnEmailAddress($input_username, $settings)
{
    return ReturnParameter($input_username, "mail", $settings);
}

function ReturnDisplayName($input_username, $settings)
{
    return ReturnParameter($input_username, "displayname", $settings);
}

function ReturnParameter($input_username, $input_parameter, $settings)
{
    $ldapserver = $settings["ldap_baseDN"];
    $qc_username = "library2sa";
    $password = "Nicaragua1942!";
    $ldap = ldap_connect($ldapserver);
    if ($bind = ldap_bind($ldap, $qc_username, $password)) {
        $result = ldap_search($ldap, "", "(CN=$input_username)") or die ("Error in search query: " . ldap_error($ldap));
        $data = ldap_get_entries($ldap, $result);
        if (isset($data[0][$input_parameter][0])) {
            return $data[0][$input_parameter][0];

        } else {
            return "fail";
        }
    }
    ldap_close($ldap);
    return "fail";
}

function IsNotNullOrEmptyString($question)
{
    return (!isset($question) || trim($question) === '');
}

// Function to get the client IP address
function get_client_ip()
{
    if (getenv('HTTP_CLIENT_IP'))
        $ipAddress = getenv('HTTP_CLIENT_IP');
    else if (getenv('HTTP_X_FORWARDED_FOR'))
        $ipAddress = getenv('HTTP_X_FORWARDED_FOR');
    else if (getenv('HTTP_X_FORWARDED'))
        $ipAddress = getenv('HTTP_X_FORWARDED');
    else if (getenv('HTTP_FORWARDED_FOR'))
        $ipAddress = getenv('HTTP_FORWARDED_FOR');
    else if (getenv('HTTP_FORWARDED'))
        $ipAddress = getenv('HTTP_FORWARDED');
    else if (getenv('REMOTE_ADDR'))
        $ipAddress = getenv('REMOTE_ADDR');
    else
        $ipAddress = 'UNKNOWN';
    return $ipAddress;
}