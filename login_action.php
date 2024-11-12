<?php
session_start();
include 'database.php';

$admin_email = "admin@gmail.com";
$admin_password = "admin";

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $email = $_POST['email'];
    $password = $_POST['password'];

    

   
    $stmt = $conn->prepare("SELECT id, password FROM users WHERE email = ?");
    $stmt->bind_param("s", $email);
    $stmt->execute();
    $stmt->store_result();

    // Check if the user exists
    if ($email === $admin_email && $password === $admin_password) {
        header("Location: admin_dashboard.php"); 
        exit();
       
    }
    else if ($stmt->num_rows > 0) {
        $stmt->bind_result($user_id, $hashed_password);
        $stmt->fetch();

        // Verify the password
       if (password_verify($password, $hashed_password)) {
            $_SESSION['user_id'] = $user_id; // Store user ID in session
            header("Location: index.php"); // Redirect to home page upon successful login
            exit();
        } else {
            echo "Invalid password. Please try again.";
        }
    } else {
        echo "No user found with that email address.";
    }

    $stmt->close();
}

$conn->close();
?>
