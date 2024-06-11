<?php
$servername = "localhost";
$username = "root";
$password = "mysql";
$database = "exam_planning_system";

$conn = new mysqli($servername, $username, $password, $database);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}
?>
