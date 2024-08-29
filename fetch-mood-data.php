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

// SQL query to fetch the count of each mood
$query = "SELECT mood, COUNT(*) as count FROM journal_entries WHERE user_id = '$user_id' GROUP BY mood";

$result = $conn->query($query);

$moods = [];

if ($result) {
    while ($row = $result->fetch_assoc()) {
        $moods[] = $row;
    }
}

echo json_encode($moods);

$conn->close();
?>
