<?php
session_start();

require('db_connect.php');
require('db_util.php');
require('salt.php');

$result = "fail";

if (isset($_POST["op"]) && $_POST["op"]=="register") {
    $result = handleRegistration();
} else {
    echo "Unknown op";
}

echo $result;
die();

function handleRegistration() {
    global $db, $salt;
    
    $user = $_POST["user"];
    $nick = $_POST["nick"];
    $pass = $_POST["pass"];
    $pass2 = $_POST["pass2"];
    
    if (db_user_exists($user)) {
        return "already_registered";
    } 
    else if (db_nick_exists($nick)) {
        return "nick_in_use";
    } 
    else if ($pass != $pass2) {
        return "pass_not_match";
    }

    $hashedPass = sha1("$pass"."$salt");

    db_add_new_user($user,$nick,$hashedPass,$salt);
    
    session_regenerate_id(true);
    $_SESSION['user_id'] = db_user_id_by_email($user);
    session_write_close();
        
    return "ok";
}

?>
