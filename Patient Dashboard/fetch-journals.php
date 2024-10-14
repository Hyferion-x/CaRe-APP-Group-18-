<?php
session_start();
//weli0007
// Check if user logged
if (!isset($_SESSION['user_id'])) {
    die("Not logged in");
}


$conn = new mysqli('localhost', 'root', '', 'care_db');


if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

$user_id = $_SESSION['user_id'];

// Fetch journal entries
$sql = "SELECT * FROM journal_entries WHERE user_id = '$user_id' ORDER BY date DESC";
$result = $conn->query($sql);

$entries = [];

if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        $entries[] = $row;
    }
}

echo json_encode($entries);

$conn->close();
?>
