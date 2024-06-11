<?php
session_start();
if ($_SESSION['role'] != 'dean') {
    header("Location: login.php");
    exit();
}

require 'db_connection.php'; 
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dean Dashboard</title>
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
        h1 {
            color: #333;
            margin-bottom: 20px;
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
            width: calc(100% - 16px); 
        }
        button[type="submit"] {
            background-color: #007bff; 
            color: white;
            border: none;
            cursor: pointer;
            width: 100%; 

        }
        button[type="submit"]:hover {
            background-color: #0056b3;
        }
        ul {
            list-style-type: none;
            padding: 0;
        }
        li {
            margin-bottom: 5px;
        }
        table {
            width: 100%;
            border-collapse: collapse;
        }
        th, td {
            border: 1px solid #ccc;
            padding: 8px;
            text-align: left;
        }
        th {
            background-color: #f2f2f2;
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
        
        <form method="POST" action="">
            <label for="department">Select Department:</label>
            <select name="department" id="department" required>
                <option value="" selected disabled>Select Department</option>
                <?php
                $departments_query = "SELECT * FROM Departments";
                $departments_result = $conn->query($departments_query);
                while ($department = $departments_result->fetch_assoc()) {
                    echo "<option value='" . $department['id'] . "'>" . $department['name'] . "</option>";
                }
                ?>
            </select>
            <button type="submit" name="submit">See Exam Schedule</button>
        </form>

        <?php
        if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['submit'])) {
            $selected_department = $_POST['department'];
        
            $exams_query = "SELECT * FROM Exams WHERE department_id = $selected_department ORDER BY exam_date ASC";
            $exams_result = $conn->query($exams_query);
        
            if ($exams_result->num_rows > 0) {
                echo "<h2>Exams for Selected Department:</h2>";
                echo "<table>";
                echo "<tr><th>Exam Name</th><th>Date</th><th>Time</th></tr>";
                while ($exam = $exams_result->fetch_assoc()) {
                    echo "<tr>";
                    echo "<td>" . $exam['exam_name'] . "</td>";
                    echo "<td>" . $exam['exam_date'] . "</td>";
                    echo "<td>" . $exam['exam_time'] . "</td>";
                    echo "</tr>";
                }
                echo "</table>";
            } else {
                echo "<p>No exams found for the selected department.</p>";
            }
        }
        ?>
    </div>
</body>
</html>

<?php
$conn->close();
?>
