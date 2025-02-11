<?php
include 'db.php';
session_start();
if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit();
}
$successMessage = "";
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $morning = $_POST['morning'];
    $afternoon = $_POST['afternoon'];
    $night = $_POST['night'];
    $date = date('Y-m-d', strtotime('+1 day'));
    $query = "INSERT INTO food_entries (user_id, date, morning, afternoon, night) VALUES (?, ?, ?, ?, ?)";
    $stmt = $conn->prepare($query);
    $stmt->bind_param("issss", $_SESSION['user_id'], $date, $morning, $afternoon, $night);
    $stmt->execute();
    $successMessage = "Food status updated successfully!";
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Food Entry</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body {
            background-color: #f8f9fa;
        }
        .container {
            max-width: 500px;
            margin-top: 50px;
            background: #fff;
            padding: 20px;
            border-radius: 8px;
            box-shadow: 0px 0px 10px rgba(0, 0, 0, 0.1);
        }
    </style>
</head>
<body>
    <div class="container">
        <h2 class="text-center">Food Entry</h2>
        <?php if ($successMessage): ?>
            <div class='alert alert-success text-center'><?php echo $successMessage; ?></div>
            <a href="profile.php" class="btn btn-secondary w-100 mt-3">Back</a> <!-- Redirect to profile.php -->
        <?php endif; ?>
        <?php if (!$successMessage): ?>
            <form method="post">
                <div class="mb-3">
                    <label class="form-label">Morning:</label>
                    <select name="morning" class="form-select">
                        <option value="Yes">Yes</option>
                        <option value="No">No</option>
                    </select>
                </div>
                <div class="mb-3">
                    <label class="form-label">Afternoon:</label>
                    <select name="afternoon" class="form-select">
                        <option value="Yes">Yes</option>
                        <option value="No">No</option>
                    </select>
                </div>
                <div class="mb-3">
                    <label class="form-label">Night:</label>
                    <select name="night" class="form-select">
                        <option value="Yes">Yes</option>
                        <option value="No">No</option>
                    </select>
                </div>
                <button type="submit" class="btn btn-primary w-100">Submit</button>
            </form>
        <?php endif; ?>
    </div>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>

