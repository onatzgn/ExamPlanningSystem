<?php
session_start();
require 'db_connection.php'; 

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    if(isset($_POST['forgot_password'])) {
        $forgot_username = $_POST['forgot_username'];
        $new_password = md5($_POST['new_password']); 
        
        $query = "SELECT * FROM Employees WHERE username='$forgot_username'";
        $result = mysqli_query($conn, $query);
        
        if (mysqli_num_rows($result) == 1) {
            $update_query = "UPDATE Employees SET password='$new_password' WHERE username='$forgot_username'";
            if(mysqli_query($conn, $update_query)) {
                $success_message = "Password updated successfully";
            } else {
                $error_message = "Error updating password";
            }
        } else {
            $error_message = "Invalid username";
        }
    } else {
        $username = $_POST['username'];
        $password = md5($_POST['password']);
        
        $query = "SELECT * FROM Employees WHERE username='$username' AND password='$password'";
        $result = mysqli_query($conn, $query);
        
        if (mysqli_num_rows($result) == 1) {
            $user = mysqli_fetch_assoc($result);
            $_SESSION['user_id'] = $user['id'];
            $_SESSION['username'] = $user['username'];
            $_SESSION['role'] = $user['role'];
            $_SESSION['name'] = $user['name'];
            
            header("Location: dashboard.php");
        } else {
            $error_message = "Invalid username or password";
        }
    }
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Login</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 0;
            background-color: #f2f2f2;
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
        }
        .container {
            display: flex;
            flex-direction: column;
            align-items: center;
        }
        form {
            background-color: #fff;
            padding: 20px;
            border-radius: 5px;
            box-shadow: 0 2px 5px rgba(0,0,0,0.1);
            width: 300px;
            margin-bottom: 20px;
        }
        label {
            display: block;
            margin-bottom: 5px;
            font-weight: bold;
        }
        input[type="text"],
        input[type="password"] {
            width: calc(100% - 12px);
            padding: 6px;
            margin-bottom: 10px;
            border: 1px solid #ccc;
            border-radius: 3px;
        }
        button[type="submit"] {
            background-color: #007bff; 
            color: white;
            padding: 10px 20px;
            border: none;
            border-radius: 3px;
            cursor: pointer;
        }
        button[type="submit"]:hover {
            background-color: #0056b3; 
        }
        .forgot-password-button {
            background-color: #dc3545;
            color: white;
            border: none;
            padding: 10px 20px;
            border-radius: 3px;
            cursor: pointer;
            margin-bottom: 20px;
        }
        .forgot-password-button:hover {
            background-color: #bd2130; 
        }
        .back-button {
            background-color: #6c757d; 
            color: white;
            border: none;
            padding: 10px 20px;
            border-radius: 3px;
            cursor: pointer;
        }
        .back-button:hover {
            background-color: #5a6268; 
        }
        .message {
            color: black;
            margin-top: 10px;
        }
    </style>
</head>
<body>
    <div class="container">
        <form method="POST" action="">
            <h2>Giriş Yap</h2>
            <label for="username">Username:</label>
            <input type="text" id="username" name="username" required><br>
            <label for="password">Password:</label>
            <input type="password" id="password" name="password" required><br>
            <button type="submit">Login</button>
        </form>
        
        <!-- Şifreni mi unuttun düğmesi -->
        <button class="forgot-password-button" onclick="toggleForgotPasswordForm()">Forgot Password</button>
        
        <!-- Şifre sıfırlama formu -->
        <form method="POST" action="" id="forgotPasswordForm" style="display: none;">
            <h2>Forgot Password</h2>
            <label for="forgot_username">Username:</label>
            <input type="text" id="forgot_username" name="forgot_username" required><br>
            <label for="new_password">New Password:</label>
            <input type="password" id="new_password" name="new_password" required><br>
            <input type="hidden" name="forgot_password" value="1">
            <button type="submit">Reset Password</button>
        </form>
        
        <!-- Uyarı mesajı -->
        <div class="message">
            <?php
            if(isset($error_message)) {
                echo $error_message;
            } elseif(isset($success_message)) {
                echo $success_message;
            }
            ?>
        </div>
    </div>
    
    <script>
        function toggleForgotPasswordForm() {
            var forgotPasswordForm = document.getElementById("forgotPasswordForm");
            if (forgotPasswordForm.style.display === "none") {
                forgotPasswordForm.style.display = "block";
            } else {
                forgotPasswordForm.style.display = "none";
            }
        }

    </script>
</body>
</html>
