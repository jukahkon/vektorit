<?php
session_start();

require('db_util.php');

$user_id = $_SESSION['user_id'];

if (isset($_GET["op"])) {
    if ($_GET["op"]=="getTotalDistance") {
        echo DbUtil::get_total_distance($user_id);
    } else if ($_GET["op"]=="getTrips") {
        echo json_encode(DbUtil::get_trips($user_id));
    } else if ($_GET["op"]=="getTripSteps") {
        $date = $_GET["date"];
        $tripDistance = DbUtil::get_trip_distance_by_date($user_id, $date);
        $totalByDate = DbUtil::get_total_distance_by_date($user_id, $date);
        $from = $totalByDate - $tripDistance;        
        echo json_encode(DbUtil::get_trip_steps(DbUtil::get_route_id(),$from,$totalByDate));
    } else {
        echo "unknown operation";
    }       
}

?>
