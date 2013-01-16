<?php
session_start();

require('db_util.php');

$user_id = $_SESSION['user_id'];

echo json_encode(DbUtil::get_current_location($user_id));

?>
