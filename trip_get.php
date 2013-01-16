<?php
session_start();

require('db_util.php');

$user_id = $_SESSION['user_id'];

if (isset($_GET["op"])) {
    if ($_GET["op"]=="getTotalDistance") {
        echo DbUtil::get_total_distance($user_id);
    }
       
    die();
}


echo json_encode(DbUtil::get_trips($user_id));

?>
