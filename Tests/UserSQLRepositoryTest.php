<?php

class UserSQLRepositoryTest extends PHPUnit\Framework\TestCase
{

    /**
     * @var PDO
     */
    private
    $pdo;

    public
    function setUp()
    {
        $this->pdo = new PDO($GLOBALS['db_dsn'], $GLOBALS['db_username'], $GLOBALS['db_password']);
        $this->pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        $this->pdo->query("DROP TABLE IF EXISTS users CASCADE");
        $createTable = "CREATE TABLE users  (
  id               SERIAL PRIMARY KEY,
  username         TEXT                        NOT NULL UNIQUE,
  display_name     TEXT,
  password         TEXT                        NOT NULL,
  email            TEXT                        NOT NULL,
  last_login       TIMESTAMP WITHOUT TIME ZONE NOT NULL DEFAULT (now()),
  is_active        BOOLEAN                     NOT NULL DEFAULT FALSE,
  is_administrator BOOLEAN                     NOT NULL DEFAULT FALSE,
  is_reporter      BOOLEAN                     NOT NULL DEFAULT FALSE,
  is_banned        BOOLEAN                     NOT NULL DEFAULT FALSE
);";
        $this->pdo->query($createTable);
    }

    public
    function tearDown()
    {
        if (!$this->pdo) {
            return;
        }
        $this->pdo->query("DROP TABLE users");
    }

    public
    function testAddAdminUser()
    {
        $hashedPassword = \model\User::hashPassword('hunter2');
        $admin = \model\User::create()
            ->setUsername("hunter")
            ->setPassword($hashedPassword)
            ->setDisplayName("Gunter Adams")
            ->setEmail("hikingfan@gmail.com")
            ->setIsActive(TRUE)
            ->setIsBanned(FALSE)
            ->setIsReporter(FALSE)
            ->setIsAdministrator(TRUE);
        \model\UserSQLRepository::saveUser($this->pdo, $admin);
        $adminByUsername = \model\UserSQLRepository::fetchByUsername($this->pdo, "hunter");
        $adminByEmail = \model\UserSQLRepository::fetchByEmail($this->pdo, "hikingfan@gmail.com");
        $this->assertEquals("hunter", $adminByUsername->getUsername());
        $this->assertEquals("hunter", $adminByEmail->getUsername());
        $this->assertTrue($adminByUsername->verifyPassword("hunter2"), 'verify username password');
        $this->assertTrue($adminByEmail->verifyPassword("hunter2"), 'verify email password');
        $this->assertEquals("Gunter Adams", $adminByUsername->getDisplayName());
        $this->assertEquals("Gunter Adams", $adminByEmail->getDisplayName());
        $this->assertEquals("hikingfan@gmail.com", $adminByUsername->getEmail());
        $this->assertEquals("hikingfan@gmail.com", $adminByEmail->getEmail());
//        $this->assertTrue($adminByUsername->getIsActive());
//        $this->assertFalse($adminByEmail->getIsActive());
//        $this->assertTrue($adminByUsername->getIsBanned());
//        $this->assertTrue($adminByEmail->getIsBanned());
//        $this->assertFalse($adminByUsername->getIsReporter());
//        $this->assertFalse($adminByEmail->getIsReporter());
//        $this->assertTrue($adminByUsername->getIsAdministrator());
//        $this->assertTrue($adminByEmail->getIsAdministrator());
    }

    public
    function testMakeUserAdministrator()
    {
        $hashedPassword = \model\User::hashPassword('hunter2');
        $admin = \model\User::create()
            ->setUsername("hunter")
            ->setPassword($hashedPassword)
            ->setDisplayName("Gunter Adams")
            ->setEmail("hikingfan@gmail.com")
            ->setIsActive(TRUE)
            ->setIsBanned(FALSE)
            ->setIsReporter(FALSE)
            ->setIsAdministrator(FALSE);
        \model\UserSQLRepository::saveUser($this->pdo, $admin);
        \model\UserSQLRepository::updateIsAdministrator($this->pdo, $admin->getUsername(), true);
        $hunter1 = \model\UserSQLRepository::fetchByUsername($this->pdo, $admin->getUsername());
        $hunter1IsAdministrator = $hunter1->getIsAdministrator();
        $this->assertTrue($hunter1IsAdministrator, 'test user is administrator');
        \model\UserSQLRepository::updateIsAdministrator($this->pdo, $admin->getUsername(), false);
        $hunter2 = \model\UserSQLRepository::fetchByUsername($this->pdo, $admin->getUsername());
        $hunter2IsAdministrator = $hunter2->getIsAdministrator();
        $this->assertfalse($hunter2IsAdministrator, 'test user is not administrator');
    }
}
