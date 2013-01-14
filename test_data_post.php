<?php

require('salt.php');
require('db_util.php');

$result = "fail";

$userTestData = array(
    array("user" => "juha@gmail.com", "nick" => "Juha", "pass" => "hello"),
    array("user" => "johanna@gmail.com", "nick" => "Johanna", "pass" => "hello"),
    array("user" => "pekka@gmail.com", "nick" => "Pekka", "pass" => "hello"),
    array("user" => "juuso@gmail.com", "nick" => "Juuso", "pass" => "hello"),
    array("user" => "katja@gmail.com", "nick" => "Katja", "pass" => "hello"),
    array("user" => "markku@gmail.com", "nick" => "Markku", "pass" => "hello"),
    array("user" => "marja.leena@gmail.com", "nick" => "Marja-Leena", "pass" => "hello"),
    array("user" => "kimmo@gmail.com", "nick" => "Kimmo", "pass" => "hello"),
    array("user" => "tiia@gmail.com", "nick" => "Tiia", "pass" => "hello"),
    array("user" => "oskari@gmail.com", "nick" => "Oskari", "pass" => "hello")
);

if (isset($_POST["op"])) {
    $op = $_POST["op"];
    
    error_log("test_data_post:" . $op);
    
    if ($op == "generateUsers") {
        $result = generateUsers();
    }
    else if ($op == "generateTrips") {        
        $result = generateTrips();
    }
    else if ($op == "removeAllUsers") {        
        DbUtil::remove_all_users();
        $result = "ok";
    } 
    else if ($op == "removeAllTrips") {        
        DbUtil::remove_all_trips();
        $result = "ok";
    } 
    else {
        $result = "unknown_operation";
    }    
}

echo $result;
die();

function generateUsers() {
    global $userTestData;
    
    $userCount = $_POST["userCount"];

    for ($i=0; $i < $userCount; $i++) {
       $data = $userTestData[$i];

       $result = generateNewUser($data["user"],$data["nick"],$data["pass"]);

       if ($result != "ok") {
           return $result;
       }
    }
    
    return "ok";
}

function generateNewUser($user,$nick,$pass) {
    global $salt;
    
    $user = $user;
    $nick = $nick;
    $pass = $pass;
    
    if (DbUtil::user_exists($user)) {
        return "already_registered";
    } 
    else if (DbUtil::nick_exists($nick)) {
        return "nick_in_use";
    } 

    $hashedPass = sha1($pass . $salt);

    DbUtil::add_new_user($user,$nick,$hashedPass,$salt);
    
    return "ok";
}

function generateTrips() {    
    $tripCount = $_POST["tripCount"];
    $dueDate = $_POST["dueDate"];
    $date = "";    
    list($year, $month, $day) = explode("-",$dueDate);    
    
    $users = DbUtil::get_users();
    
    for ($i=0; $i < count($users); $i++) {
        $user = $users[$i];
        $y = intval($year);
        $m = intval($month);
        $d = intval($day);
        
        for ($j=0; $j < $tripCount; $j++) {
            $distance = mt_rand(100,5000)/100;
            $date = "";
            $date .= strval($y);
            $date .= "-" . strval($m);
            $date .= "-" . strval($d);
            
            error_log("Create trip: " . $user["id"] . " " . $distance . " " . $date );
            
            // Update date
            if ($d > 1) {
                $d--;
            } else {
                // change month
                $d = 28;
            
                if ($m > 1) {
                    $m--;
                } else {
                    $m = 12;
                    $y--;
                }
            }
        }
    }
    
    /* DbUtil::update_trip($user,$distance,$date); */
    
    return "ok";
}

?>
