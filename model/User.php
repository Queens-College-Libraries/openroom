<?php

namespace model;
class User
{
    private $id;
    private $username;
    private $displayName;
    private $password;
    private $email;
    private $lastLogin;
    private $isActive;
    private $isAdministrator;
    private $isReporter;
    private $isBanned;

    function __construct()
    {
    }

    public static function create()
    {
        $instance = new self();
        return $instance;
    }

    public static function hashPassword($input)
    {
        return password_hash($input, PASSWORD_DEFAULT);
    }

    public function setId($input)
    {
        $this->id = $input;
        return $this;
    }

    public function getIsBanned(): bool
    {
        return $this->isBanned;
    }

    public function setIsBanned($input)
    {
        $this->isBanned = $input;
        return $this;
    }

    public function getIsReporter(): bool
    {
        return $this->isReporter;
    }

    public function setIsReporter($input)
    {
        $this->isReporter = $input;
        return $this;
    }

    public function getIsAdministrator(): bool
    {
        return $this->isAdministrator;
    }

    public function setIsAdministrator($input)
    {
        $this->isAdministrator = $input;
        return $this;
    }

    public function getDisplayName()
    {
        return $this->displayName;
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

    public function getPassword(): string
    {
        return $this->password;
    }

    public function setPassword($input)
    {
        $this->password = $input;
        return $this;
    }

    public function getEmail()
    {
        return $this->email;
    }

    public function setEmail($input)
    {
        $this->email = $input;
        return $this;
    }

    public function getLastLogin()
    {
        return $this->lastLogin;
    }

    public function setLastLogin($input)
    {
        $this->lastlogin = $input;
        return $this;
    }

    public function verifyPassword($input)
    {
        if (password_verify($input, $this->password)) {
            return true;
        } else {
            return false;
        }
    }

    /**
     * @return boolean
     */
    public function getIsActive()
    {
        return $this->isActive;
    }

    public function setIsActive($input)
    {
        $this->isActive = $input;
        return $this;
    }
}
