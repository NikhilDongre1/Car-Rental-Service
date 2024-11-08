<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Category</title>
    <link rel="stylesheet" href="style.css">
      
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

    <h1>Available Vehicles</h1>
    <div id="vehicle-list"></div>

    <div class="vehicles">
        <?php
        // Include database connection
        include 'database.php';

        // Fetch all vehicles
        $sql = "SELECT id, make, model, year, price, image FROM vehicles WHERE availability = 1";

        $result = $conn->query($sql);

        if ($result->num_rows > 0) {
            // Output data of each row
            while($row = $result->fetch_assoc()) {
                echo '<div class="vehicle">';
                echo '<img src="images/' . $row["image"] . '" alt="' . $row["make"] . ' ' . $row["model"] . '">';
                echo '<h3>' . $row["make"] . ' ' . $row["model"] . ' (' . $row["year"] . ')</h3>';
                echo '<p>Price: $' . $row["price"] . '/day</p>';
                echo '<a href="booking.php?id=' . $row["id"] . '" class="book-button">Book Now</a>';
                echo '</div>';
            }
        } else {
            echo "<p>No vehicles available at the moment.</p>";
        }
        ?>
    </div>
</body>
</html>
