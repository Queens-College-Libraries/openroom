<?php

namespace model;
class UserLDAPRepository implements UserRepositoryReadInterface
{
    public static function ConnectLdap($name, $password, $ldapServer)
    {
        $qc_username = "qc\\";
        $instr_username = "instr\\";
        $name = trim(htmlspecialchars($name));
        $qc_username .= $name;
        $instr_username .= $name;
        $password = trim(htmlspecialchars($password));
        $ldap = ldap_connect($ldapServer);
        sleep(1);
        if ($bind = ldap_bind($ldap, $qc_username, $password)) {
            ldap_close($ldap);
            return true;
        } else if ($bind = ldap_bind($ldap, $instr_username, $password)) {
            ldap_close($ldap);
            return true;
        } else {
            ldap_close($ldap);
            return false;
        }
    }

    public static function fetchByEmail(\PDO $db, string $email): User
    {
        // TODO: Implement fetchByEmail() method.
        // I don't think I need it but we will see
    }

    public static function fetchByUsername(\PDO $db, string $username): User
    {
        $ldapBaseDN = Setting::fetchValue($db, "ldapBaseDN");
        $serviceUsername = Setting::fetchValue($db, "username");
        $servicePassword = Setting::fetchValue($db, "password");
        return self::fetchByUsernameLDAP($db, $username, $ldapBaseDN, $serviceUsername, $servicePassword);
    }

    public static function fetchByUsernameLDAP(\PDO $db, $username, $ldapBaseDN, $serviceUsername, $servicePassword): User
    {
        $newUser = User::create()
            ->setUsername($username)
            ->setEmail(self::ReturnEmailAddress($db, $username, $ldapBaseDN, $serviceUsername, $servicePassword))
            ->setDisplayname(self::ReturnDisplayName($db, $username, $ldapBaseDN, $serviceUsername, $servicePassword));
        return $newUser;
    }

    private static function ReturnEmailAddress($db, $inputUsername, $ldapBaseDN, $serviceUsername, $servicePassword)
    {
        return self::ReturnParameter($inputUsername, "mail", $ldapBaseDN, $serviceUsername, $servicePassword);
    }

    public static function ReturnParameter($inputUsername, $inputParameter, $ldapServer, $service_username, $service_password)
    {
        $ldap = ldap_connect($ldapServer);
        if ($bind = ldap_bind($ldap, $service_username, $service_password)) {
            $result = ldap_search($ldap, "", "(CN=$inputUsername)") or die ("Error in search query: " . ldap_error($ldap));
            $data = ldap_get_entries($ldap, $result);
            if (isset($data[0][$inputParameter][0])) {
                return $data[0][$inputParameter][0];
            }
        }
        ldap_close($ldap);
        return "fail";
    }

    public static function ReturnDisplayName($db, $inputUsername, $ldapBaseDN, $serviceUsername, $servicePassword)
    {
        return self::ReturnParameter($inputUsername, "displayname", $ldapBaseDN, $serviceUsername, $servicePassword);
    }

    function IsNotNullOrEmptyString($question)
    {
        return (!isset($question) || trim($question) === '');
    }

}