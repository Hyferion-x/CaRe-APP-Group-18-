<?php
session_start();

// Check if the user is logged in
if (!isset($_SESSION['user_id'])) {
    die("Not logged in");
}

// Connect to the database
$conn = new mysqli('localhost', 'root', '', 'care_db');

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

$user_id = $_SESSION['user_id'];

// Fetch journal entries for the logged-in user
$sql = "SELECT * FROM journal_entries WHERE user_id = '$user_id' ORDER BY date DESC";
$result = $conn->query($sql);

$entries = [];

if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        $entries[] = $row;
    }
}

// Return entries as JSON
echo json_encode($entries);

$conn->close();
?>
