<?php

include 'database.php';

// SQL query to get the most booked vehicle
$sql = "SELECT vehicles.make, vehicles.model, vehicles.year, vehicles.image, COUNT(bookings.vehicle_id) AS booking_count 
        FROM vehicles 
        JOIN bookings ON vehicles.id = bookings.vehicle_id 
        GROUP BY bookings.vehicle_id 
        ORDER BY booking_count DESC 
        LIMIT 1";

$result = $conn->query($sql);


if (!$result) {
    echo "SQL Error: " . $conn->error;
    exit;
}

$popular_vehicle = null;

if ($result->num_rows > 0) {
    $popular_vehicle = $result->fetch_assoc();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Car and Bike Rental</title>
    <link rel="stylesheet" href="index.css">
</head>
<body>
    <nav>
        <a href="index.php">Home</a>
        <a href="category.php">Book Now</a>
        <?php session_start(); if (isset($_SESSION['user_id'])): ?>
            <a href="orders.php">Bookings</a>
            <a href="logout.php">Logout</a>
        <?php else: ?>
            <a href="login.php">Login</a>
            <a href="signup.php">Sign Up</a>
        <?php endif; ?>
    </nav>

    <!-- Hero Section -->
    <section class="hero-section">
        <div class="hero-content">
            <h1>Welcome to Car and Bike Rental</h1>
            <p>Your adventure starts here. Choose from a wide selection of cars and bikes, and experience a smooth and convenient rental process!</p>
            <a href="category.php" class="hero-button">Book Your Ride Now</a>
        </div>
        <div class="hero-image">
            <img src="images/image.png" alt="Car Image">
        </div>
    </section>

    <!-- Most Preferred Vehicle Section -->
    <?php if ($popular_vehicle): ?>
        <section class="popular-vehicle-section">
            <h2>Most Preferred Vehicle</h2>
            <div class="vehicle">
                <img src="images/<?php echo $popular_vehicle['image']; ?>" alt="<?php echo $popular_vehicle['make'] . ' ' . $popular_vehicle['model']; ?>">
                <h3><?php echo $popular_vehicle['make'] . ' ' . $popular_vehicle['model'] . ' (' . $popular_vehicle['year'] . ')'; ?></h3>
                <p>This vehicle has been booked <?php echo $popular_vehicle['booking_count']; ?> times!</p>
            </div>
        </section>
    <?php endif; ?>

    <!-- Vehicle Types Section -->
    <section class="vehicle-types">
        <h2>Our Vehicle Selection</h2>
        <div class="vehicle-list">
            <div class="vehicle-type">
                <h3>Sedans</h3>
                <p>Comfortable and stylish sedans for a smooth ride.</p>
            </div>
            <div class="vehicle-type">
                <h3>SUVs</h3>
                <p>Spacious and powerful SUVs for all your adventures.</p>
            </div>
            <div class="vehicle-type">
                <h3>Luxury Cars</h3>
                <p>High-end luxury cars for a premium experience.</p>
            </div>
            <div class="vehicle-type">
                <h3>Motorbikes</h3>
                <p>Efficient and versatile motorbikes for short trips.</p>
            </div>
        </div>
    </section>
</body>
</html>
