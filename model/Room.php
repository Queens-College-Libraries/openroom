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

    public function __construct($id, $name, int $position, int $capacity, int $groupId, $description)
    {
        $this->id = $id;
        $this->name = $name;
        $this->position = $position;
        $this->capacity = $capacity;
        $this->groupId = $groupId;
        $this->description = $description;
    }

    public function save(\PDO $db)
    {
        $req = $db->prepare("UPDATE rooms SET roomname = :roomname, roomposition = :position, roomcapacity = :capacity, roomgroupid = :groupId, roomdescription = :roomdescription where roomid = :id");
        $req->bindValue(":id", $this->getId());
        $req->bindValue(":roomname", $this->getName());
        $req->bindValue(":position", $this->getPosition());
        $req->bindValue(":capacity", $this->getCapacity());
        $req->bindValue(":groupId", $this->getGroupId());
        $req->bindValue(":roomdescription", $this->getDescription());
        $req->execute();
    }

    public static function getSpecificRoom(\PDO $db, int $id)
    {
        $req = $db->prepare("SELECT roomid, roomname, roomposition, roomcapacity, roomgroupid, roomdescription FROM rooms WHERE roomid = :id");
        $req->execute(array('id' => $id));
        $room = $req->fetch();
        return new Room((int)$room['roomid'], $room['roomname'], (int)$room['roomposition'], (int)$room['roomcapacity'], (int)$room['roomgroupid'], $room['roomdescription']);
    }

    public static function getSpecificRoomByPosition(\PDO $db, int $position, int $groupId)
    {
        $req = $db->prepare("SELECT roomid, roomname, roomposition, roomcapacity, roomgroupid, roomdescription FROM rooms WHERE roomposition = :position and roomgroupid = :groupId LIMIT 1");
        $req->execute(array('position' => $position, 'groupId' => $groupId));
        $room = $req->fetch();
        return new Room((int)$room['roomid'], $room['roomname'], (int)$room['roomposition'], (int)$room['roomcapacity'], (int)$room['roomgroupid'], $room['roomdescription']);
    }

    public static function updateRoomPosition(\PDO $db, int $newPosition, int $oldPosition, int $groupId)
    {
        $req = $db->prepare("UPDATE rooms SET roomposition = :newPosition where roomposition = :oldPosition and roomgroupid = :groupId");
        $req->bindValue(":newPosition", $newPosition);
        $req->bindValue(":oldPosition", $oldPosition);
        $req->bindValue(":groupId", $groupId);
        $req->execute();
    }

    public static function incrementRoomPosition(\PDO $db, int $id)
    {
        // get room from room id
        $currentRoom = \model\Room::getSpecificRoom($db, $id);
        $nextRoom = \model\Room::getSpecificRoomByPosition($db, $currentRoom->getPosition() + 1, $currentRoom->getGroupId());
        if($nextRoom->getPosition() < \model\Room::getRoomCountInGroup($db, $nextRoom->getGroupId()))
        {
            $currentRoomPosition = $currentRoom->getPosition();
            $nextRoomPosition = $nextRoom->getPosition();
            $currentRoom->setPosition($nextRoomPosition);
            $nextRoom->setPosition($currentRoomPosition);
            $currentRoom->save($db);
            $nextRoom->save($db);
        }
    }

    public static function decrementRoomPosition(\PDO $db, int $id)
    {
        // get room from room id
        $currentRoom = \model\Room::getSpecificRoom($db, $id);
        $nextRoom = \model\Room::getSpecificRoomByPosition($db, $currentRoom->getPosition() - 1, $currentRoom->getGroupId());
        if($currentRoom->getPosition() > 0)
        {
            $currentRoomPosition = $currentRoom->getPosition();
            $nextRoomPosition = $nextRoom->getPosition();
            $currentRoom->setPosition($nextRoomPosition);
            $nextRoom->setPosition($currentRoomPosition);
            $currentRoom->save($db);
            $nextRoom->save($db);
        }
    }

    public static function getRoomCountInGroup(\pdo $db, int $groupId): int
    {
        $req = $db->prepare("SELECT count(*) FROM rooms WHERE roomgroupid = :groupId");
        $req->execute(array('groupId' => $groupId));
        $count = $req->fetch();
        return (int)$count[0];
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
