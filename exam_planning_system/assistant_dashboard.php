<?php
session_start();
require 'db_connection.php'; 

if ($_SESSION['role'] != 'assistant') {
    header("Location: login.php");
    exit();
}

$assistant_id = $_SESSION['user_id'];

$query = "SELECT Schedules.day, Schedules.time, Courses.name AS course_name 
          FROM Schedules 
          JOIN Courses ON Schedules.course_id = Courses.id 
          WHERE Schedules.assistant_id = $assistant_id";
$result = $conn->query($query);

$schedule = [];
if ($result->num_rows > 0) {
    while($row = $result->fetch_assoc()) {
        $schedule[$row['day']][$row['time']] = $row['course_name'];
    }
}

$query_exams = "SELECT Exams.exam_date, Exams.exam_time, Exams.exam_name 
                FROM AssistantsExams 
                JOIN Exams ON AssistantsExams.exam_id = Exams.id 
                WHERE AssistantsExams.assistant_id = $assistant_id";
$result_exams = $conn->query($query_exams);

$exams = [];
if ($result_exams->num_rows > 0) {
    while($row = $result_exams->fetch_assoc()) {
        $exams[] = $row;
    }
}

$conn->close();
?>

<!DOCTYPE html>
<html>
<head>
    <title>Assistant Dashboard</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f2f2f2;
            margin: 0;
            padding: 0;
        }
        .container {
            max-width: 800px;
            margin: 20px auto;
            padding: 20px;
            background-color: #fff;
            border-radius: 5px;
            box-shadow: 0 2px 5px rgba(0,0,0,0.1);
        }
        h1, h2 {
            color: #333;
        }
        table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 20px;
        }
        th, td {
            padding: 8px;
            text-align: left;
            border-bottom: 1px solid #ddd;
        }
        th {
            background-color: #f2f2f2;
            font-weight: normal;
        }
        form {
            margin-bottom: 20px;
        }
        label {
            display: block;
            margin-bottom: 5px;
        }
        select, button {
            padding: 8px;
            margin-bottom: 10px;
            border: 1px solid #ccc;
            border-radius: 3px;
            width: 100%;
        }
        button[type="submit"] {
            background-color: #007bff; 
            color: white;
            border: none;
            cursor: pointer;
        }
        button[type="submit"]:hover {
            background-color: #0056b3; 
        }
        .logout-btn {
            float: right;
        }
    </style>
</head>
<body>
    <div class="container">
            <form method="POST" action="logout.php" class="logout-btn">
            <button type="submit">Logout</button>
        </form>
        
        <h1>Welcome, <?php echo $_SESSION['name']; ?></h1>
        

        
        <h2>Your Weekly Schedule:</h2>
        <?php if (!empty($schedule)) { ?>
            <table>
                <tr>
                    <th>Time\Day</th>
                    <?php 
                    $days = ["Monday", "Tuesday", "Wednesday", "Thursday", "Friday", "Saturday", "Sunday"];
                    foreach ($days as $day) { ?>
                        <th><?php echo $day; ?></th>
                    <?php } ?>
                </tr>
                <?php 
                $timeslots = ["09:00", "10:00", "11:00", "12:00", "13:00", "14:00", "15:00", "16:00", "17:00"];
                foreach ($timeslots as $timeslot) { ?>
                    <tr>
                        <td><?php echo $timeslot; ?></td>
                        <?php foreach ($days as $day) { ?>
                            <td>
                                <?php echo isset($schedule[$day][$timeslot]) ? $schedule[$day][$timeslot] : "-"; ?>
                            </td>
                        <?php } ?>
                    </tr>
                <?php } ?>
            </table>
            <form method="POST">
                <button type="submit">Refresh Schedule</button>
            </form>
        <?php } else { ?>
            <p>No schedule available.</p>
        <?php } ?>

        <h2>Your Exam Schedule:</h2>
        <?php if (!empty($exams)) { ?>
            <table>
                <tr>
                    <th>Date</th>
                    <th>Time</th>
                    <th>Exam Name</th>
                </tr>
                <?php foreach ($exams as $exam) { ?>
                    <tr>
                        <td><?php echo $exam['exam_date']; ?></td>
                        <td><?php echo $exam['exam_time']; ?></td>
                        <td><?php echo $exam['exam_name']; ?></td>
                    </tr>
                <?php } ?>
            </table>
        <?php } else { ?>
            <p>No exams assigned.</p>
        <?php } ?>

        <h2>Select Courses:</h2>
        <form method="POST" action="select_courses.php">
            <label for="course">Select Course:</label>
            <select name="course_id" id="course">
                <?php
                require 'db_connection.php'; 
                $courses_query = "SELECT * FROM Courses";
                $courses_result = $conn->query($courses_query);
                while ($course = $courses_result->fetch_assoc()) {
                    echo "<option value='" . $course['id'] . "'>" . $course['name'] . "</option>";
                }
                $conn->close();
                ?>
            </select>
            
            <label for="day">Select Day:</label>
            <select name="day" id="day">
                <option value="Monday">Monday</option>
                <option value="Tuesday">Tuesday</option>
                <option value="Wednesday">Wednesday</option>
                <option value="Thursday">Thursday</option>
                <option value="Friday">Friday</option>
                <option value="Saturday">Saturday</option>
                <option value="Sunday">Sunday</option>
            </select>

            <label for="time">Select Time:</label>
            <select name="time" id="time">
                <option value="09:00">09:00</option>
                <option value="10:00">10:00</option>
                <option value="11:00">11:00</option>
                <option value="12:00">12:00</option>
                <option value="13:00">13:00</option>
                <option value="14:00">14:00</option>
                <option value="15:00">15:00</option>
                <option value="16:00">16:00</option>
                <option value="17:00">17:00</option>
            </select>

            <button type="submit">Add Course</button>
        </form>
    </div>
</body>
</html>
