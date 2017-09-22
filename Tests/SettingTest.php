<?php

class SettingTest extends PHPUnit\Framework\TestCase
{
    /**
     * @var PDO
     */
    private $pdo;

    public function setUp()
    {
        $this->pdo = new PDO($GLOBALS['db_dsn'], $GLOBALS['db_username'], $GLOBALS['db_password']);
        $this->pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        $this->pdo->query("DROP TABLE IF EXISTS settings CASCADE");
        $createTable = "CREATE TABLE settings  (
  id    SERIAL PRIMARY KEY,
  name  TEXT UNIQUE,
  value TEXT
);";
        $this->pdo->query($createTable);
    }

    public function tearDown()
    {
        if (!$this->pdo) {
            return;
        }
        $this->pdo->query("DROP TABLE settings");
    }

    public function testAddSetting()
    {
        $settingName = "OrganizationName";
        $settingValue = "Rosenthal Library at Queens College";
        $setting = \model\Setting::create()->setName($settingName)->setValue($settingValue);
        \model\SettingRepository::addSetting($this->pdo, $setting);
        $returnedValue = \model\Setting::fetchValue($this->pdo, "OrganizationName");
        $this->assertEquals("Rosenthal Library at Queens College", $returnedValue);
    }
}
