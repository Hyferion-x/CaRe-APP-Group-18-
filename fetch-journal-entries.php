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

// Get search parameters
$keyword = isset($_GET['keyword']) ? $conn->real_escape_string($_GET['keyword']) : '';
$from = isset($_GET['from']) ? $conn->real_escape_string($_GET['from']) : '';
$to = isset($_GET['to']) ? $conn->real_escape_string($_GET['to']) : '';

$query = "SELECT * FROM journal_entries WHERE user_id = '$user_id'";

if ($keyword) {
    $query .= " AND entry LIKE '%$keyword%'";
}

if ($from && $to) {
    $query .= " AND date BETWEEN '$from' AND '$to'";
}

$result = $conn->query($query);

$entries = [];

if ($result) {
    while ($row = $result->fetch_assoc()) {
        $entries[] = $row;
    }
}

echo json_encode($entries);

$conn->close();
?>
