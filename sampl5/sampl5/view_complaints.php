<?php
session_start();
require_once('db.php');

if(!isset($_SESSION['user_id'])) {
    header('Location: index.php');
    exit();
}

// Function to display the form for adding evidence and witness information
function displayEvidenceWitnessForm($complaint_id) {
    echo "<form method='post' action='submit_evidence_witness.php'>";
    echo "<input type='hidden' name='complaint_id' value='$complaint_id'>";
    echo "<div class='form-group'>";
    echo "<label for='evidence'>Evidence:</label>";
    echo "<textarea class='form-control' id='evidence' name='description'></textarea>";
    echo "</div>";
    echo "<div class='form-group'>";
    echo "<label for='witness'>Witness:</label>";
    echo "<input type='text' class='form-control' id='witness' name='name'>";
    echo "</div>";
    echo "<button type='submit' class='btn btn-primary'>Submit</button>";
    echo "</form>";
}

?>

<!DOCTYPE html>
<html>
<head>
    <title>View Complaints</title>
    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
</head>
<body>
    <div class="container">
        <h2>Your Complaints</h2>
        
        <table class="table">
            <thead>
                <tr>
                    <th>Description</th>
                    <th>Date</th>
                    <th>Status</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                <?php
                // Query to retrieve the user's complaints
                $user_id = $_SESSION['user_id'];
                $query = "SELECT * FROM Complaints WHERE user_id=?";
                $stmt = $conn->prepare($query);
                $stmt->bind_param("i", $user_id);
                $stmt->execute();
                $result = $stmt->get_result();
                
                // Display the complaints
                while($row = $result->fetch_assoc()) {
                    echo "<tr>";
                    echo "<td>{$row['description']}</td>";
                    echo "<td>{$row['date']}</td>";
                    echo "<td>{$row['status']}</td>";
                    echo "<td>"; // Actions column
                    // Display form for adding evidence and witness information
                    displayEvidenceWitnessForm($row['id']);
                    echo "</td>";
                    echo "</tr>";
                }
                ?>
            </tbody>
        </table>
        
        <!-- Link to go back to the dashboard -->
        <a href="dashboard.php" class="btn btn-primary">Back to Dashboard</a>
    </div>
    <!-- Bootstrap JS -->
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.16.0/umd/popper.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</body>
</html>
