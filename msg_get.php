<?php

require('db_util.php');

echo json_encode(DbUtil::get_messages());

?>
