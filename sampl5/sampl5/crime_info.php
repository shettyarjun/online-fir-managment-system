<?php
session_start();
require_once('db.php');

// Check if the form is submitted for adding crime information
if(isset($_POST['submit'])) {
    // Extracting criminal information
    $criminal_name = $_POST['criminal_name'];
    $criminal_age = $_POST['criminal_age'];
    $criminal_description = $_POST['criminal_description'];
    $date_of_capture = $_POST['date_of_capture'];
    $complaint_id = $_POST['complaint_id'];

    // Extracting evidence information
    $evidence_description = $_POST['evidence_description'];
    $location_found = $_POST['location_found'];

    // Extracting witness information
    $witness_name = $_POST['witness_name'];
    $witness_contact_info = $_POST['witness_contact_info'];

    // Inserting criminal information
    $query_criminal = "INSERT INTO Criminals (name, age, description, date_of_capture, complaint_id) VALUES (?, ?, ?, ?, ?)";
    if($stmt_criminal = $conn->prepare($query_criminal)){
        $stmt_criminal->bind_param("sisii", $criminal_name, $criminal_age, $criminal_description, $date_of_capture, $complaint_id);
        $stmt_criminal->execute();
        $stmt_criminal->close();
    } else {
        echo "Error: Unable to prepare statement for criminal information.";
    }

    // Inserting evidence information
    $query_evidence = "INSERT INTO evidence (description, location_found, complaint_id) VALUES (?, ?, ?)";
    if($stmt_evidence = $conn->prepare($query_evidence)){
        $stmt_evidence->bind_param("ssi", $evidence_description, $location_found, $complaint_id);
        $stmt_evidence->execute();
        $stmt_evidence->close();
    } else {
        echo "Error: Unable to prepare statement for evidence information.";
    }

    // Inserting witness information
    $query_witness = "INSERT INTO witnesses (name, contact_info, complaint_id) VALUES (?, ?, ?)";
    if($stmt_witness = $conn->prepare($query_witness)){
        $stmt_witness->bind_param("ssi", $witness_name, $witness_contact_info, $complaint_id);
        $stmt_witness->execute();
        $stmt_witness->close();
    } else {
        echo "Error: Unable to prepare statement for witness information.";
    }

    // Redirect after successful insertion
    header('Location: crime_info.php');
    exit();
}
?><!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Add Crime Information</title>
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
        }
        .card-body {
            padding: 20px;
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
        a {
            color: #ffffff;
        }
        a:hover {
            color: #cccccc;
        }
    </style>
</head>
<body>
    <div class="container">
        <h2>Add Crime Information</h2>
        <!-- Crime Information Form -->
        <div class="card">
            <div class="card-body">
                <h3 class="card-title">Suspect Information</h3>
                <form method="POST" action="">
                    <div class="form-group">
                        <label for="complaint_id">Complaint ID:</label>
                        <input type="text" class="form-control" id="complaint_id" name="complaint_id" required>
                    </div>
                    <!-- Criminal Information -->
                    <div class="form-group">
                        <label for="criminal_name">Criminal Name:</label>
                        <input type="text" class="form-control" id="criminal_name" name="criminal_name" required>
                    </div>
                    <div class="form-group">
                        <label for="criminal_age">Criminal Age:</label>
                        <input type="number" class="form-control" id="criminal_age" name="criminal_age" required>
                    </div>
                    <div class="form-group">
                        <label for="criminal_description">Criminal Description:</label>
                        <textarea class="form-control" id="criminal_description" name="criminal_description" required></textarea>
                    </div>
                    <div class="form-group">
                        <label for="date_of_capture">Date of Capture:</label>
                        <input type="date" class="form-control" id="date_of_capture" name="date_of_capture" required>
                    </div>
                    <!-- Evidence Information -->
                    <div class="form-group">
                        <h4>Evidence Information</h4>
                        <label for="evidence_description">Description:</label>
                        <textarea class="form-control" id="evidence_description" name="evidence_description" required></textarea>
                    </div>
                    <div class="form-group">
                        <label for="location_found">Location Found:</label>
                        <input type="text" class="form-control" id="location_found" name="location_found" required>
                    </div>
                    <!-- Witness Information -->
                    <div class="form-group">
                        <h4>Witness Information</h4>
                        <label for="witness_name">Witness Name:</label>
                        <input type="text" class="form-control" id="witness_name" name="witness_name" required>
                    </div>
                    <div class="form-group">
                        <label for="witness_contact_info">Contact Information:</label>
                        <input type="text" class="form-control" id="witness_contact_info" name="witness_contact_info" required>
                    </div>
                    <button type="submit" class="btn btn-primary" name="submit">Submit</button>
                </form>
            </div>
        </div>
        <a href="admin_dashboard.php" class="btn btn-primary">Back to Dashboard</a>
    </div>
</body>
</html>
