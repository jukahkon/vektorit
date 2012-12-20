<?php

$db = null;

try {
    $db = new PDO("mysql:host=localhost;dbname=vektorit", "vektoritsite", "vektorit");
} catch (Exception $e) {
    echo "Cannot connect to database: $e";
}

?>
