<?php
namespace model;
class User
{
    private $username;
    private $displayname;
    private $password;
    private $emailaddress;
    private $lastlogin;
    private $activationCode;
    private $isAdministrator;
    private $isReporter;

    public function __construct($username)
    {
        $this->username = $username;
        $settings = [];
        $db = Db::getInstance();
        $q = $db->query('SELECT * FROM settings');
        foreach ($q->fetchAll() as $row) {
            $settings[$row['settingname']] = $row['settingvalue'];
        }
        $this->emailaddress = $this->ReturnEmailAddress($this->username, $settings);
        if ($settings["login_method"] == "ldap") {
            $this->password = "LDAP";
        } else {
            $this->password = "";
        }
        if ($settings["login_method"] == "ldap") {
            $this->activationCode = "LDAP";
        } else {
            $this->activationCode = "";
        }
        $this->displayname = $this->ReturnDisplayName($this->username, $settings);
        if (Administrator::exists($this->username)) {
            $this->isAdministrator = true;
        } else {
            $this->isAdministrator = false;
        }
        if (Reporter::exists($this->username)) {
            $this->isReporter = true;
        } else {
            $this->isReporter = false;
        }
        // if(!User::exists($this->username))
        // {
        //     try 
        //     {
        //         $db = Db::getInstance();
        //         echo $this->username . " " . $this->password ." " . $this->emailaddress ." " . $this->activationCode;
        //         $req = $db->prepare('INSERT INTO `users`(`username`, `password`, `email`, `active`) VALUES (:username, :password, :emailaddress, :activationCode)');
        //         $req->bindParam(':username', $this->username, \PDO::PARAM_STR, 255);
        //         $req->bindParam(':password', $this->password, \PDO::PARAM_STR, 255);
        //         $req->bindParam(':emailaddress', $this->emailaddress, \PDO::PARAM_STR, 255);
        //         $req->bindParam(':actvationCode', $this->activationCode, \PDO::PARAM_STR, 255);
        //         $req->execute();
        //     } catch (PDOException $e) 
        //     {
        //         echo 'Database connection has failed. Contact system administrator to resolve this issue!<br>';
        //         $e->getMessage();
        //         die();
        //     }
        // }
        // else
        // {
        //     $db = Db::getInstance();
        //     $req = $db->prepare('update `users` set lastlogin = now() where username = :username');
        //     $req->bindParam(':username', $this->get_username(), \PDO::PARAM_STR, 255);
        //     $req->execute();
        // }
    }

    function ReturnEmailAddress($input_username, $settings)
    {
        return $this->ReturnParameter($input_username, "mail", $settings);
    }

    function ReturnParameter($input_username, $input_parameter, $settings)
    {
        $ldapserver = $settings["ldap_baseDN"];
        $qc_username = $settings["service_username"];
        $password = $settings["service_password"];
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

    function ReturnDisplayName($input_username, $settings)
    {
        return $this->ReturnParameter($input_username, "displayname", $settings);
    }

    public static function get_all_users()
    {
        $list = [];
        $db = Db::getInstance();
        $req = $db->query('SELECT * FROM users');

        // we create a list of Post objects from the database results
        foreach ($req->fetchAll() as $user) {
            $list[] = new User($user['username']);
        }

        return $list;
    }

    public static function get_a_specific_user($username)
    {
        $db = Db::getInstance();
        $req = $db->prepare('SELECT * FROM `users` WHERE username = :username');
        $req->execute(array('username' => $username));
        $user = $req->fetch();

        return new User($user['username']);
    }

    public static function exists($username)
    {
        $db = Db::getInstance();
        $req = $db->prepare('SELECT exists(SELECT * FROM `users` WHERE username = :username)');
        $req->execute(array('username' => $username));
        $user = $req->fetch();
        return $user[0];
    }

    public function get_username()
    {
        return $this->username;
    }

    public function get_emailaddress()
    {
        return $this->emailaddress;
    }

    public function get_displayname()
    {
        return $this->displayname;
    }

    public function get_isAdministrator()
    {
        return $this->isAdministrator;
    }

    public function get_isReporter()
    {
        return $this->isReporter;
    }

    function IsNotNullOrEmptyString($question)
    {
        return (!isset($question) || trim($question) === '');
    }

    private function set_user_details()
    {
        $settings = [];
        $db = Db::getInstance();
        $q = $db->query('SELECT * FROM `settings`');
        foreach ($q->fetchAll() as $row) {
            $settings[$row['settingname']] = $row['settingvalue'];
        }
        $this->emailaddress = ReturnEmailAddress($this->username, $settings);
        if ($settings["login_method"] == "ldap") {
            $this->password = "LDAP";
        } else {
            $this->password = "";
        }
        $this->displayname = ReturnDisplayName($this->username, $settings);
        if (Administrator::exists($this->username)) {
            $this->isAdministrator = true;
        } else {
            $this->isAdministrator = false;
        }
        if (Reporter::exists($this->username)) {
            $this->isReporter = true;
        } else {
            $this->isReporter = false;
        }
    }
}
