<?php
session_start();
require 'db_connection.php'; // Ensure this file contains the database connection

if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit();
}

// Fetch total user count
$userCountQuery = "SELECT COUNT(*) AS user_count FROM users";
$userCountResult = mysqli_query($conn, $userCountQuery);
$userCountRow = mysqli_fetch_assoc($userCountResult);
$totalUsers = $userCountRow['user_count'];

// Fetch latest user feedback (limit to 5)
$feedbackQuery = "SELECT user_name, feedback FROM feedback ORDER BY id DESC LIMIT 5";
$feedbackResult = mysqli_query($conn, $feedbackQuery);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Profile</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body {
            background-color: #e9ecef;
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
        }
        .container {
            max-width: 500px;
            margin-top: 50px;
            padding: 30px;
            background-color: #ffffff;
            border-radius: 15px;
            box-shadow: 0 0 20px rgba(0, 0, 0, 0.1);
        }
        h2 {
            color: #495057;
            font-weight: bold;
            text-align: center;
            margin-bottom: 20px;
        }
        .btn-group {
            display: flex;
            flex-direction: column;
            gap: 10px;
        }
        .btn {
            background-color: #6c757d;
            color: white;
            border-radius: 25px;
            padding: 12px;
            font-size: 16px;
            text-align: center;
            border: none;
            transition: all 0.3s ease;
        }
        .btn:hover {
            background-color: #5a6268;
            cursor: pointer;
        }
        .btn-primary {
            background-color: #28a745;
        }
        .btn-primary:hover {
            background-color: #218838;
        }
        .card {
            margin-top: 20px;
            padding: 15px;
            border-radius: 10px;
            background: #f8f9fa;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
        }
        .feedback-item {
            border-bottom: 1px solid #dee2e6;
            padding: 8px 0;
        }
        .feedback-item:last-child {
            border-bottom: none;
        }
    </style>
</head>
<body>
    <div class="container">
        <h2>Admin Dashboard</h2>
        
        <!-- Total Users -->
        <div class="card text-center">
            <h4>Total Users</h4>
            <p class="fs-3 text-success"><?php echo $totalUsers; ?></p>
        </div>

        <!-- User Feedback -->
        <div class="card">
            <h4>Recent Feedback</h4>
            <?php if (mysqli_num_rows($feedbackResult) > 0): ?>
                <?php while ($row = mysqli_fetch_assoc($feedbackResult)): ?>
                    <div class="feedback-item">
                        <strong><?php echo htmlspecialchars($row['user_name']); ?>:</strong>
                        <p><?php echo htmlspecialchars($row['feedback']); ?></p>
                    </div>
                <?php endwhile; ?>
            <?php else: ?>
                <p>No feedback available.</p>
            <?php endif; ?>
        </div>

        <div class="btn-group mt-3">
            <a href="manage_users.php" class="btn">Manage Users</a>
            <a href="food_entry.php" class="btn">View Food Entries</a>
            <a href="logout.php" class="btn">Logout</a>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>

