<?php
$host = "127.0.0.1"; // Change this to your database host if it's not localhost
$username = "root"; // Replace with your database username
$password = ""; // Replace with your database password
$database = "dbauxilium"; // Replace with your database name

// Create a database connection
$conn = new mysqli($host, $username, $password, $database);

// Check for connection errors
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}
?>