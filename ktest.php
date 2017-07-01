<?php
require_once 'vendor/autoload.php';

$newPolicy = 'Rosenthal Library usually has several rooms available to students for group study on a first-come, first-serve basis. These rooms are available to currently registered Queens College students only.

Immediate use of a Group Study Room is made by presenting your valid Queens College ID at the Circulation Desk (located on Level 3 of the Library). If available, a room will be assigned to you for one 2-hour time block. If the room is in use a hold may be placed to secure the next available time slot. Room use, like book use, is assigned to your record in our automated circulation system. When a room is assigned to you, you will be handed a wooden block upon which the room number and policies governing Group Study Rooms is adhered. Upon completing your use of the room, the wooden block is to be returned to the Circulation Desk and the assignment of the room to your record will be released.

Should you wish to extend the use of the room you are required to return to the Circulation desk with your ID and the wooden block at the end of the 2 hours. The room will then be reassigned to you provided there are no other users awaiting use of the room.';
$my_connection = \model\Db::getInstance();
model\Setting::update($my_connection, 'policies', $newPolicy);
echo preg_replace('/\v+|\\\r\\\n/','<br/>',model\Setting::fetchValue(\model\Db::getInstance(), 'policies'));

echo '<br /><p>Now we shall create a new random user.</p>';
$username = generateRandomString(96);
$kus = \model\User::create()->setUsername($username)->setDisplayName(generateRandomString(24))->setPassword('hunter2')->setEmail(generateRandomString(16).'@' . generateRandomString(8) . '.' . generateRandomString(3));
model\User::addUser($my_connection, $kus);
$users = model\User::fetchCount($my_connection);
$this_user = model\User::fetchByUsername($my_connection, $username);
highlight_string("<?php\n\$data =\n" . var_export($kus, true) . ";\n?>");

echo '<br /> The number of users is ' . $users;

echo '<br />';

highlight_string("<?php\n\$thisUser =\n" . var_export($this_user, true) . ";\n?>");


$my_connection = null;

function generateRandomString($length = 10) {
    $characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
    $charactersLength = strlen($characters);
    $randomString = '';
    for ($i = 0; $i < $length; $i++) {
        $randomString .= $characters[rand(0, $charactersLength - 1)];
    }
    return $randomString;
}
