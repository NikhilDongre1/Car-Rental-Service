<?php
session_start();
require 'database.php';

// Fetch all vehicles
$query = "SELECT * FROM vehicles";
$vehicles_result = $conn->query($query);

// Fetch all bookings with user and vehicle details
$bookings_query = "
    SELECT 
        users.email AS user_email, 
        vehicles.make, 
        vehicles.model, 
        bookings.start_date, 
        bookings.end_date, 
        bookings.location, 
        DATEDIFF(bookings.end_date, bookings.start_date) AS days_booked,
        vehicles.price, 
        DATEDIFF(bookings.end_date, bookings.start_date) * vehicles.price AS total_price
    FROM bookings
    INNER JOIN users ON bookings.user_id = users.id
    INNER JOIN vehicles ON bookings.vehicle_id = vehicles.id";
$bookings_result = $conn->query($bookings_query);

// Handle Update or Add Vehicle Actions
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Handle Add Vehicle
    if (isset($_POST['add_vehicle'])) {
        $make = $_POST['make'];
        $model = $_POST['model'];
        $price = $_POST['price'];
        $availability = $_POST['availability'];
        $type = $_POST['type'];
        $image = $_POST['image'];

        $insert_query = "INSERT INTO vehicles (make, model, price, availability, type, image) 
                         VALUES ('$make', '$model', '$price', '$availability', '$type', '$image')";
        $conn->query($insert_query);
    }

    // Handle Update Vehicle
    if (isset($_POST['update_vehicle'])) {
        $vehicle_id = $_POST['vehicle_id'];
        $price = $_POST['price'];
        $availability = $_POST['availability'];
        $make = $_POST['make'];
        $model = $_POST['model'];

        $update_query = "UPDATE vehicles 
                         SET price = '$price', availability = '$availability', make = '$make', model = '$model' 
                         WHERE id = '$vehicle_id'";
        $conn->query($update_query);
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Dashboard</title>
    <link rel="stylesheet" href="style.css">
</head>
<style>
    /* General Styles */
body {
    font-family: Arial, sans-serif;
    background-color: #333333;
    color: #bb86fc;
    margin: 0;
    padding: 0;
}

h1, h2 {
    color: #bb86fc;
    text-align: center;
}

/* Table Styles */
table {
    width: 80%;
    margin: 20px auto;
    border-collapse: collapse;
}

th, td {
    padding: 12px;
    text-align: center;
    border: 1px solid #444444;
}

th {
    background-color: #444444;
}

td {
    background-color: #555555;
}

tr:hover {
    background-color: #444444;
}

/* Button Styles */
button {
    background-color: #bb86fc;
    color: #333333;
    border: none;
    padding: 10px 20px;
    font-size: 16px;
    cursor: pointer;
    border-radius: 5px;
    transition: background-color 0.3s ease;
}

button:hover {
    background-color: #a56bc0;
}

/* Form Styles */
form {
    margin: 20px auto;
    width: 80%;
    padding: 20px;
    background-color: #444444;
    border-radius: 10px;
}

form input[type="text"],
form input[type="number"],
form select {
    width: 100%;
    padding: 10px;
    margin: 10px 0;
    border: 1px solid #555555;
    border-radius: 5px;
    background-color: #333333;
    color: #bb86fc;
}

form input[type="submit"],
form button[type="submit"] {
    background-color: #bb86fc;
    color: #333333;
    border: none;
    padding: 10px 20px;
    font-size: 16px;
    cursor: pointer;
    border-radius: 5px;
    margin-top: 10px;
    width: 100%;
}

form input[type="submit"]:hover,
form button[type="submit"]:hover {
    background-color: #a56bc0;
}

/* Edit Vehicle Form */
#edit_vehicle_form {
    display: none;
    margin: 20px auto;
    width: 80%;
    padding: 20px;
    background-color: #444444;
    border-radius: 10px;
}

#edit_vehicle_form input[type="text"],
#edit_vehicle_form input[type="number"] {
    width: 100%;
    padding: 10px;
    margin: 10px 0;
    border: 1px solid #555555;
    border-radius: 5px;
    background-color: #333333;
    color: #bb86fc;
}

/* Hover Effects */
#edit_vehicle_form button:hover {
    background-color: #a56bc0;
}

table button {
    background-color: #bb86fc;
    color: #333333;
    padding: 6px 12px;
    border: none;
    border-radius: 5px;
    cursor: pointer;
}

table button:hover {
    background-color: #a56bc0;
}

/* Center the content */
.center-content {
    display: flex;
    justify-content: center;
    align-items: center;
}

/* Responsive Design */
@media (max-width: 768px) {
    table {
        width: 95%;
    }

    form {
        width: 90%;
    }

    #edit_vehicle_form {
        width: 90%;
    }
}

</style>
<body>
<nav>
        <a href="index.php">Home</a>
        <a href="category.php">Book Now</a>
        <a href="orders.php">Bookings</a>
        <a href="logout.php">Logout</a>
    </nav>

    <h1>Admin Dashboard</h1>
    
    <h2>Vehicle Management</h2>
    <table border="1">
        <tr>
            <th>Car Name</th>
            <th>Price per Day</th>
            <th>Available Quantity</th>
            <th>Actions</th>
        </tr>
        <?php
        if ($vehicles_result->num_rows > 0) {
            while ($car = $vehicles_result->fetch_assoc()) {
                echo "<tr>";
                echo "<td>" . htmlspecialchars($car['make'] . ' ' . $car['model']) . "</td>";
                echo "<td>Rs " . htmlspecialchars($car['price']) . "</td>";
                echo "<td>" . htmlspecialchars($car['availability']) . "</td>";
                echo "<td><button onclick=\"showEditForm(" . $car['id'] . ", '" . $car['make'] . "', '" . $car['model'] . "', " . $car['price'] . ", " . $car['availability'] . ")\">Edit</button></td>";
                echo "</tr>";
            }
        } else {
            echo "<tr><td colspan='4'>No vehicles found.</td></tr>";
        }
        ?>
    </table>

    <h2>Add New Vehicle</h2>
    <form method="POST" action="">
        <label for="make">Make:</label>
        <input type="text" name="make" id="make" required><br>
        <label for="model">Model:</label>
        <input type="text" name="model" id="model" required><br>
        <label for="price">Price per Day:</label>
        <input type="number" name="price" id="price" required><br>
        <label for="availability">Availability:</label>
        <input type="number" name="availability" id="availability" required><br>
        <label for="type">Vehicle Type:</label>
        <select name="type" id="type">
            <option value="car">Car</option>
            <option value="bike">Bike</option>
        </select><br>
        <label for="image">Image URL:</label>
        <input type="text" name="image" id="image"><br>
        <button type="submit" name="add_vehicle">Add Vehicle</button>
    </form>

    <!-- Edit Vehicle Form (hidden initially) -->
    <div id="edit_vehicle_form" style="display:none;">
        <h2>Edit Vehicle Details</h2>
        <form method="POST" action="">
            <input type="hidden" name="vehicle_id" id="edit_vehicle_id">
            <label for="edit_make">Make:</label>
            <input type="text" name="make" id="edit_make" required><br>
            <label for="edit_model">Model:</label>
            <input type="text" name="model" id="edit_model" required><br>
            <label for="edit_price">Price per Day:</label>
            <input type="number" name="price" id="edit_price" required><br>
            <label for="edit_availability">Availability:</label>
            <input type="number" name="availability" id="edit_availability" required><br>
            <button type="submit" name="update_vehicle">Update Vehicle</button>
        </form>
    </div>

    <h2>Booking Status</h2>
    <table border="1">
        <tr>
            <th>User Email</th>
            <th>Vehicle Name</th>
            <th>Booked From</th>
            <th>Booked To</th>
            <th>Days</th>
            <th>Location</th>
            <th>Total Price</th>
        </tr>
        <?php while ($row = $bookings_result->fetch_assoc()): ?>
            <tr>
                <td><?php echo htmlspecialchars($row['user_email']); ?></td>
                <td><?php echo htmlspecialchars($row['make'] . ' ' . $row['model']); ?></td>
                <td><?php echo htmlspecialchars($row['start_date']); ?></td>
                <td><?php echo htmlspecialchars($row['end_date']); ?></td>
                <td><?php echo htmlspecialchars($row['days_booked']); ?></td>   
                <td><?php echo htmlspecialchars($row['location']); ?></td>
                <td>Rs <?php echo htmlspecialchars($row['total_price']); ?></td>
            </tr>
        <?php endwhile; ?>
    </table>

    <script>
        // Show the edit vehicle form and populate the fields with existing data
        function showEditForm(id, make, model, price, availability) {
            document.getElementById('edit_vehicle_form').style.display = 'block';
            document.getElementById('edit_vehicle_id').value = id;
            document.getElementById('edit_make').value = make;
            document.getElementById('edit_model').value = model;
            document.getElementById('edit_price').value = price;
            document.getElementById('edit_availability').value = availability;
        }
    </script>
</body>
</html>
