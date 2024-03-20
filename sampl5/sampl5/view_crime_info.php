<?php
session_start();
require_once('db.php');

// Check if the complaint ID is set in the URL
if(isset($_GET['complaint_id'])) {
    $complaint_id = $_GET['complaint_id'];

    // Fetch crime information from the view
    $view_query = "SELECT * FROM CrimeInformation WHERE id = ?";
    
    $stmt = $conn->prepare($view_query);
    $stmt->bind_param("i", $complaint_id);
    $stmt->execute();
    $crime_result = $stmt->get_result();

    // Check if any rows are returned
    if($crime_result->num_rows > 0) {
        // Display crime information
        ?>
        <!DOCTYPE html>
        <html lang="en">
        <head>
            <meta charset="UTF-8">
            <meta name="viewport" content="width=device-width, initial-scale=1.0">
            <title>Crime Information</title>
            <!-- Bootstrap CSS -->
            <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
                    <style>
            body {
                background-color: #000000;
                color: #ffffff;
                font-family: Arial, sans-serif;
                margin-top: 50px;
            }
            .container {
                margin-top: 50px;
            }
            h2 {
                margin-bottom: 20px;
                color: #ffffff;
            }
            table {
                width: 100%;
                border-collapse: collapse;
                color: #ffffff; /* Set text color to white */
            }
            th, td {
        border: 1px solid #333;
        padding: 10px;
        text-align: left;
        color: #ffffff; /* Set text color to white */
    }
            th {
                background-color: #333;
                color: #ffffff;
            }
            tr:nth-child(even) {
                background-color: #2c2c2c;
            }
            .btn-primary {
                background-color: #6a11cb;
                border-color: #6a11cb;
            }
            .btn-primary:hover {
                background-color: #4d089a;
                border-color: #4d089a;
            }
        </style>

        </head>
        <body>
            <div class="container">
                <h2 class="text-center">Crime Information for Complaint ID: <?php echo $complaint_id; ?></h2>
                <div class="table-responsive">
                    <table class="table table-bordered">
                        <thead class="thead-dark">
                            <tr>
                                <th>Username</th>
                                <th>Description</th>
                                <th>Date</th>
                                <th>Type</th>
                                <th>Severity</th>
                                <th>Status</th>
                                <th>Priority</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                            while($row = $crime_result->fetch_assoc()) {
                                echo "<tr>";
                                echo "<td>{$row['username']}</td>";
                                echo "<td>{$row['description']}</td>";
                                echo "<td>{$row['date']}</td>";
                                echo "<td>{$row['type']}</td>";
                                echo "<td>{$row['severity']}</td>";
                                echo "<td>{$row['status']}</td>";
                                echo "<td>{$row['priority']}</td>";
                                echo "</tr>";
                            }
                            ?>
                        </tbody>
                    </table>
                </div>
                <a href="dashboard.php" class="btn btn-primary">Back to Dashboard</a>
            </div>
            <!-- Bootstrap JS -->
            <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
            <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.16.0/umd/popper.min.js"></script>
            <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
        </body>
        </html>
        <?php
    } else {
        // No data found for the given complaint ID
        echo "No crime information found for Complaint ID: $complaint_id";
    }

    // Close the statement
    $stmt->close();
} else {
    // If complaint ID is not provided, display an error message
    echo "Complaint ID is not provided.";
}
?>
