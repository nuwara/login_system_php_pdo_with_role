<?php
$server = 'localhost';
$user_name = 'root';
$password = '';
$db_name = 'test';
try {
    $conn = new PDO("mysql:host=$server;dbname=$db_name", $user_name, $password);
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    // echo 'Database connected..........';
} catch (PDOException $e) {
    echo 'Connection Error: ' . $e->getMessage();
}
