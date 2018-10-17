<?php

// describe rooms;
// +-----------------+--------------+------+-----+---------+----------------+
// | Field           | Type         | Null | Key | Default | Extra          |
// +-----------------+--------------+------+-----+---------+----------------+
// | roomid          | int(11)      | NO   | PRI | NULL    | auto_increment |
// | roomname        | varchar(255) | NO   |     | NULL    |                |
// | roomposition    | int(11)      | NO   |     | NULL    |                |
// | roomcapacity    | int(11)      | NO   |     | NULL    |                |
// | roomgroupid     | bigint(20)   | NO   |     | NULL    |                |
// | roomdescription | longtext     | NO   |     | NULL    |                |
// +-----------------+--------------+------+-----+---------+----------------+
// 6 rows in set (0.00 sec)

declare(strict_types=1);

namespace model;
class Room
{
    private $id;
    private $name;
    private $position;
    private $capacity;
    private $groupId;
    private $description;

    public function __construct($id, $name, $position, $capacity, $groupId, $description)
    {
        $this->id = $id;
        $this->name = $name;
        $this->position = $position;
        $this->capacity = $capacity;
        $this->groupId = $groupId;
        $this->description = $description;
    }

    public static function getSpecificRoom(\PDO $db, int $id)
    {
        $req = $db->prepare("SELECT roomid, roomname, roomposition, roomcapacity, roomgroupid, roomdescription FROM rooms WHERE roomid = :id");
        $req->execute(array('id' => $id));
        $room = $req->fetch();
        return new Room($room['roomid'], $room['roomname'], $room['roomposition'], $room['roomcapacity'], $room['roomgroupid'], $room['roomdescription']);
    }

    /**
     * @return int
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * @param int $id
     */
    public function setId($id)
    {
        $this->id = $id;
    }

    /**
     * @return mixed
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * @param mixed $name
     */
    public function setName($name)
    {
        $this->name = $name;
    }

    /**
     * @return mixed
     */
    public function getPosition()
    {
        return $this->position;
    }

    /**
     * @param mixed $position
     */
    public function setPosition($position)
    {
        $this->position = $position;
    }

    /**
     * @return mixed
     */
    public function getCapacity()
    {
        return $this->capacity;
    }

    /**
     * @param mixed $capacity
     */
    public function setCapacity($capacity)
    {
        $this->capacity = $capacity;
    }

    /**
     * @return mixed
     */
    public function getGroupId()
    {
        return $this->groupId;
    }

    /**
     * @param mixed $groupId
     */
    public function setGroupId($groupId)
    {
        $this->groupId = $groupId;
    }

    /**
     * @return mixed
     */
    public function getDescription()
    {
        return $this->description;
    }

    /**
     * @param mixed $description
     */
    public function setDescription($description)
    {
        $this->description = $description;
    }
}
