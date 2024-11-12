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

    echo "
    <div style='font-family: Arial, sans-serif; text-align: center; margin-top: 50px; padding: 20px; border: 1px solid #ddd; max-width: 600px; margin: auto; box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);'>
        <h1 style='color: #4CAF50;'>Booking Confirmed!</h1>
        <p style='font-size: 18px; color: #333;'>Your booking has been successfully confirmed. Here are the details:</p>
        <div style='border-top: 1px solid #ddd; padding-top: 20px; margin-top: 20px;'>
            <p><strong>Vehicle ID:</strong> $vehicle_id</p>
            <p><strong>Start Date:</strong> $start_date</p>
            <p><strong>End Date:</strong> $end_date</p>
            <p><strong>Location:</strong> $location</p>
        </div>
        <a href='category.php' style='display: inline-block; margin-top: 20px; padding: 10px 20px; background-color: #4CAF50; color: white; text-decoration: none; border-radius: 5px;'>Back to Categories</a>
    </div>
    ";
} else {
    echo "<div style='font-family: Arial, sans-serif; text-align: center; margin-top: 50px;'><p>No booking information received.</p></div>";
}
?>
