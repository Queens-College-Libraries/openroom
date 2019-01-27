<?php
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}
include("includes/or-theme.php");
include($_SESSION["themepath"] . "header.php");
if ($_SESSION["systemid"] == $settings["systemid"]) {
    //Form Processing
    $submitted = isset($_POST["submitted"]) ? $_POST["submitted"] : "";
    $errormsg = "";
    $emaila = mysqli_fetch_array(mysqli_query($GLOBALS["___mysqli_ston"], "SELECT * FROM users WHERE username='" . $_SESSION["username"] . "';"));
    if ($submitted == "1") {
        $password = isset($_POST["password"]) ? $_POST["password"] : "";
        $confirm = isset($_POST["confirm"]) ? $_POST["confirm"] : "";
        $email = isset($_POST["email"]) ? $_POST["email"] : "";
        if ($password != "" || $confirm != "") {
            if ($password != $confirm) {
                $errormsg .= "New Password and Conform Password do not match.<br/>";
            } //Passwords have been entered and match so put in a new password
            else {
                $encpass = password_hash($password, PASSWORD_DEFAULT);
            }
        } //No password change, set encpass equal to old password
        else {
            $encpass = $emaila["password"];
        }
        if (!(filter_var($email, FILTER_VALIDATE_EMAIL))) {
            $errormsg .= "Invalid email address.<br/>";
        }
        if ($errormsg == "") {
            //Update account for this user
            if (mysqli_query($GLOBALS["___mysqli_ston"], "UPDATE users SET password = '" . $encpass . "', email = '" . $email . "' WHERE username='" . $_SESSION["username"] . "';")) {
                $successmsg = "Your account has been updated!";
            } else {
                $errormsg = "Account could not be updated.<br/>";
            }
        }
    }
    $emaila = mysqli_fetch_array(mysqli_query($GLOBALS["___mysqli_ston"], "SELECT * FROM users WHERE username='" . $_SESSION["username"] . "';"));
    $email = $emaila["email"];
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
    <h3><a href="index.php"><?php echo $settings["instance_name"]; ?></a> - Edit Account</h3>

    <form name="editaccount" method="POST" action="editaccount.php">
        <table border="0">
            <tr>
                <td>Change Password:</td>
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
                <td colspan="3"><input type="hidden" name="submitted" value="1"/><input type="submit" value="Save"/>
                </td>
            </tr>
        </table>
    </form>
    <br/><br/>
    <?php
    include($_SESSION["themepath"] . "footer.php");
} else {
    echo "You are not logged in. Please <a href=\"index.php\">click here</a> and login with an authorized account.";
}
?>