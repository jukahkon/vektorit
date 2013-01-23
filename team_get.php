<?php

session_start();

require('db_util.php');

$team_id = $_SESSION['team_id'];

if (isset($_GET["op"])) {
    if ($_GET["op"]=="getTeamDistances") {
        echo json_encode(DbUtil::get_team_distances($team_id));
    } else {
        echo "unknown operation";
    }       
}

?>
