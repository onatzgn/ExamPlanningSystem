<?php
session_start();
require 'db_connection.php';

if ($_SESSION['role'] != 'assistant') {
    header("Location: login.php");
    exit();
}

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $assistant_id = $_SESSION['user_id'];
    $course_id = $_POST['course_id'];
    $day = $_POST['day'];
    $time = $_POST['time'];

    $query = "INSERT INTO AssistantsCourses (assistant_id, course_id) VALUES ($assistant_id, $course_id)";
    if ($conn->query($query) === TRUE) {
        echo "Course selected successfully!";
    } else {
        echo "Error: " . $query . "<br>" . $conn->error;
    }

    $insert_schedule = "INSERT INTO Schedules (assistant_id, day, time, course_id) VALUES ($assistant_id, '$day', '$time', $course_id)";
    if ($conn->query($insert_schedule) === TRUE) {
        echo "Schedule updated successfully!";
    } else {
        echo "Error: " . $insert_schedule . "<br>" . $conn->error;
    }

    $conn->close();
    header("Location: assistant_dashboard.php");
    exit();
} else {
    header("Location: assistant_dashboard.php");
    exit();
}
?>
