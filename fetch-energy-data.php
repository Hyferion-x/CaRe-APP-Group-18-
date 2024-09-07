<?php
session_start();

// Connect to the database
$conn = new mysqli('localhost', 'root', '', 'care_db');

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Check if user_id is set in session
if (!isset($_SESSION['user_id'])) {
    echo json_encode([]);
    exit();
}

$user_id = $_SESSION['user_id'];

// SQL query to fetch energy levels and dates for the logged-in user
$query = "SELECT date, energy_level FROM journal_entries WHERE user_id = '$user_id' ORDER BY date ASC";

$result = $conn->query($query);

$energyData = [];

if ($result) {
    while ($row = $result->fetch_assoc()) {
        $energyData[] = $row;
    }
}

echo json_encode($energyData);

$conn->close();
?>
