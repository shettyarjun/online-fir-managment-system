<?php
session_start();
require_once('db.php');

if(isset($_POST['description'], $_POST['location_found'], $_POST['complaint_id'])) {
    $description = $_POST['description'];
    $location_found = $_POST['location_found'];
    $complaint_id = $_POST['complaint_id'];

    $query = "INSERT INTO evidence (description, location_found, complaint_id) VALUES (?, ?, ?)";

    if($stmt = $conn->prepare($query)){
        $stmt->bind_param("ssi", $description, $location_found, $complaint_id);
        if($stmt->execute()) {
            header('Location: police_dashboard.php');
            exit();
        } else {
            echo "Error: Unable to execute query.";
        }
        $stmt->close();
    } else {
        echo "Error: Unable to prepare statement.";
    }
}
?>
