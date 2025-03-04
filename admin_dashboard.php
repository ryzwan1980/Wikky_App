<?php
include 'db.php';
session_start();

// Check if admin is logged in
if (!isset($_SESSION['user_id']) || $_SESSION['role'] !== 'admin') {
    header("Location: login.php");
    exit();
}

// Fetch all feedback
$feedbackQuery = "SELECT users.username, feedback.message, feedback.created_at FROM feedback JOIN users ON feedback.user_id = users.id ORDER BY feedback.created_at DESC";
$feedbackResult = $conn->query($feedbackQuery);

// Fetch all food entries
$foodQuery = "SELECT users.username, food_entries.date, food_entries.morning, food_entries.afternoon, food_entries.night FROM food_entries JOIN users ON food_entries.user_id = users.id ORDER BY food_entries.date DESC";
$foodResult = $conn->query($foodQuery);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Dashboard</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
    <div class="container mt-5">
        <h2 class="text-center">Admin Dashboard</h2>
        
        <h4 class="mt-4">User Feedback</h4>
        <table class="table table-bordered">
            <thead>
                <tr>
                    <th>Username</th>
                    <th>Feedback</th>
                    <th>Date</th>
                </tr>
            </thead>
            <tbody>
                <?php while ($row = $feedbackResult->fetch_assoc()): ?>
                    <tr>
                        <td><?php echo htmlspecialchars($row['username']); ?></td>
                        <td><?php echo htmlspecialchars($row['message']); ?></td>
                        <td><?php echo $row['created_at']; ?></td>
                    </tr>
                <?php endwhile; ?>
            </tbody>
        </table>
        
        <h4 class="mt-4">User Food Entries</h4>
        <table class="table table-bordered">
            <thead>
                <tr>
                    <th>Username</th>
                    <th>Date</th>
                    <th>Morning</th>
                    <th>Afternoon</th>
                    <th>Night</th>
                </tr>
            </thead>
            <tbody>
                <?php while ($row = $foodResult->fetch_assoc()): ?>
                    <tr>
                        <td><?php echo htmlspecialchars($row['username']); ?></td>
                        <td><?php echo $row['date']; ?></td>
                        <td><?php echo $row['morning']; ?></td>
                        <td><?php echo $row['afternoon']; ?></td>
                        <td><?php echo $row['night']; ?></td>
                    </tr>
                <?php endwhile; ?>
            </tbody>
        </table>
        
        <a href="logout.php" class="btn btn-danger">Logout</a>
    </div>
</body>
</html>

