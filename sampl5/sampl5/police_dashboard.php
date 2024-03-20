

<?php
session_start();
require_once('db.php');

if(!isset($_SESSION['police_id'])) {
    header('Location: index.php');
    exit();
}

// Fetch the name of the logged-in police officer
$police_id = $_SESSION['police_id'];
$query = "SELECT username FROM Police WHERE id = $police_id";
$result = mysqli_query($conn, $query);
$row = mysqli_fetch_assoc($result);
$police_name = $row['username'];
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <title>Police Dashboard</title>
    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <style>
        body {
            background-color: #000000; /* Black background */
            color: #ffffff; /* White text */
            font-family: Arial, sans-serif;
        }
        .container {
            margin-top: 50px;
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
        .table {
            color: #ffffff;
        }
        .table th, .table td {
            border-color: #333333;
        }
        .btn {
            color: #ffffff;
        }
        .btn-primary {
            background-color: #007bff;
            border-color: #007bff;
        }
        .btn-primary:hover {
            background-color: #0056b3;
            border-color: #0056b3;
        }
        .btn-danger {
            background-color: #dc3545;
            border-color: #dc3545;
        }
        .btn-danger:hover {
            background-color: #bd2130;
            border-color: #bd2130;
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
        <!-- Header Section -->
        <div class="card">
            <div class="card-body">
                <h2 class="card-title text-center">Welcome, <?php echo $police_name; ?>!</h2>
            </div>
        </div>
<!-- Complaints Section -->
            <div class="card">
                <div class="card-body">
                    <h3 class="card-title">Complaints</h3>
                    <table class="table">
                        <thead>
                            <tr>
                                <th>Id</th>
                                <th>User</th>
                                <th>Description</th>
                                <th>Date</th>
                                <th>Type</th>
                                <th>Status</th>
                                <th>Priority</th> <!-- New column for priority -->
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                            $query = "SELECT * FROM crimeinformation ORDER BY priority, FIELD(severity, 'high', 'medium', 'low')";
                            $result = mysqli_query($conn, $query);
                            
                            while($row = mysqli_fetch_assoc($result)) {
                                echo "<tr>";     
                                echo "<td>{$row['id']}</td>";
                                echo "<td>{$row['username']}</td>";
                                echo "<td>{$row['description']}</td>";
                                echo "<td>{$row['date']}</td>";
                                echo "<td>{$row['type']}</td>";
                                echo "<td>{$row['status']}</td>";
                                echo "<td>{$row['priority']}</td>";
                                echo "<td><a href='update_status.php?id={$row['id']}' class='btn btn-primary'>Update Status</a></td>";
                                echo "</tr>";
                            }
                            ?>
                        </tbody>
                    </table>
                </div>
            </div>
                        
        <!-- Links to add criminal, evidence, and witness information -->
        <div class="card">
            <div class="card-body">
                <h3 class="card-title">Add Information</h3>
                <ul>
                    <li><a href="crime_info.php">Add Crime Information</a></li>
                </ul>
            </div>
        </div>
        
        <!-- Logout Button -->
        <div class="card">
            <div class="card-body">
                <form action="logout.php" method="POST">
                    <button type="submit" class="btn btn-danger">Logout</button>
                </form>
            </div>
        </div>
    </div>
</body>
</html>
