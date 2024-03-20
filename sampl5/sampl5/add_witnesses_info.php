<?php
session_start();
require_once('db.php');

if(isset($_POST['name'], $_POST['contact_info'], $_POST['complaint_id'])) {
    $name = $_POST['name'];
    $contact_info = $_POST['contact_info'];
    $complaint_id = $_POST['complaint_id'];

    $query = "INSERT INTO witnesses (name, contact_info, complaint_id) VALUES (?, ?, ?)";

    if($stmt = $conn->prepare($query)){
        $stmt->bind_param("ssi", $name, $contact_info, $complaint_id);
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
