<?php

//
//MariaDB [openroom]> describe openroom.reservations;
//+---------------+--------------+------+-----+---------------------+----------------+
//| Field         | Type         | Null | Key | Default             | Extra          |
//+---------------+--------------+------+-----+---------------------+----------------+
//| reservationid | bigint(20)   | NO   | PRI | NULL                | auto_increment |
//| start         | timestamp    | NO   |     | 0000-00-00 00:00:00 |                |
//| end           | timestamp    | NO   |     | 0000-00-00 00:00:00 |                |
//| roomid        | int(11)      | NO   |     | NULL                |                |
//| username      | varchar(255) | NO   |     | NULL                |                |
//| numberingroup | int(11)      | NO   |     | NULL                |                |
//| timeofrequest | timestamp    | NO   |     | CURRENT_TIMESTAMP   |                |
//+---------------+--------------+------+-----+---------------------+----------------+
//7 rows in set (0.00 sec)

declare(strict_types=1);

namespace model;
class Reservation
{
    private $id;
    private $startTime;
    private $endTime;
    private $roomId;
    private $userName;
    private $numberInGroup;
    private $timeOfRequest;
    private $roomName;

    public function __construct($id, $startTime, $endTime, $roomId, $userName, $numberInGroup, $timeOfRequest, $roomName)
    {
        $this->id = $id;
        $this->startTime = $startTime;
        $this->endTime = $endTime;
        $this->roomId = $roomId;
        $this->userName = $userName;
        $this->numberInGroup = $numberInGroup;
        $this->timeOfRequest = $timeOfRequest;
        $this->roomName = $roomName;
    }

    public static function getSpecificReservation(\PDO $db, $id)
    {
        $req = $db->prepare("SELECT reservations.reservationid, reservations.start, reservations.end, reservations.roomid, reservations.username, reservations.numberingroup, reservations.timeofrequest, rooms.roomname FROM reservations INNER JOIN rooms where rooms.roomid = reservations.roomid and reservationid = :id");
        $req->execute(array('id' => $id));
        $reservation = $req->fetch();
        return new Reservation($reservation['reservationid'], $reservation['start'], $reservation['end'], $reservation['roomid'], $reservation['username'], $reservation['numberingroup'], $reservation['timeofrequest'], $reservation['roomname']);
    }

    public static function all(\PDO $db)
    {
        $list = [];
        $req = $db->query("SELECT reservations.reservationid, reservations.start, reservations.end, reservations.roomid, reservations.username, reservations.numberingroup, reservations.timeofrequest, rooms.roomname FROM reservations INNER JOIN rooms where rooms.roomid = reservations.roomid");
        foreach ($req->fetchAll() as $reservation) {
            $list[] = new Reservation($reservation['reservationid'], $reservation['start'], $reservation['end'], $reservation['roomid'], $reservation['username'], $reservation['numberingroup'], $reservation['timeofrequest'], $reservation['roomname']);
        }
        return $list;
    }

    public static function getAllReservationsSinceStartDate(\PDO $db, $startDate)
    {
        $rooms = [];
        $req = $db->query("SELECT roomid FROM rooms order by roomid asc");
        foreach ($req->fetchAll(\PDO::FETCH_ASSOC) as $reservation) {
            $rooms[] = $reservation['roomid'];
        }

        $list = [];
        $req = $db->prepare("SELECT reservations.reservationid, reservations.start, reservations.end, reservations.roomid, reservations.username, reservations.numberingroup, reservations.timeofrequest, rooms.roomname FROM reservations INNER JOIN rooms where rooms.roomid = reservations.roomid and end > (:startDate) order by start asc");
        $req->bindParam(':startDate', $startDate, \PDO::PARAM_STR, 255);
        $req->execute();
        foreach ($req->fetchAll() as $reservation) {
            // $list[] = new Reservation($reservation['reservationid'], $reservation['start'], $reservation['end'], $reservation['roomid'], $reservation['username'], $reservation['numberingroup'], $reservation['timeofrequest'], $reservation['roomname']);
            for($i=0;$i<count($rooms);$i++){
               if($reservation['roomid'] == $rooms[$i]){
                  $list[$rooms[$i]][] = new Reservation($reservation['reservationid'], $reservation['start'], $reservation['end'], $reservation['roomid'], $reservation['username'], $reservation['numberingroup'], $reservation['timeofrequest'], $reservation['roomname']);
                }
            }
        }
        return $list;
    }

    public static function getAllReservationsBetween(\PDO $db, $startDate, $endDate)
    {
        $rooms = [];
        $req = $db->query("SELECT roomid FROM rooms order by roomid asc");
        foreach ($req->fetchAll(\PDO::FETCH_ASSOC) as $reservation) {
            $rooms[] = $reservation['roomid'];
        }

        $list = [];
        $req = $db->prepare("SELECT reservations.reservationid, reservations.start, reservations.end, reservations.roomid, reservations.username, reservations.numberingroup, reservations.timeofrequest, rooms.roomname FROM reservations INNER JOIN rooms where rooms.roomid = reservations.roomid and end > (:startDate) and start < (:endDate) order by start asc");
        $req->bindParam(':startDate', $startDate, \PDO::PARAM_STR, 255);
        $req->bindParam(':endDate', $endDate, \PDO::PARAM_STR, 255);
        $req->execute();
        foreach ($req->fetchAll() as $reservation) {
            // $list[] = new Reservation($reservation['reservationid'], $reservation['start'], $reservation['end'], $reservation['roomid'], $reservation['username'], $reservation['numberingroup'], $reservation['timeofrequest'], $reservation['roomname']);
            for($i=0;$i<count($rooms);$i++){
               if($reservation['roomid'] == $rooms[$i]){
                  $list[$rooms[$i]][] = new Reservation($reservation['reservationid'], $reservation['start'], $reservation['end'], $reservation['roomid'], $reservation['username'], $reservation['numberingroup'], $reservation['timeofrequest'], $reservation['roomname']);
                }
            }
        }
        return $list;
    }

    public static function truncate(\PDO $db, $startDate)
    {
        $req = $db->prepare('DELETE FROM  reservations where start < (:startDate)');
        $req->bindParam(':startDate', $startDate, \PDO::PARAM_STR, 255);
        $req->execute();
        return true;
    }

    public static function getAllReservationsForUser(\PDO $db, string $username)
    {
        $list = [];
        $req = $db->prepare("SELECT reservations.reservationid, reservations.start, reservations.end, reservations.roomid, reservations.username, reservations.numberingroup, reservations.timeofrequest, rooms.roomname, rooms.roomid, rooms.roomname, rooms.roomposition, rooms.roomcapacity, rooms.roomgroupid, rooms.roomdescription FROM reservations LEFT JOIN rooms ON reservations.roomid = rooms.roomid WHERE username = :username AND reservations.end >= CURRENT_TIMESTAMP() ORDER BY reservations.start ASC;");
        $req->execute(array('username' => $username));
        foreach ($req->fetchAll() as $reservation) 
        {
            array_push($list, $reservation);
        }
        return $list;
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
    }

    /**
     * @return mixed
     */
    public function getStartTime()
    {
        return $this->startTime;
    }

    /**
     * @param mixed $startTime
     */
    public function setStartTime($startTime)
    {
        $this->startTime = $startTime;
    }

    /**
     * @return mixed
     */
    public function getEndTime()
    {
        return $this->endTime;
    }

    /**
     * @param mixed $endTime
     */
    public function setEndTime($endTime)
    {
        $this->endTime = $endTime;
    }

    /**
     * @return mixed
     */
    public function getRoomId()
    {
        return $this->roomId;
    }

    /**
     * @param mixed $roomId
     */
    public function setRoomId($roomId)
    {
        $this->roomId = $roomId;
    }

    /**
     * @return mixed
     */
    public function getUserName()
    {
        return $this->userName;
    }

    /**
     * @param mixed $userName
     */
    public function setUserName($userName)
    {
        $this->userName = $userName;
    }

    // "SELECT * FROM reservations ORDER BY timeofrequest DESC;"

    /**
     * @return mixed
     */
    public function getNumberInGroup()
    {
        return $this->numberInGroup;
    }

    /**
     * @param mixed $numberInGroup
     */
    public function setNumberInGroup($numberInGroup)
    {
        $this->numberInGroup = $numberInGroup;
    }

    /**
     * @return mixed
     */
    public function getTimeOfRequest()
    {
        return $this->timeOfRequest;
    }

    // delete from openroom.reservations where start < '2018-07-18 14:00:00';

    /**
     * @param mixed $timeOfRequest
     */
    public function setTimeOfRequest($timeOfRequest)
    {
        $this->timeOfRequest = $timeOfRequest;
    }

    /**
     * @return mixed
     */
    public function getRoomName()
    {
        return $this->roomName;
    }

    /**
     * @param mixed $roomName
     */
    public function setRoomName($roomName)
    {
        $this->roomName = $roomName;
    }
}