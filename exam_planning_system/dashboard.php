<?php
session_start();
if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit();
}

$role = $_SESSION['role'];

switch ($role) {
    case 'assistant':
        header("Location: assistant_dashboard.php");
        break;
    case 'secretary':
        header("Location: secretary_dashboard.php");
        break;
    case 'head_of_department':
        header("Location: head_of_department_dashboard.php");
        break;
    case 'head_of_secretary':
        header("Location: head_of_secretary_dashboard.php");
        break;
    case 'dean':
        header("Location: dean_dashboard.php");
        break;
    default:
        echo "Invalid role";
}
?>
