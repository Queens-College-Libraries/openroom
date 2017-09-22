<?php

namespace model;
class Group
{
    private $id;
    private $name;

    /**
     * @param \PDO $db
     * @return array
     */
    public static function fetchAllOrderByIdAscending(\PDO $db): array
    {
        $req = $db->prepare('SELECT id, name FROM groups ORDER BY id ASC');
        $req->execute();
        $rooms = array();
        foreach ($req->fetchAll() as $room) {
            array_push($rooms, Group::create()
                ->setId($room['id'])
                ->setName($room['name']));
        }
        $req->closeCursor();
        return $rooms;
    }

    public static function create()
    {
        $instance = new self();
        return $instance;
    }

    /**
     * @return mixed
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * @param mixed $id
     */
    public function setId($id)
    {
        $this->id = $id;
        return $this;
    }

    //"SELECT * FROM roomgroups ORDER BY roomgroupid ASC;"

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
        return $this;
    }
}