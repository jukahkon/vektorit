<?php

session_start();

require('db_util.php');

$team_id = $_SESSION['team_id'];

echo json_encode(DbUtil::get_messages($team_id));

?>
