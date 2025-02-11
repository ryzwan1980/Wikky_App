<?php
session_start();
include '../db.php';

// Check if admin is logged in
if (!isset($_SESSION['user_id']) || $_SESSION['role'] !== 'admin') {
    header("Location: login.php");
    exit();
}

// Initialize variables for date range filter
$from_date = $to_date = "";

// Handle the date range filter form submission
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $from_date = $_POST['from_date'];
    $to_date = $_POST['to_date'];

    // Query to fetch food entries for all users within the date range
    $sql = "SELECT u.full_name, u.username, fe.food_item, fe.quantity, fe.date
            FROM users u
            LEFT JOIN user_food_entries fe ON u.id = fe.user_id
            WHERE fe.date BETWEEN ? AND ?
            ORDER BY fe.date DESC";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("ss", $from_date, $to_date);
    $stmt->execute();
    $result = $stmt->get_result();
} else {
    // Default query to fetch all food entries for all users
    $sql = "SELECT u.full_name, u.username, fe.food_item, fe.quantity, fe.date
            FROM users u
            LEFT JOIN user_food_entries fe ON u.id = fe.user_id
            ORDER BY fe.date DESC";
    $result = $conn->query($sql);
}

// Export to CSV
if (isset($_POST['download_csv'])) {
    // Headers for CSV download
    header('Content-Type: text/csv');
    header('Content-Disposition: attachment; filename="food_entries_report.csv"');
    
    // Open output stream
    $output = fopen('php://output', 'w');
    fputcsv($output, ['Full Name', 'Username', 'Food Item', 'Quantity', 'Date']);
    
    // Write data to CSV
    if ($result) {
        while ($row = $result->fetch_assoc()) {
            fputcsv($output, $row);
        }
    }
    fclose($output);
    exit;
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>User Food Entries Report</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
    <div class="container mt-5">
        <h2 class="text-center">Food Entries Report</h2>
        
        <!-- Date range filter form -->
        <form method="POST" class="mb-4">
            <div class="row">
                <div class="col-md-4">
                    <label for="from_date" class="form-label">From Date</label>
                    <input type="date" name="from_date" id="from_date" class="form-control" value="<?php echo $from_date; ?>">
                </div>
                <div class="col-md-4">
                    <label for="to_date" class="form-label">To Date</label>
                    <input type="date" name="to_date" id="to_date" class="form-control" value="<?php echo $to_date; ?>">
                </div>
                <div class="col-md-4 d-flex align-items-end">
                    <button type="submit" class="btn btn-primary">Generate Report</button>
                </div>
            </div>
        </form>

        <!-- Table displaying food entries -->
        <table class="table">
            <thead>
                <tr>
                    <th>Full Name</th>
                    <th>Username</th>
                    <th>Food Item</th>
                    <th>Quantity</th>
                    <th>Date</th>
                </tr>
            </thead>
            <tbody>
                <?php
                if ($result && $result->num_rows > 0) {
                    while ($row = $result->fetch_assoc()) { ?>
                        <tr>
                            <td><?php echo $row['full_name']; ?></td>
                            <td><?php echo $row['username']; ?></td>
                            <td><?php echo $row['food_item']; ?></td>
                            <td><?php echo $row['quantity']; ?></td>
                            <td><?php echo $row['date']; ?></td>
                        </tr>
                <?php }
                } else { ?>
                    <tr><td colspan="5" class="text-center">No data found</td></tr>
                <?php } ?>
            </tbody>
        </table>

        <!-- Button to download CSV -->
        <form method="POST">
            <button type="submit" name="download_csv" class="btn btn-success">Download CSV</button>
        </form>
    </div>
</body>
</html>

