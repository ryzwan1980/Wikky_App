<?php
include 'db.php';
session_start();
if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit();
}
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $message = $_POST['message'];
    $query = "INSERT INTO feedback (user_id, message) VALUES (?, ?)";
    $stmt = $conn->prepare($query);
    $stmt->bind_param("is", $_SESSION['user_id'], $message);
    $stmt->execute();
    $successMessage = "Feedback submitted!";
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Feedback</title>
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
            margin-bottom: 30px;
        }
        textarea {
            width: 100%;
            height: 150px;
            padding: 10px;
            border-radius: 10px;
            border: 1px solid #ddd;
            margin-bottom: 15px;
            resize: none;
        }
        button {
            background-color: #28a745;
            color: white;
            border-radius: 25px;
            padding: 12px;
            font-size: 16px;
            width: 100%;
            border: none;
            transition: all 0.3s ease;
        }
        button:hover {
            background-color: #218838;
            cursor: pointer;
        }
        .alert {
            text-align: center;
        }
    </style>
</head>
<body>
    <div class="container">
        <h2>Submit Your Feedback</h2>
        <?php if (isset($successMessage)): ?>
            <div class="alert alert-success"><?php echo $successMessage; ?></div>
        <?php endif; ?>
        <form method="post">
            <textarea name="message" placeholder="Enter your feedback" required></textarea>
            <button type="submit">Submit</button>
        </form>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>

