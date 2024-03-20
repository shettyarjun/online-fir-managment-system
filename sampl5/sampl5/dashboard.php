<?php
session_start();
require_once('db.php'); 

// Redirect to index.php if user is not logged in
if(!isset($_SESSION['user_id'])) {
    header('Location: index.php');
    exit();
}

// Fetch the username of the logged-in user
$user_id = $_SESSION['user_id'];
$query = "SELECT username FROM Users WHERE id = ?";
$stmt = $conn->prepare($query);
$stmt->bind_param("i", $user_id);
$stmt->execute();
$result = $stmt->get_result();
$row = $result->fetch_assoc();
$username = $row['username'];
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>User Dashboard</title>
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
            margin-top: 20px;
        }
        .card {
            background-color: rgba(0, 0, 0, 0.5);
            border: none;
            border-radius: 10px;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
            margin-bottom: 20px;
        }
        .card-header {
            background-color: #6a11cb;
            color: #ffffff;
            border-bottom: none;
            border-top-left-radius: 10px;
            border-top-right-radius: 10px;
            padding: 15px;
        }
        .card-body {
            padding: 20px;
        }
        .card-title {
            color: #ffffff;
            font-size: 24px;
            margin-bottom: 20px;
        }
        .btn-primary {
            background-color: #6a11cb;
            border-color: #6a11cb;
            transition: background-color 0.3s ease;
        }
        .btn-primary:hover {
            background-color: #4d089a;
            border-color: #4d089a;
        }
        table {
            color: #ffffff;
        }
        th, td {
            border: 1px solid #ffffff;
            padding: 10px;
            color: #ffffff; /* Added to make text white */
        }
    </style>
</head>
<body>
    <div class="container">
        <div class="row">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header">
                        <h2 class="text-center">Welcome, <?php echo $username; ?>!</h2>
                    </div>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-md-6">
                <div class="card">
                    <div class="card-body">
                        <h3 class="card-title">File a Complaint</h3>
                        <form action="submit_complaint.php" method="POST">
                            <div class="form-group">
                                <label>Description:</label>
                                <textarea class="form-control" name="description" required></textarea>
                            </div>
                            <div class="form-group">
                                <label>Date:</label>
                                <input type="date" class="form-control" name="date" required>
                            </div>
                            <div class="form-group">
                                <label>Type of Incident:</label>
                                <input type="text" class="form-control" name="type" required>
                            </div>
                            <div class="form-group">
                                <label>Severity:</label>
                                <select class="form-control" name="severity" required>
                                    <option value="high">High</option>
                                    <option value="medium">Medium</option>
                                    <option value="low">Low</option>
                                </select>
                            </div>
                            <button type="submit" class="btn btn-primary">Submit Complaint</button>
                        </form>
                    </div>
                </div>
            </div>
            <div class="col-md-6">
                <div class="card">
                    <div class="card-body">
                        <h3 class="card-title">My Complaints</h3>
                        <table class="table">
                            <thead>
                                <tr>
                                    <th>Description</th>
                                    <th>Date</th>
                                    <th>Type</th>
                                    <th>Status</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php
                                $query = "SELECT * FROM UserComplaints WHERE user_id = ?";
                                $stmt = $conn->prepare($query);
                                $stmt->bind_param("i", $user_id);
                                $stmt->execute();
                                $result = $stmt->get_result();

                                while($row = $result->fetch_assoc()) {
                                    echo "<tr>";
                                    echo "<td>{$row['description']}</td>";
                                    echo "<td>{$row['date']}</td>";
                                    echo "<td>{$row['type']}</td>";
                                    echo "<td>{$row['status']}</td>";
                                    echo "</tr>";
                                }
                                ?>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
        <div class="card">
            <div class="card-body">
                <h3 class="card-title">All Complaints</h3>
                <table class="table">
                    <thead>
                        <tr>
                            <th>Description</th>
                            <th>Date</th>
                            <th>Status</th>
                            <th>View Crime Info</th>
                        </tr>
                    </thead>
                    <tbody>
                    <?php
                        $query = "SELECT complaints.*, criminals.name AS criminal_name 
                                  FROM complaints 
                                  LEFT JOIN criminals ON complaints.id = criminals.complaint_id";
                        $result = mysqli_query($conn, $query);
                        
                        while($row = mysqli_fetch_assoc($result)) {
                            echo "<tr>";
                            echo "<td>{$row['description']}</td>";
                            echo "<td>{$row['date']}</td>";
                            echo "<td>{$row['status']}</td>";
                            echo "<td>";
                            if ($row['criminal_name']) {
                                echo "<a href='view_crime_info.php?complaint_id={$row['id']}' class='btn btn-info'>View Crime Info</a>";
                            } else {
                                echo "No Criminal Information";
                            }
                            echo "</td>";
                            echo "</tr>";
                        }
                    ?>
                    </tbody>
                </table>
            </div>
        </div>
        <!-- Logout Button -->
        <form action="logout.php" method="POST">
            <button type="submit" class="btn btn-danger">Logout</button>
        </form>
    </div>
    <!-- Bootstrap JS -->
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.16.0/umd/popper.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</body>
</html>
