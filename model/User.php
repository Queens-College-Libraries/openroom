<?php
declare(strict_types=1);
namespace model;

// MariaDB [openroom]> describe users;
// +-----------+--------------+------+-----+-------------------+-----------------------------+
// | Field     | Type         | Null | Key | Default           | Extra                       |
// +-----------+--------------+------+-----+-------------------+-----------------------------+
// | username  | varchar(255) | NO   | PRI | NULL              |                             |
// | password  | varchar(255) | NO   |     | NULL              |                             |
// | email     | varchar(255) | NO   |     | NULL              |                             |
// | lastlogin | timestamp    | NO   |     | CURRENT_TIMESTAMP | on update CURRENT_TIMESTAMP |
// | active    | varchar(255) | NO   |     | 0                 |                             |
// +-----------+--------------+------+-----+-------------------+-----------------------------+
// 5 rows in set (0.009 sec)


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
        $q = $db->query('SELECT * FROM `settings`');
        foreach ($q->fetchAll() as $row) {
            $settings[$row['settingname']] = $row['settingvalue'];
        }
        $this->emailaddress = $this->ReturnEmailAddress($this->username, $settings);
        if(\model\Setting::find("login_method") == "ldap") {
            $this->password = "LDAP";
            $this->activationCode = "LDAP";
            $this->displayname = $this->ReturnDisplayName($this->username, $settings);
        } else {
            $db = Db::getInstance();
            $req = $db->prepare('SELECT username, password, email, lastlogin, active FROM users WHERE username = :username');
            $req->execute(array('username' => $username));
            $user = $req->fetch();
            $this->username = $user['username'];
            $this->displayname = $user['username'];
            $this->password = $user['password'];
            $this->email = $user['email'];
            $this->lastlogin = $user['lastlogin'];
            $this->active = $user['active'];
        }
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

    public static function getPasswordHash(\PDO $db, string $username)
    {
        $req = $db->prepare("SELECT password FROM users WHERE username = :username");
        $req->execute(array('username' => $username));
        $password = $req->fetch();
        return $password[0];
    }

    public static function getIsActive(\pdo $db, string $username): int
    {
        $req = $db->prepare("SELECT active FROM users WHERE username = :username");
        $req->execute(array('username' => $username));
        $active = $req->fetch();
        return (int)$active[0];
    }

    function ReturnEmailAddress($input_username, $settings)
    {
        return $this->ReturnParameter($input_username, "mail", $settings);
    }

    function ReturnParameter($input_username, $input_parameter, $settings)
    {
        if ($settings["login_method"] == "ldap") {
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
        return "fail";
    }

    function ReturnDisplayName($input_username, $settings)
    {
        return $this->ReturnParameter($input_username, "displayname", $settings);
    }

    public static function getAllUsers(\PDO $db)
    {
        $req = $db->query('SELECT * FROM `users`');
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
