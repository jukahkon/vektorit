<?php

$characters = "abcdefghijklmnopqrstyABCDEFGHIJKLMNOPQRSTY";

$salt = "";

for ($i=0; $i < 50; $i++) {
    $salt .= $characters[mt_rand(0, (strlen($characters) -1 ))];
}

?>
