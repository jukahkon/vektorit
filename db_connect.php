<?php

$db = null;

try {
    $db = new PDO("mysql:host=localhost;dbname=vektorit", "vektorit", "vektorit");
} catch (Exception $e) {
    echo "Cannot connect to database: $e";
}

?>
