<?php
session_start();
if ($_SESSION['role'] != 'head_of_department') {
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
    <title>Head of Department Dashboard</title>
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
        button[type="submit"] {
            background-color: #007bff;
            color: white;
            border: none;
            cursor: pointer;
            padding: 8px 16px;
            border-radius: 3px;
            float: right;
        }
        button[type="submit"]:hover {
            background-color: #0056b3;
        }
        h2 {
            margin-top: 20px;
        }
        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 20px;
        }
        th, td {
            border: 1px solid #ccc;
            padding: 8px;
            text-align: left;
        }
        th {
            background-color: #f2f2f2;
        }
    </style>
</head>
<body>
    <div class="container">
        <h1>Welcome, <?php echo $_SESSION['name']; ?></h1>

        <form method="POST" action="logout.php">
            <button type="submit">Logout</button>
        </form>

        <?php
        $department_query = "SELECT department_id FROM Employees WHERE role = 'head_of_department' AND username = '" . $_SESSION['username'] . "'";
        $department_result = $conn->query($department_query);
        if ($department_result->num_rows > 0) {
            $row = $department_result->fetch_assoc();
            $department_id = $row['department_id'];

			$exams_query = "SELECT * FROM Exams WHERE department_id = $department_id ORDER BY exam_date ASC";
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

            $assistants_query = "SELECT * FROM Assistants WHERE department_id = $department_id";
            $assistants_result = $conn->query($assistants_query);

            if ($assistants_result->num_rows > 0) {
                $total_score = 0;
                while ($assistant = $assistants_result->fetch_assoc()) {
                    $total_score += $assistant['score'];
                }

                $assistants_result->data_seek(0); 
                echo "<h2>Assistant Workloads:</h2>";
                echo "<table border='1'>
                        <tr>
                            <th>Assistant Name</th>
                            <th>Percentage</th>
                        </tr>";
                while ($assistant = $assistants_result->fetch_assoc()) {
                    $score = $assistant['score'];
                    $percentage = ($score / $total_score) * 100;
                    echo "<tr>
                            <td>" . $assistant['name'] . "</td>
                            <td>" . round($percentage, 2) . "%</td>
                        </tr>";
                }
                echo "</table>";
            } else {
                echo "<p>No assistants found for the department.</p>";
            }
        } else {
            echo "<p>Department not found for the current user.</p>";
        }
        ?>

    </div>
</body>
</html>

<?php
$conn->close();
?>
