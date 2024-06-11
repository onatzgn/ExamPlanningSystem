<?php
session_start();
require 'db_connection.php'; 

if ($_SESSION['role'] != 'secretary') {
    header("Location: login.php");
    exit();
}

$message = "";

if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['create_exam'])) {
    $exam_name = $_POST['exam_name'];
    $exam_date = $_POST['exam_date'];
    $exam_time = $_POST['exam_time'];
    $num_classes = $_POST['num_classes'];
    $num_assistants = $_POST['num_assistants']; 
    $department_id = $_POST['department_id'];
    $course_id = $_POST['course_id'];

    if ($department_id > 0 && $course_id > 0) {
        $stmt = $conn->prepare("INSERT INTO Exams (exam_name, exam_date, exam_time, num_classes, department_id, course_id, num_assistants) VALUES (?, ?, ?, ?, ?, ?, ?)");
        $stmt->bind_param("sssiiii", $exam_name, $exam_date, $exam_time, $num_classes, $department_id, $course_id, $num_assistants); 

        if ($stmt->execute() === TRUE) {
            $message = "Exam created successfully.";
        } else {
            $message = "Error creating exam: " . $stmt->error;
        }

        $stmt->close();
    } else {
        $message = "Invalid department or course ID.";
    }
}

if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['add_course'])) {
    $course_name = $_POST['course_name'];
    $department_id = $_POST['department_id'];

    if ($department_id > 0) {
        $stmt = $conn->prepare("INSERT INTO Courses (name, department_id) VALUES (?, ?)");
        $stmt->bind_param("si", $course_name, $department_id);

        if ($stmt->execute() === TRUE) {
            $message = "Course added successfully.";
        } else {
            $message = "Error adding course: " . $stmt->error;
        }

        $stmt->close();
    } else {
        $message = "Invalid department ID.";
    }
}

if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['assign_assistants'])) {
    $exam_id = $_POST['exam_id'];
    $assistant_ids = $_POST['assistant_ids'];

    $stmt = $conn->prepare("SELECT num_assistants FROM Exams WHERE id = ?");
    $stmt->bind_param("i", $exam_id);
    $stmt->execute();
    $stmt->bind_result($num_assistants_needed);
    $stmt->fetch();
    $stmt->close();

    if (count($assistant_ids) == $num_assistants_needed) {
        $errors = [];
        foreach ($assistant_ids as $assistant_id) {
            $stmt = $conn->prepare("INSERT INTO AssistantsExams (assistant_id, exam_id) VALUES (?, ?)");
            $stmt->bind_param("ii", $assistant_id, $exam_id);

            if (!$stmt->execute()) {
                $errors[] = "Error assigning assistant ID $assistant_id: " . $stmt->error;
            } else {
                $update_score_stmt = $conn->prepare("UPDATE Assistants SET score = score + 1 WHERE id = ?");
                $update_score_stmt->bind_param("i", $assistant_id);
                $update_score_stmt->execute();
                $update_score_stmt->close();
            }

            $stmt->close();
        }

        if (empty($errors)) {
            $message = "Assistants assigned to exam successfully.";
        } else {
            $message = implode("<br>", $errors);
        }
    } else {
        $message = "Please select exactly $num_assistants_needed assistants.";
    }
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Secretary Dashboard</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f2f2f2;
            margin: 0;
            padding: 20px;
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
        input, select, button {
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
        p {
            color: green;
            margin-top: 0;
        }
        table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 20px;
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
    <h1>Welcome, <?php echo $_SESSION['name']; ?></h1>
    
    <form method="POST" action="logout.php" class="logout-btn">
        <button type="submit">Logout</button>
    </form>
    
    <?php
    if (!empty($message)) {
        echo "<p>$message</p>";
    }
    ?>
    
    <h2>Create Exam</h2>
    <form method="POST" action="">
        <label for="exam_name">Exam Name:</label>
        <input type="text" id="exam_name" name="exam_name" required><br>

        <label for="exam_date">Exam Date:</label>
        <input type="date" id="exam_date" name="exam_date" required><br>

        <label for="exam_time">Exam Time:</label>
        <input type="time" id="exam_time" name="exam_time" required><br>

        <label for="num_classes">Number of Classes:</label>
        <input type="number" id="num_classes" name="num_classes" required><br>

        <label for="num_assistants">Number of Assistants:</label>
        <input type="number" id="num_assistants" name="num_assistants" required><br> 

        <label for="department_id">Select Department:</label>
        <select name="department_id" id="department_id" required>
            <?php
            $departments_query = "SELECT * FROM Departments";
            $departments_result = $conn->query($departments_query);
            while ($department = $departments_result->fetch_assoc()) {
                echo "<option value='" . $department['id'] . "'>" . $department['name'] . "</option>";
            }
            ?>
        </select><br>

        <label for="course_id">Select Course:</label>
        <select name="course_id" id="course_id" required>
            <?php
            $courses_query = "SELECT * FROM Courses";
            $courses_result = $conn->query($courses_query);
            while ($course = $courses_result->fetch_assoc()) {
                echo "<option value='" . $course['id'] . "'>" . $course['name'] . "</option>";
            }
            ?>
        </select><br>

        <button type="submit" name="create_exam">Create Exam</button>
    </form>

    <h2>Add Course</h2>
    <form method="POST" action="">
        <label for="course_name">Course Name:</label>
        <input type="text" id="course_name" name="course_name" required><br>

        <label for="department_id">Select Department:</label>
        <select name="department_id" id="department_id" required>
            <?php
            $departments_query = "SELECT * FROM Departments";
            $departments_result = $conn->query($departments_query);
            while ($department = $departments_result->fetch_assoc()) {
                echo "<option value='" . $department['id'] . "'>" . $department['name'] . "</option>";
            }
            ?>
        </select><br>

        <button type="submit" name="add_course">Add Course</button>
    </form>

    <h2>Assign Assistants to Exams</h2>
    <form method="POST" action="">
        <label for="exam_id">Select Exam:</label>
        <select name="exam_id" id="exam_id" required>
            <?php
            $exams_query = "SELECT * FROM Exams";
            $exams_result = $conn->query($exams_query);
            while ($exam = $exams_result->fetch_assoc()) {
                echo "<option value='" . $exam['id'] . "'>" . $exam['exam_name'] . "</option>";
            }
            ?>
        </select><br>

        <label for="assistant_ids">Select Assistants:</label>
        <select name="assistant_ids[]" id="assistant_ids" multiple required>
            <?php
            $assistants_query = "SELECT * FROM Employees WHERE role = 'assistant'";
            $assistants_result = $conn->query($assistants_query);
            while ($assistant = $assistants_result->fetch_assoc()) {
                echo "<option value='" . $assistant['id'] . "'>" . $assistant['name'] . "</option>";
            }
            ?>
        </select><br>

        <button type="submit" name="assign_assistants">Assign Assistants</button>
    </form>

    <h2>Assistant Scores</h2>
    <table border="1">
        <tr>
            <th>Assistant Name</th>
            <th>Department</th>
            <th>Score</th>
        </tr>
        <?php
        $scores_query = "
            SELECT a.name as assistant_name, d.name as department_name, a.score
            FROM Assistants a
            JOIN Departments d ON a.department_id = d.id
            ORDER BY a.score DESC";
        $scores_result = $conn->query($scores_query);

        while ($row = $scores_result->fetch_assoc()) {
            echo "<tr>";
            echo "<td>" . $row['assistant_name'] . "</td>";
            echo "<td>" . $row['department_name'] . "</td>";
            echo "<td>" . $row['score'] . "</td>";
            echo "</tr>";
        }
        ?>
    </table>
    </div>
</body>
</html>

<?php
$conn->close();
?>
