<?php
session_start();
require_once('db.php');

if(isset($_POST['username'], $_POST['password'], $_POST['email'])) {
    // Prepare and bind parameters
    $username = $_POST['username'];
    $password = $_POST['password'];
    $email = $_POST['email'];

    $query = "INSERT INTO Police (username, password, email) VALUES (?, ?, ?)";
    
    if($stmt = $conn->prepare($query)){
        $stmt->bind_param("sss", $username, $password, $email);
        if($stmt->execute()) {
            header('Location: admin_dashboard.php');
            exit();
        } else {
            echo "Error: Unable to execute query.";
        }
        $stmt->close();
    } else {
        echo "Error: Unable to prepare statement.";
    }
} else {
    echo "All fields are required";
}
?>
