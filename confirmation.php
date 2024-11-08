<?php
session_start();
include 'database.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $user_id = $_SESSION['user_id'];
    $vehicle_id = $_POST['vehicle_id'];
    $start_date = $_POST['start_date'];
    $end_date = $_POST['end_date'];
    $location = $_POST['location'];

    // Insert booking into the database
    $stmt = $conn->prepare("INSERT INTO bookings (user_id, vehicle_id, start_date, end_date, location) VALUES (?, ?, ?, ?, ?)");
    $stmt->bind_param("iisss", $user_id, $vehicle_id, $start_date, $end_date, $location);
    $stmt->execute();

    echo "<h1>Booking Confirmed!</h1>";
    echo "<p>Vehicle ID: $vehicle_id</p>";
    echo "<p>Start Date: $start_date</p>";
    echo "<p>End Date: $end_date</p>";
    echo "<p>Location: $location</p>";
    echo "<a href='category.php'>Back to Categories</a>";
} else {
    echo "No booking information received.";
}
?>
