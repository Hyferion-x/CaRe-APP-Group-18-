<?php
session_start();
//weli0007
include 'db_connect.php'; 

header('Content-Type: application/json');


ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

// Check if the therapist is logged in
if (!isset($_SESSION['user_id']) || $_SESSION['role'] != 'therapist') {
    echo json_encode(['status' => 'error', 'message' => 'Unauthorized']);
    exit();
}

// Check if session_id and notes are provided
if (!isset($_POST['session_id']) || !isset($_POST['notes'])) {
    echo json_encode(['status' => 'error', 'message' => 'Session ID and Notes are required']);
    exit();
}

$session_id = intval($_POST['session_id']);
$notes = $_POST['notes'];

// Update the notes in the sessions table
$query = "UPDATE sessions SET notes = ? WHERE id = ?";
$stmt = $conn->prepare($query);
$stmt->bind_param('si', $notes, $session_id);

if ($stmt->execute()) {
    echo json_encode(['status' => 'success', 'message' => 'Notes updated successfully']);
} else {
    echo json_encode(['status' => 'error', 'message' => 'Failed to update notes']);
}

$stmt->close();
$conn->close();
?>
