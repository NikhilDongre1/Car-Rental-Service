<?php
session_start();
include 'database.php';

if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit();
}

$user_id = $_SESSION['user_id'];
$stmt = $conn->prepare("SELECT bookings.*, vehicles.make, vehicles.model, vehicles.price AS price_per_day 
                       FROM bookings 
                       INNER JOIN vehicles ON bookings.vehicle_id = vehicles.id 
                       WHERE bookings.user_id = ?");
$stmt->bind_param("i", $user_id);
$stmt->execute();
$result = $stmt->get_result();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Your Bookings</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
    <nav>
        <a href="index.php">Home</a>
        <a href="category.php">Book Now</a>
        <a href="logout.php">Logout</a>
    </nav>

    <h1>Your Bookings</h1>
    <table>
        <tr>
            <th>Vehicle</th>
            <th>Start Date</th>
            <th>End Date</th>
            <th>Location</th>
            <th>Price to Pay (Rs)</th>
        </tr>
        <?php while ($row = $result->fetch_assoc()): ?>
            <?php
                // Calculate the price to pay based on the rental days
                $start_date = new DateTime($row['start_date']);
                $end_date = new DateTime($row['end_date']);
                $interval = $start_date->diff($end_date);
                $days = $interval->days + 1; // Include both start and end date
                
                // Price per day is fetched from the vehicles table
                $price_per_day = $row['price_per_day'];
                
                // Calculate the total price to pay
                $price_to_pay = $price_per_day * $days;
            ?>
            <tr>
                <td><?php echo $row['make'] . ' ' . $row['model']; ?></td>
                <td><?php echo $row['start_date']; ?></td>
                <td><?php echo $row['end_date']; ?></td>
                <td><?php echo $row['location']; ?></td>
                <td><?php echo "₹" . number_format($price_to_pay, 2); ?></td>
            </tr>
        <?php endwhile; ?>
    </table>
</body>
</html>
