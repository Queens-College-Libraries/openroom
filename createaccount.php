<?php
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}
include("includes/or-theme.php");
include($_SESSION["themepath"] . "header.php");
function rand_str($length = 12, $chars = 'ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz1234567890')
{
    // Length of character list
    $chars_length = (strlen($chars) - 1);
    // Start our string
    $string = $chars{rand(0, $chars_length)};
    // Generate random string
    for ($i = 1; $i < $length; $i = strlen($string)) {
        // Grab a random character from our list
        $r = $chars{rand(0, $chars_length)};
        // Make sure the same two characters don't appear next to each other
        if ($r != $string{$i - 1}) $string .= $r;
    }
    // Return the string
    return $string;
}
//Form Processing
$desiredusername = isset($_POST["desiredusername"]) ? $_POST["desiredusername"] : "";
$password = isset($_POST["password"]) ? $_POST["password"] : "";
$confirm = isset($_POST["confirm"]) ? $_POST["confirm"] : "";
$email = isset($_POST["email"]) ? $_POST["email"] : "";
$submitted = isset($_POST["submitted"]) ? $_POST["submitted"] : "";
$activateusername = isset($_GET["username"]) ? $_GET["username"] : "";
$activatecode = isset($_GET["code"]) ? $_GET["code"] : "";
$errormsg = "";
if ($activatecode == "" && $activateusername == "") {
    if (!(preg_match("/^[A-Za-z0-9_-]+$/", $desiredusername)) && $submitted == "1") {
        $errormsg .= "Invalid characters in username.<br/>";
    }
    if (($password != $confirm || $password == "") && $submitted == "1") {
        $errormsg .= "Passwords do not match and may not be left blank.<br/>";
    }
    if (!(filter_var($email, FILTER_VALIDATE_EMAIL)) && $submitted == "1") {
        $errormsg .= "Invalid email address.<br/>";
    }
    if ($errormsg == "" && $submitted == "1") {
        //Create account for this user
        $hash = password_hash($password, PASSWORD_DEFAULT);
        $activationcode = rand_str();
        if (mysqli_query($GLOBALS["___mysqli_ston"], "INSERT INTO users(username,password,email,active) VALUES('" . $desiredusername . "','" . $hash . "','" . $email . "','" . $activationcode . "');")) {
            $emailmsg = "Please click the following link to activate your account.\n\n" . $_SERVER["HTTP_REFERER"] . "?code=" . $activationcode . "&username=" . $desiredusername . "\n\nThank you!";
            $email_system = $settings["email_system"];
            mail($email, "Account activation for " . $settings["instance_name"], $emailmsg, "MIME-Version: 1.0\r\nContent-type: text/html; charset=iso-8859-1\r\nFrom: " . $email_system . "\r\nReturn-Path: " . $email_system . "\r\nReply-To: " . $email_system);
            $successmsg = "Your account has been created!<br/><br/>An email has been sent to the address you provided with an activation link. Please follow the instructions in the email.";
        } else {
            $errormsg = "Account could not be created. Try using a different username.<br/>";
        }
    }
    ?>

    <center>
        <?php
        if ($successmsg != "") {
            echo "<div id=\"successmsg\">" . $successmsg . "</div>";
        }
        if ($errormsg != "") {
            echo "<div id=\"errormsg\">" . $errormsg . "</div>";
        }
        ?>
    </center>
    <h3><a href="index.php"><?php echo $settings["instance_name"]; ?></a> - Create an Account</h3>

    <?php
    if ($successmsg == "") {
        ?>
        <form name="createaccount" method="POST" action="createaccount.php">
            <table border="0">
                <tr>
                    <td>Desired Username:</td>
                    <td><input type="text" name="desiredusername" value="<?php echo $desiredusername; ?>"/></td>
                    <td><em>Valid Characters: a-z, A-Z, 0-9</em></td>
                </tr>
                <tr>
                    <td>Password:</td>
                    <td><input type="password" name="password"/></td>
                </tr>
                <tr>
                    <td>Confirm Password:</td>
                    <td><input type="password" name="confirm"/></td>
                </tr>
                <tr>
                    <td>Email:</td>
                    <td><input type="text" name="email" value="<?php echo $email; ?>"/></td>
                    <td><em><?php
                            $emailfilters = unserialize($settings["email_filter"]);
                            $comma = 0;
                            foreach ($emailfilters as $filter) {
                                if ($comma == 0) {
                                    echo "example@" . $filter;
                                    $comma = 1;
                                } else {
                                    echo ", example@" . $filter;
                                }
                            }
                            ?></em></td>
                </tr>
                <tr>
                    <td colspan="3"><input type="hidden" name="submitted" value="1"/><input type="submit"
                                                                                            value="Create Account"/>
                    </td>
                </tr>
            </table>
        </form>
        <?php
    } else {
        ?>
        <a href="index.php">Go back</a> to the <?php echo $settings["instance_name"]; ?> homepage.
        <?php
    }
    ?>
    <br/><br/>
    <?php
} else {
    if (!(preg_match("/^[A-Za-z0-9_-]+$/", $activateusername))) {
        $errormsg .= "Invalid characters in username.<br/>";
    }
    $usermatch = mysqli_query($GLOBALS["___mysqli_ston"], "SELECT * FROM users WHERE username='" . $activateusername . "' AND active='" . $activatecode . "';");
    if (mysqli_num_rows($usermatch) == 1) {
        if (mysqli_query($GLOBALS["___mysqli_ston"], "UPDATE users SET active='0' WHERE username='" . $activateusername . "';")) {
            echo "Your account has been successfully activated!<br/><a href=\"index.php\">Go back</a> to the " . $settings["instance_name"] . " homepage.";
        } else {
            echo "There was a problem activating your account.";
        }
    } else {
        echo "There was a problem activating your account.";
    }
}
include($_SESSION["themepath"] . "footer.php");
?>