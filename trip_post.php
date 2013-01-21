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
    
    updateLocation($user);
    
    return "ok";
}

function updateLocation($user) {    
    $totalDistance = DbUtil::get_total_distance($user);
    
    $step = DbUtil::find_step_for_distance($totalDistance);
    
    if ($step) {
        DbUtil::update_location($user, $step);
    } else {
        $routeLength = DbUtil::get_route_length();        
        
        if ($totalDistance > $routeLength) {
            // set location to last step
            $finalStep = DbUtil::find_step_for_distance($routeLength);
            DbUtil::update_location($user, $finalStep);
        }
        
        error_log("Location update failed!");
    }    
}

?>
