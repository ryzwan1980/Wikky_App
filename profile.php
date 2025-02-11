<?php
session_start();
if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>User Profile</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body {
            background-color: #e9ecef;
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
        }
        .container {
            max-width: 400px;
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
            margin-bottom: 30px;
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
    </style>
</head>
<body>
    <div class="container">
        <h2>Welcome to Your Profile</h2>
        <div class="btn-group">
            <a href="food_entry.php" class="btn">Enter Food Status</a>
            <a href="feedback.php" class="btn">Feedback</a>
            <a href="logout.php" class="btn">Logout</a>
        </div>
        <div class="mt-3">
            <a href="food_entry.php" class="btn btn-primary w-100">Go to Food Entry</a>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>

