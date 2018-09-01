<?php
/**
 * Created by PhpStorm.
 * User: kus
 * Date: 9/1/18
 * Time: 1:47 PM
 */

namespace model;

//
//mysql> describe cancelled;
//+---------------+--------------+------+-----+---------------------+-------+
//| Field         | Type         | Null | Key | Default             | Extra |
//+---------------+--------------+------+-----+---------------------+-------+
//| reservationid | bigint(20)   | NO   | PRI | NULL                |       |
//| start         | timestamp    | NO   |     | 0000-00-00 00:00:00 |       |
//| end           | timestamp    | NO   |     | 0000-00-00 00:00:00 |       |
//| roomid        | int(11)      | NO   |     | NULL                |       |
//| username      | varchar(255) | NO   |     | NULL                |       |
//| timeofrequest | timestamp    | NO   |     | 0000-00-00 00:00:00 |       |
//| timeofcancel  | timestamp    | NO   |     | CURRENT_TIMESTAMP   |       |
//+---------------+--------------+------+-----+---------------------+-------+
//7 rows in set (0.00 sec)


class Cancelled
{
    private $id;
    private $startTime;
    private $endTime;
    private $roomId;
    private $userName;
    private $timeOfRequest;
    private $timeOfCancellation;

    public function __construct($id, $startTime, $endTime, $roomId, $userName, $timeOfRequest,
                                $timeOfCancellation)
    {
        $this->id = $id;
        $this->startTime = $startTime;
        $this->endTime = $endTime;
        $this->roomId = $roomId;
        $this->userName = $userName;
        $this->timeOfRequest = $timeOfRequest;
        $this->timeOfCancellation = $timeOfCancellation;
    }

    public static function getSpecificReservation($db, $id)
    {
        $req = $db->prepare("SELECT reservationid, start, end, roomid, username, timeofrequest, timeofcancel FROM cancelled WHERE reservationid = :id");
        $req->execute(array('id' => $id));
        $reservation = $req->fetch();
        return new Cancelled(
            $reservation['reservationid'], $reservation['start'], $reservation['end'], $reservation['roomid'],
            $reservation['username'], $reservation['timeofrequest'], $reservation['timeofcancel']);
    }

    public static function all($db)
    {
        $list = [];
        $req = $db->query("SELECT reservationid, start, end, roomid, username, timeofrequest, timeofcancel FROM cancelled");
        foreach ($req->fetchAll() as $reservation) {
            $list[] = new Cancelled(
                $reservation['reservationid'], $reservation['start'], $reservation['end'], $reservation['roomid'],
                $reservation['username'], $reservation['timeofrequest'], $reservation['timeofcancel']);
        }
        return $list;
    }

    public static function truncate($db, $startDate)
    {
        $req = $db->prepare('DELETE FROM  cancelled where start < (:startDate)');
        $req->bindParam(':startDate', $startDate, \PDO::PARAM_STR, 255);
        $req->execute();
        return true;
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

    // "SELECT * FROM reservations ORDER BY timeofrequest DESC;"

    /**
     * @param mixed $userName
     */
    public function setUserName($userName)
    {
        $this->userName = $userName;
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
}
