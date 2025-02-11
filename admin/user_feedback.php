<?php
session_start();
include '../db.php';  // Adjust path to db.php

// Check if admin is logged in
if (!isset($_SESSION['user_id']) || $_SESSION['role'] !== 'admin') {
    header("Location: login.php");
    exit();
}

// Fetch user feedback from the database
$sql = "SELECT * FROM user_feedback";
$result = $conn->query($sql);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>User Feedback</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
    <div class="container mt-5">
        <h2 class="text-center">User Feedback</h2>
        <table class="table">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>User ID</th>
                    <th>Feedback</th>
                    <th>Date</th>
                </tr>
            </thead>
            <tbody>
                <?php while($row = $result->fetch_assoc()) { ?>
                <tr>
                    <td><?php echo $row['id']; ?></td>
                    <td><?php echo $row['user_id']; ?></td>
                    <td><?php echo $row['feedback']; ?></td>
                    <td><?php echo $row['created_at']; ?></td>
                </tr>
                <?php } ?>
            </tbody>
        </table>
        
        <!-- Back Button -->
        <div class="text-center mt-3">
            <a href="admin_dashboard.php" class="btn btn-primary">Back</a>
        </div>
    </div>
</body>
</html>

