<?php
session_start();
if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit();
}

$vehicle_id = $_GET['id'];
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Booking</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
    <nav>
        <a href="index.php">Home</a>
        <a href="category.php">Book Now</a>
        <a href="orders.php">Bookings</a>
        <a href="logout.php">Logout</a>
    </nav>

    <h1>Booking Details</h1>
    <form action="confirmation.php" method="POST">
        <input type="hidden" name="vehicle_id" value="<?php echo $vehicle_id; ?>">
        <input type="date" name="start_date" required>
        <input type="date" name="end_date" required>
        <input type="text" name="location" placeholder="Location" required>
        <button type="submit">Complete Your Booking</button>
    </form>
</body>
</html>