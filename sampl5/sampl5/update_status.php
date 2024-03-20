<?php
session_start();
require_once('db.php');

// Check if complaint ID is provided and the status needs to be updated
if(isset($_GET['id'])) {
    $id = $_GET['id'];
    
    // Prepare the query to update the status of complaints
    $update_complaint_query = "UPDATE Complaints SET status='completed' WHERE id=?";
    
    // Prepare and bind parameters to prevent SQL injection
    if($stmt = $conn->prepare($update_complaint_query)){
        $stmt->bind_param("i", $id);
        if($stmt->execute()) {
            // Redirect back to the police dashboard after successful update
            header('Location: police_dashboard.php');
            exit();
        } else {
            // Handle query execution error for updating status of complaints
            echo "Error updating status of complaints: " . $stmt->error;
        }
        $stmt->close();
    } else {
        // Handle query preparation error
        echo "Error: Unable to prepare statement.";
    }
} else {
    // Handle missing complaint ID
    echo "Complaint ID not provided";
}
?>
