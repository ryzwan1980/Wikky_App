<?php
include '../db.php';
session_start();

$error_message = "";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $username = trim($_POST['username']);
    $password = trim($_POST['password']);

    // Hash the input password using SHA-256
    $hashedPassword = hash('sha256', $password);

    // Use prepared statements to prevent SQL Injection
    $stmt = $conn->prepare("SELECT * FROM users WHERE username = ? AND role = 'admin'");
    $stmt->bind_param("s", $username);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows == 1) {
        $user = $result->fetch_assoc();

        // Compare hashed password with stored hash
        if ($hashedPassword === $user['password']) {
            $_SESSION['role'] = $user['role'];
            $_SESSION['user_id'] = $user['id'];
            header("Location: admin_dashboard.php");
            exit();
        } else {
            $error_message = "Invalid credentials. Please try again.";
        }
    } else {
        $error_message = "Admin user not found.";
    }

    $stmt->close();
    $conn->close();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Login</title>
    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <!-- Custom styles -->
    <style>
        body {
            background-color: #f8f9fa;
            height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
        }
        .login-card {
            width: 350px;
            padding: 20px;
            border-radius: 10px;
            background: #ffffff;
            box-shadow: 0 4px 8px rgba(0,0,0,0.1);
        }
        .login-card-header {
            background-color: #007bff;
            color: #fff;
            text-align: center;
            padding: 10px;
            border-radius: 8px 8px 0 0;
        }
        .btn-login {
            background-color: #007bff;
            border: none;
            font-weight: bold;
        }
        .btn-login:hover {
            background-color: #0056b3;
        }
        .alert {
            font-size: 14px;
        }
    </style>
</head>
<body>
    <div class="login-card">
        <div class="login-card-header">
            <h3>Admin Login</h3>
        </div>
        <div class="card-body">
            <form method="post">
                <div class="form-group">
                    <input type="text" class="form-control" name="username" placeholder="Admin Username" required>
                </div>
                <div class="form-group">
                    <input type="password" class="form-control" name="password" placeholder="Password" required>
                </div>
                <button type="submit" class="btn btn-block btn-login">Login</button>
            </form>
            <?php if (!empty($error_message)): ?>
                <div class="alert alert-danger mt-3" role="alert">
                    <?php echo $error_message; ?>
                </div>
            <?php endif; ?>
        </div>
    </div>
    <!-- Bootstrap JS and dependencies -->
    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.5.2/dist/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</body>
</html>

