<?php
session_start();
require_once('db.php');

function signup($username, $password, $email, $role = 'user') {
    global $conn;

    // Escape user inputs to prevent SQL injection
    $username = mysqli_real_escape_string($conn, $username);
    $password = mysqli_real_escape_string($conn, $password);
    $email = mysqli_real_escape_string($conn, $email);

    // Check if the username or email already exists
    $check_query = "SELECT * FROM Users WHERE username='$username' OR email='$email'";
    $result = mysqli_query($conn, $check_query);
    if(mysqli_num_rows($result) > 0) {
        return "Username or email already exists";
    }

    // Insert new user into database with default role
    $query = "INSERT INTO Users (username, password, email, role) VALUES ('$username', '$password', '$email', '$role')";
    if(mysqli_query($conn, $query)) {
        return true;
    } else {
        return "Error: " . $query . "<br>" . mysqli_error($conn);
    }
}

if(isset($_POST['signup'])) {
    $username = $_POST['username'];
    $password = $_POST['password'];
    $email = $_POST['email'];
    
    $signup_result = signup($username, $password, $email);
    if($signup_result === true) {
        // Signup successful, redirect to login page
        header('Location: index.php');
        exit();
    } else {
        // Signup failed, display error message
        $error = $signup_result;
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <title>Sign Up</title>
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
            max-width: 500px;
        }
        .card {
            background-color: rgba(255, 255, 255, 0.1);
            border: 1px solid rgba(255, 255, 255, 0.3);
            border-radius: 20px;
            box-shadow: 0 10px 20px rgba(0, 0, 0, 0.3);
        }
        h2 {
            text-align: center;
            margin-bottom: 30px;
            font-size: 40px;
            text-shadow: 2px 2px 4px rgba(0, 0, 0, 0.5);
        }
        label {
            font-weight: bold;
            font-size: 18px;
        }
        input[type="text"],
        input[type="password"],
        input[type="email"] {
            background-color: rgba(255, 255, 255, 0.1);
            color: #ffffff;
            border: none;
            border-bottom: 2px solid rgba(255, 255, 255, 0.4);
            border-radius: 0;
            font-size: 18px;
            padding: 10px 15px;
            margin-bottom: 20px;
            width: 100%;
            box-sizing: border-box;
        }
        button[type="submit"] {
            background-color: #6a11cb;
            color: #ffffff;
            border: none;
            border-radius: 5px;
            padding: 15px 0;
            font-size: 20px;
            font-weight: 600;
            width: 100%;
            cursor: pointer;
            transition: background-color 0.3s ease;
        }
        button[type="submit"]:hover {
            background-color: #4d089a;
        }
        .alert {
            background-color: #ff5454;
            color: #ffffff;
            padding: 10px;
            border-radius: 5px;
            margin-top: 20px;
        }
        .alert-danger {
            background-color: #ff5454;
        }
        .alert-success {
            background-color: #28a745;
        }
    </style>
</head>
<body>
    <div class="container">
        <h2>Sign Up</h2>
        <div class="card">
            <div class="card-body">
                <h3 class="card-title text-center">Sign Up</h3>
                <form method="POST">
                    <div class="form-group">
                        <label for="signup-username">Username:</label>
                        <input type="text" id="signup-username" name="username" required>
                    </div>
                    <div class="form-group">
                        <label for="signup-password">Password:</label>
                        <input type="password" id="signup-password" name="password" required>
                    </div>
                    <div class="form-group">
                        <label for="signup-email">Email:</label>
                        <input type="email" id="signup-email" name="email" required>
                    </div>
                    <button type="submit" name="signup">Sign Up</button>
                </form>
                <?php if(isset($error)) { ?>
                    <div class="alert alert-danger mt-3" role="alert">
                        <?php echo $error; ?>
                    </div>
                <?php } ?>
            </div>
        </div>
    </div>
    <!-- Bootstrap JS -->
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.16.0/umd/popper.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</body>
</html>
