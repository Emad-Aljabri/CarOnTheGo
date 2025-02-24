<?php
$host = 'localhost';
$dbname = 'rentcar';
$username = 'root'; 
$password = 'mysql';

$conn = new mysqli($host, $username, $password, $dbname);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}
?>