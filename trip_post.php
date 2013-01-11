<?php
session_start();

require('db_util.php');

if (isset($_POST["distance"]) && isset($_POST["date"])) {
    echo storeTripData();
} else {
    echo "fail" . serialize($_POST);
}

function storeTripData() {
    $user = $_SESSION["user_id"];
    $date = $_POST["date"];
    $distance = $_POST["distance"];
    
    DbUtil::update_trip($user, $distance, $date);
    
    return "ok";
}


?>
