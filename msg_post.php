<?php

session_start();

require('db_util.php');

$user_id = $_SESSION['user_id'];

if (isset($_POST["message"])) {
    DbUtil::add_new_message($user_id, $_POST["message"]);
} else {
    echo "fail" . serialize($_POST);
}

echo "ok";

?>
