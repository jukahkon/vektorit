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
    else if ($_POST["op"]=="create_team") {
        $result = handleTeamCreation();
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
    $team = $_POST["team"];
    $team_pass = $_POST["team-pass"];
    
    if (DbUtil::user_exists($user)) {
        return "already_registered";
    } 
    else if (DbUtil::nick_exists($nick)) {
        return "nick_in_use";
    } 
    else if ($pass != $pass2) {
        return "pass_not_match";
    }
    else if (!DbUtil::team_exists($team)) {
        return "team_not_found";
    }
    else if (!DbUtil::team_autenthicate($team,$team_pass)) {
        return "incorrect_team_password";
    }
    
    $team_id = DbUtil::team_id_by_name($team);
    if (!$team_id)
        die("Error in account creation!");

    $hashedPass = sha1($pass . $salt);

    DbUtil::add_new_user($user,$nick,$hashedPass,$salt,$team_id);
    
    createSession($user);
    
    setInitialLocation($_SESSION['user_id']);
        
    return "ok";
}

function handleTeamCreation() {
    $team = $_POST["team"];
    $pass = $_POST["pass"];
    $pass2 = $_POST["pass2"];
    
    if (DbUtil::team_exists($team)) {
        return "already_registered";
    } 
    else if ($pass != $pass2) {
        return "pass_not_match";
    }

    DbUtil::add_new_team($team, $pass);
    
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
    
    $team_id = DbUtil::team_id_by_user($user_id);
    if (!$team_id)
        die("Error in account creation!");
    
    session_regenerate_id(true);
    $_SESSION['user_id'] = $user_id;
    $_SESSION['team_id'] = $team_id;
    $_SESSION['nick'] = DbUtil::nickname($user_id);
    session_write_close();
}

function setInitialLocation($user) {    
    $step = DbUtil::find_step_for_distance(0);
    
    if ($step) {
        DbUtil::update_location($user, $step);
    } else {
        error_log("Location init failed!");
    }
}

function handleLogout() {
    session_unset();
    session_destroy();
    header("Location: login.php");
    exit();
}

?>
