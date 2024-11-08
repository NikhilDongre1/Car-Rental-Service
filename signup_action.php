<?php
session_start();
include 'database.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $name = $_POST['name'];
    $email = $_POST['email'];
    $password = password_hash($_POST['password'], PASSWORD_DEFAULT);

    // Prepare and bind
    $stmt = $conn->prepare("INSERT INTO users (name, email, password) VALUES (?, ?, ?)");
    $stmt->bind_param("sss", $name, $email, $password);

    // Execute the statement
    if ($stmt->execute()) {
        $_SESSION['user_id'] = $stmt->insert_id; // Store user ID in session
        header("Location: index.php"); // Redirect to home page after successful signup
        exit();
    } else {
        echo "Error: " . $stmt->error; // Handle error
    }

    $stmt->close();
}

$conn->close();
?>

