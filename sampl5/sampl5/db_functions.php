<?php
require_once('db.php');

function login($username, $password, $role) {
    global $conn;

    // Escape user inputs to prevent SQL injection
    $username = mysqli_real_escape_string($conn, $username);
    $password = mysqli_real_escape_string($conn, $password);

    // Query to check login based on role
    $query = "SELECT * FROM Users WHERE username='$username' AND password='$password' AND role='$role'";
    $result = mysqli_query($conn, $query);

    // Check if the role is police
    if ($role === 'police') {
        $query = "SELECT * FROM Police WHERE username='$username' AND password='$password'";
        $result = mysqli_query($conn, $query);
        if (mysqli_num_rows($result) == 1) {
            $_SESSION['police_id'] = 1; // You can set any value for police_id
            header('Location: police_dashboard.php');
            exit();
        }
    }

    if (mysqli_num_rows($result) == 1) {
        $row = mysqli_fetch_assoc($result);
        // Set session variables based on role
        switch ($role) {
            case 'user':
                $_SESSION['user_id'] = $row['id'];
                break;
            case 'police':
                $_SESSION['police_id'] = $row['id'];
                break;
            case 'admin':
                $_SESSION['admin_id'] = $row['id'];
                break;
        }
        header('Location: dashboard.php'); // Redirect to appropriate dashboard
        exit();
    } else {
        return "Invalid credentials";
    }
}


function signup($username, $password, $email, $role) {
    global $conn;
    $username = mysqli_real_escape_string($conn, $username);
    $password = mysqli_real_escape_string($conn, $password);
    $email = mysqli_real_escape_string($conn, $email);
    
    $query = "INSERT INTO Users (username, password, email, role) VALUES ('$username', '$password', '$email', '$role')";
    
    if(mysqli_query($conn, $query)) {
        return true;
    } else {
        return "Error: " . $query . "<br>" . mysqli_error($conn);
    }
}

function insertEvidence($complaint_id, $description, $location_found, $conn) {
    $query = "INSERT INTO evidence (complaint_id, description, location_found) VALUES (?, ?, ?)";
    $stmt = $conn->prepare($query);
    $stmt->bind_param("iss", $complaint_id, $description, $location_found);
    if ($stmt->execute()) {
        return true;
    } else {
        return false;
    }
}

function insertWitness($complaint_id, $name, $contact_info, $conn) {
    $query = "INSERT INTO witnesses (complaint_id, name, contact_info) VALUES (?, ?, ?)";
    $stmt = $conn->prepare($query);
    $stmt->bind_param("iss", $complaint_id, $name, $contact_info);
    if ($stmt->execute()) {
        return true;
    } else {
        return false;
    }
}

?>
