<?php
session_start();
if(!isset($_SESSION['admin_id'])) {
    header('Location: index.php');
    exit();
}

// Check if the admin is authenticated
if(isset($_POST['login'])) {
    $username = $_POST['username'];
    $password = $_POST['password'];
    if($username === 'admin' && $password === 'pass') {
        // Set admin session variable to authenticate
        $_SESSION['admin_id'] = 1; // You can set any value for admin_id
        header('Location: admin_dashboard.php');
        exit();
    } else {
        $error = "Invalid credentials";
    }
}
?><!DOCTYPE html>
<html>
<head>
    <title>Admin Dashboard</title>
    <!-- Bootstrap CSS -->
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
            margin: auto;
        }
        .card {
            margin-bottom: 20px;
            background-color: #2a2a2a;
            border: 1px solid #333333;
            border-radius: 10px;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
        }
        .card-title {
            color: #ffffff;
            text-align: center;
            margin-bottom: 20px;
        }
        .form-group label {
            font-weight: bold;
        }
        .form-control {
            background-color: #333333;
            color: #ffffff;
            border: 1px solid #666666;
        }
        .form-control:focus {
            background-color: #434343;
            color: #ffffff;
            border-color: #666666;
            box-shadow: none;
        }
        .btn-primary {
            background-color: #007bff;
            border-color: #007bff;
        }
        .btn-primary:hover {
            background-color: #0056b3;
            border-color: #0056b3;
        }
        .btn-danger {
            background-color: #dc3545;
            border-color: #dc3545;
        }
        .btn-danger:hover {
            background-color: #c82333;
            border-color: #bd2130;
        }
    </style>
</head>
<body>
    <div class="container">
        <div class="card">
            <div class="card-body">
                <h2 class="card-title">Welcome, Admin!</h2>
            </div>
        </div>
        
        <!-- Add Police Account Form -->
        <div class="card">
            <div class="card-body">
                <h3 class="card-title">Add Police Account</h3>
                <form action="add_police.php" method="POST">
                    <div class="form-group">
                        <label>Username:</label>
                        <input type="text" class="form-control" name="username" required>
                    </div>
                    <div class="form-group">
                        <label>Password:</label>
                        <input type="password" class="form-control" name="password" required>
                    </div>
                    <div class="form-group">
                        <label>Email:</label>
                        <input type="email" class="form-control" name="email" required>
                    </div>
                    <button type="submit" class="btn btn-primary btn-block">Add Police</button>
                </form>
            </div>
        </div>

        <!-- Logout Button -->
        <div class="card">
            <div class="card-body">
                <form action="logout.php" method="POST">
                    <button type="submit" class="btn btn-danger btn-block">Logout</button>
                </form>
            </div>
        </div>
    </div>
    <!-- Bootstrap JS -->
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.16.0/umd/popper.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</body>
</html>
