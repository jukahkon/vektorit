<?php
session_start();

require('db_util.php');

echo json_encode(DbUtil::get_trips($_SESSION['user_id']));

?>
