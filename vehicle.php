<?php
include 'database.php';

$type = $_GET['type'];
$query = "SELECT * FROM vehicles";

if ($type == 'car') {
    $query .= " WHERE type = 'car'";
} elseif ($type == 'bike') {
    $query .= " WHERE type = 'bike'";
}

$result = $conn->query($query);
$vehicles = [];

while ($row = $result->fetch_assoc()) {
    $vehicles[] = $row;
}

header('Content-Type: application/json');
echo json_encode($vehicles);
?>
