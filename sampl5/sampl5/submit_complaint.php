<?php
session_start();
require_once('db.php');

// Check if all required fields are provided
if(isset($_POST['name'], $_POST['age'], $_POST['description'], $_POST['date_of_capture'], $_POST['complaint_id'])) {
    
    // Check if the session variable is set
    if(isset($_SESSION['police_id'])) {
        
        // Prepare and bind parameters
        $name = mysqli_real_escape_string($conn, $_POST['name']);
        $age = intval($_POST['age']); // Convert age to integer
        $description = mysqli_real_escape_string($conn, $_POST['description']);
        $date_of_capture = mysqli_real_escape_string($conn, $_POST['date_of_capture']);
        $complaint_id = intval($_POST['complaint_id']); // Convert complaint_id to integer
        
        // Prepare the SQL statement
        $query = "INSERT INTO Criminals (name, age, description, date_of_capture, complaint_id) VALUES (?, ?, ?, ?, ?)";
        
        // Prepare and execute the statement
        if($stmt = $conn->prepare($query)){
            $stmt->bind_param("sisii", $name, $age, $description, $date_of_capture, $complaint_id);
            if($stmt->execute()) {
                // Redirect to police dashboard after successful insertion
                header('Location: police_dashboard.php');
                exit();
            } else {
                // Handle execution error
                echo "Error: Unable to execute query.";
            }
            $stmt->close();
        } else {
            // Handle preparation error
            echo "Error: Unable to prepare statement.";
        }
    } else {
        // Redirect to index.php if police_id session variable is not set
        header('Location: index.php');
        exit();
    }
}

// Check if all required fields are provided
if(isset($_POST['description'], $_POST['date'], $_POST['type'], $_POST['severity'])) {
    
    // Check if the session variable is set
    if(isset($_SESSION['user_id'])) {
        
        // Prepare and bind parameters
        $description = mysqli_real_escape_string($conn, $_POST['description']);
        $date = mysqli_real_escape_string($conn, $_POST['date']);
        $type = mysqli_real_escape_string($conn, $_POST['type']);
        $severity = mysqli_real_escape_string($conn, $_POST['severity']);
        $user_id = $_SESSION['user_id']; // Retrieve user_id from session
        
        // Prepare the SQL statement to insert complaint
        $query = "INSERT INTO Complaints (user_id, description, date, type, severity, status) VALUES (?, ?, ?, ?, ?, 'pending')";
        
        // Prepare and execute the statement to insert complaint
        if($stmt = $conn->prepare($query)){
            $stmt->bind_param("issss", $user_id, $description, $date, $type, $severity);
            if($stmt->execute()) {
                // Redirect to user dashboard after successful complaint submission
                header('Location: dashboard.php');
                exit();
            } else {
                // Handle execution error
                echo "Error: Unable to execute query.";
            }
            $stmt->close();
        } else {
            // Handle preparation error
            echo "Error: Unable to prepare statement.";
        }
    } else {
        // Redirect to index.php if user_id session variable is not set
        header('Location: index.php');
        exit();
    }
} else {
    // Provide feedback for missing fields
    echo "All fields are required";
}
?>
