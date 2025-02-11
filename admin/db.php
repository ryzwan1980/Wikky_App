<?php
$servername = "localhost";
$username = "foodhub_usr";
$password = "FoodHub@123";
$database = "foodhub_db";

$conn = new mysqli($servername, $username, $password, $database);
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}
?>
