<?php
session_start();
require_once('db.php'); // Your database connection file
require_once('db_functions.php'); // Include the functions file


// Process login form submission
if(isset($_POST['login'])) {
    $username = $_POST['username'];
    $password = $_POST['password'];
    $role = $_POST['role']; // New: Get selected role
    $error = login($username, $password, $role);
}

// Redirect logged-in users to appropriate dashboard
if(isset($_SESSION['user_id'])) {
    header('Location: dashboard.php');
    exit();
} elseif(isset($_SESSION['police_id'])) {
    header('Location: police_dashboard.php');
    exit();
} elseif(isset($_SESSION['admin_id'])) {
    header('Location: admin_dashboard.php');
    exit();
}
?>


<!DOCTYPE html>
<html lang="en">
<head>
    <title>FIR Management Service</title>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <style>
        body {
            background-color: #1a1a1a;
            color: #ffffff;
            font-family: Arial, sans-serif;
            margin-top: 50px;
        }
        .container {
            max-width: 600px;
        }
        .login-form {
            background-color: rgba(0, 0, 0, 0.5);
            padding: 30px;
            border-radius: 20px;
            box-shadow: 0 10px 20px rgba(0, 0, 0, 0.3);
            position: relative;
            overflow: hidden;
        }
        h2 {
            text-align: center;
            color: #ffffff;
            margin-bottom: 30px;
            font-size: 40px;
            text-shadow: 2px 2px 4px rgba(0, 0, 0, 0.5);
        }
        label {
            font-weight: bold;
            color: #ffffff;
            font-size: 18px;
        }
        select {
            color: #000;
        }
        button {
            margin-top: 30px;
            width: 100%;
            background-color: #ffffff;
            color: #1a1a1a;
            padding: 15px 0;
            font-size: 20px;
            font-weight: 600;
            border: none;
            border-radius: 5px;
            cursor: pointer;
            transition: background-color 0.3s ease;
            box-shadow: 0 4px 10px rgba(0, 0, 0, 0.2);
        }
        button:hover {
            background-color: #4d089a;
            color: #ffffff;
        }
        .form-group {
            position: relative;
            margin-bottom: 30px;
        }
        .form-group label::after {
            content: '*';
            color: #ff5454;
            position: absolute;
            top: 8px;
            right: -10px;
            font-size: 18px;
        }
        .btn-primary {
            background-color: #6a11cb;
            border-color: #6a11cb;
            transition: background-color 0.3s ease;
            box-shadow: 0 4px 10px rgba(106, 17, 203, 0.4);
        }
        .btn-primary:hover {
            background-color: #4d089a;
            border-color: #4d089a;
        }
        .btn-primary:focus {
            box-shadow: 0 0 0 0.2rem rgba(106, 17, 203, 0.5);
        }
        .login-form h3::before {
            content: "";
            position: absolute;
            top: -10px;
            left: 50%;
            transform: translateX(-50%);
            width: 60px;
            height: 3px;
            background-color: #ffffff;
            border-radius: 50px;
        }
        .login-form h3 {
            text-align: center;
            position: relative;
            margin-bottom: 40px;
            color: #ffffff;
            font-size: 28px;
        }
        .form-control {
            background-color: rgba(255, 255, 255, 0.1);
            color: #ffffff;
            border: none;
            border-bottom: 2px solid rgba(255, 255, 255, 0.4);
            transition: border-color 0.3s ease;
            border-radius: 0;
            font-size: 18px;
            padding: 10px 0;
        }
        .form-control:focus {
            background-color: rgba(255, 255, 255, 0.3);
            color: #ffffff;
            border-color: #ffffff;
        }
        .login-form a {
            display: block;
            text-align: center;
            color: #ffffff;
            transition: color 0.3s ease;
        }
        .login-form a:hover {
            color: #6a11cb;
            text-decoration: none;
        }
    </style>
</head>
<body>
    <div class="container">
        <h2>FIR Management Service</h2>
        <div class="row">
            <div class="col-md-6">
                <div class="login-form">
                    <h3>Login</h3>
                    <form method="POST">
                        <div class="form-group">
                            <label for="username">Username:</label>
                            <input type="text" class="form-control" id="username" name="username" required>
                        </div>
                        <div class="form-group">
                            <label for="password">Password:</label>
                            <input type="password" class="form-control" id="password" name="password" required>
                        </div>
                        <div class="form-group">
                            <label for="role">Role:</label>
                            <select class="form-control" id="role" name="role" style="color: black;">
                                <option value="user">User</option>
                                <option value="police">Police</option>
                                <option value="admin">Admin</option>
                            </select>
                        </div>
                        <button type="submit" class="btn btn-primary" name="login">Login</button>
                    </form>
                </div>
            </div>
            <div class="col-md-6">
                <div class="login-form">
                    <h3>Sign Up</h3>
                    <a href="signup.php" class="btn btn-primary">Sign Up</a>
                </div>
            </div>
        </div>
    </div>
    <div>
    
</body>
</html>
