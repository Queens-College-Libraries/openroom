<?php

namespace model;
class User
{
    public $id;
    public $username;
    public $displayName;
    public $password;
    public $email;
    public $lastLogin;
    public $isActive;
    public $isAdministrator;
    public $isReporter;
    public $isBanned;

    function __construct()
    {
    }

    public static function fetchAll(\PDO $db): array
    {
        $req = $db->prepare('SELECT username, display_name, password, email, last_login, is_active, is_administrator, is_reporter, is_banned FROM users');
        $req->execute();
        $users = array();
        foreach ($req->fetchAll() as $user) {
            array_push($users, User::create()
                ->setUsername($user['username'])
                ->setDisplayName($user['display_name'])
                ->setPassword($user['password'])
                ->setEmail($user['email'])
                ->setLastLogin($user['last_login'])
                ->setIsActive($user['is_active'])
                ->setIsAdministrator($user['is_administrator'])
                ->setIsReporter($user['is_reporter'])
                ->setIsBanned($user['is_banned']));
        }
        $req = null;
        $db = null;
        return $users;
    }

    public static function fetchCount(\PDO $db): int
    {
        return $db->query('select count(*) from Users')->fetchColumn();
    }


    public function setIsBanned($input)
    {
        $this->isBanned = $input;
        return $this;
    }

    public function setIsReporter($input)
    {
        $this->isReporter = $input;
        return $this;
    }

    public function setIsAdministrator($input)
    {
        $this->isAdministrator = $input;
        return $this;
    }

    public function setIsActive($input)
    {
        $this->isActive = $input;
        return $this;
    }

    public function setLastLogin($input)
    {
        $this->lastlogin = $input;
        return $this;
    }

    public function setEmail($input)
    {
        $this->email = $input;
        return $this;
    }

    public function setPassword($input)
    {
        $this->password = password_hash($input, PASSWORD_DEFAULT);
        return $this;
    }

    public function setDisplayName($input)
    {
        if ($input != null) {
            $this->displayName = $input;
        } else {
            $this->displayName = $this->getUsername();
        }
        return $this;
    }

    public function getUsername()
    {
        return $this->username;
    }

    public function setUsername($input)
    {
        $this->username = $input;
        return $this;
    }

    public static function create()
    {
        $instance = new self();
        return $instance;
    }

    public static function fetchByUsername(\PDO $db, $username)
    {
        echo $username;
        $req = $db->prepare('SELECT username, display_name, password, email, last_login, is_active, is_administrator, is_reporter, is_banned FROM users WHERE username = :username');
        $req->execute(array('username' => $username));
        $user = $req->fetch();
        return User::create()
            ->setUsername($user['username'])
            ->setDisplayName($user['display_name'])
            ->setPassword($user['password'])
            ->setEmail($user['email'])
            ->setLastLogin($user['last_login'])
            ->setIsActive($user['is_active'])
            ->setIsAdministrator($user['is_administrator'])
            ->setIsReporter($user['is_reporter'])
            ->setIsBanned($user['is_banned']);
    }

    public static function removeUser(\PDO $db, $username)
    {
        $req = $db->prepare('DELETE FROM users WHERE username = :username');
        $req->bindParam(':username', $username, \PDO::PARAM_STR, 255);
        $req->execute();
    }

    public function getEmail()
    {
        return $this->email;
    }

    public function getDisplayName()
    {
        return $this->displayName;
    }

    public function getPassword()
    {
        return $this->password;
    }

    public function getLastLogin()
    {
        return $this->lastLogin;
    }

    function fetchByEmail(\PDO $db, $email)
    {
        $req = $db->prepare('SELECT username, display_name, password, email, last_login, is_active, is_administrator, is_reporter, is_banned FROM users WHERE email = :email LIMIT 1');
        $req->execute(array('email' => $email));
        $user = $req->fetch();
        return User::create()
            ->setUsername($user['username'])
            ->setDisplayName($user['display_name'])
            ->setPassword($user['password'])
            ->setEmail($user['email'])
            ->setLastLogin($user['last_login'])
            ->setIsActive($user['is_active'])
            ->setIsAdministrator($user['is_administrator'])
            ->setIsReporter($user['is_reporter'])
            ->setIsBanned($user['is_banned']);
    }

    // INSERT INTO users (username, display_name, password, email) VALUES ('kushal', 'kushal', '$2b$12$bVGt6HWAxldbT4f2krB02uPQJTv6vWlWZjVH33.JdbP6ToA4THt2W', 'khada@qc.cuny.edu')

    public static function addUser(\PDO $db, \model\User $user)
    {
        $username = $user->getUsername();
        $displayname = $user->getDisplayName();
        $password = $user->getPassword();
        $email = $user->getEmail();
        $req = $db->prepare('INSERT INTO users (username, display_name, password, email) VALUES (:username, :display_name, :password, :email)');
        $req->bindParam(':username', $username, \PDO::PARAM_STR, 255);
        $req->bindParam(':display_name', $displayname, \PDO::PARAM_STR, 255);
        $req->bindParam(':password', $password, \PDO::PARAM_STR, 255);
        $req->bindParam(':email', $email, \PDO::PARAM_STR, 255);
        $req->execute();
        $req = null;
    }

    public function verifyPassword($input)
    {
        if (password_verify($input, $this->password)) {
            return true;
        } else {
            return false;
        }
    }

    public function addUserLdap($username, $ldap_baseDN, $service_username, $service_password)
    {
        $this->setUsername($username);
        $this->setEmail($this->ReturnEmailAddress($username, $ldap_baseDN, $service_username, $service_password));
        $this->setDisplayname($this->ReturnDisplayName($username, $ldap_baseDN, $service_username, $service_password));
        return $this;
    }

    function ReturnEmailAddress($inputUsername, $ldap_baseDN, $service_username, $service_password)
    {
        return $this->ReturnParameter($inputUsername, "mail", $ldap_baseDN, $service_username, $service_password);
    }

    function ReturnParameter($inputUsername, $inputParameter, $ldapServer, $service_username, $service_password)
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

    function ReturnDisplayName($inputUsername, $ldap_baseDN, $service_username, $service_password)
    {
        return $this->ReturnParameter($inputUsername, "displayname", $ldap_baseDN, $service_username, $service_password);
    }

    function IsNotNullOrEmptyString($question)
    {
        return (!isset($question) || trim($question) === '');
    }

}
