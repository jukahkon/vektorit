<?php
session_start();

require('db_util.php');
require('salt.php');

$result = "error";

if (isset($_GET["op"])) {
    if ($_GET["op"]=="logout") {
        handleLogout();
    }
    die();
}

if (isset($_POST["op"])) {
    if ($_POST["op"]=="login") {
        handleLogin();
        die();
    }
}

// 
// Registration is via AJAX
//
if (isset($_POST["op"])) {
    if ($_POST["op"]=="register") {
        $result = handleRegistration();
    }     
    else {
        echo "unknown_operation";
    }
}

echo $result;
die();

function handleRegistration() {
    global $salt;
    
    $user = $_POST["user"];
    $nick = $_POST["nick"];
    $pass = $_POST["pass"];
    $pass2 = $_POST["pass2"];
    
    if (DbUtil::user_exists($user)) {
        return "already_registered";
    } 
    else if (DbUtil::nick_exists($nick)) {
        return "nick_in_use";
    } 
    else if ($pass != $pass2) {
        return "pass_not_match";
    }

    $hashedPass = sha1($pass . $salt);

    DbUtil::add_new_user($user,$nick,$hashedPass,$salt);
    
    createSession($user);
        
    return "ok";
}

function handleLogin() {
    $user = $_POST['user'];
    $pass = $_POST['pass'];

    $_SESSION["login_email"] = $user;
    
    if (!DbUtil::user_exists($user)) {
        $_SESSION["login_status"] = "account_not_found";        
        header("Location: login.php");
        exit();
    }

    if (!DbUtil::user_autenthicate($user,$pass)) {
        $_SESSION["login_status"] = "incorrect_password";
        header("Location: login.php");
        exit();
    }
    
    createSession($user);
    header("Location: home.php");
    exit();
}

function createSession($user) {
    $user_id = DbUtil::user_id_by_email($user);
    if (!$user_id)
        die("Error in account creation!");
    
    session_regenerate_id(true);
    $_SESSION['user_id'] = $user_id;
    session_write_close();
}

function handleLogout() {
    session_unset();
    session_destroy();
    header("Location: login.php");
    exit();
}

?>
