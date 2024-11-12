<?php
$servername = "localhost";
$username = "root"; // Use your MySQL username
$password = ""; // Use your MySQL password (default is empty for XAMPP)
$dbname = "rental_db1"; // Use your database name

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

error_reporting(E_ALL);
ini_set('display_errors', 1);
?>
