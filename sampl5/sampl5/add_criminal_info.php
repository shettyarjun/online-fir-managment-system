<?php
session_start();
require_once('db.php');

if(isset($_POST['name'], $_POST['age'], $_POST['description'], $_POST['date_of_capture'], $_POST['complaint_id'])) {
    $name = $_POST['name'];
    $age = $_POST['age'];
    $description = $_POST['description'];
    $date_of_capture = mysqli_real_escape_string($conn, $_POST['date_of_capture']);
    $complaint_id = $_POST['complaint_id'];

    $query = "INSERT INTO criminals (name, age, description, date_of_capture, complaint_id) VALUES (?, ?, ?, ?, ?)";

    if($stmt = $conn->prepare($query)){
        $stmt->bind_param("sisii", $name, $age, $description, $date_of_capture, $complaint_id);
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
