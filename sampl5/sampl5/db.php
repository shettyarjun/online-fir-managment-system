<?php
// db.php

$servername = "localhost";
$username = "root";
$password = ""; // Assuming no password is set
$database = "fir";

// Create connection
$conn = new mysqli($servername, $username, $password, $database);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}
?>
