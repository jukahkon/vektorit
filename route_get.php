<?php

session_start();

require('db_util.php');

$id = DbUtil::get_route_id();

echo json_encode(DbUtil::get_route_waypoints($id));

?>
