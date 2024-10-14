<?php
session_start();
//weli0007
include 'db_connect.php'; 

header('Content-Type: application/json');


ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

// Log incoming 
file_put_contents('session_debug.log', print_r($_POST, true), FILE_APPEND);

if (!isset($_SESSION['user_id']) || $_SESSION['role'] != 'therapist') {
    echo json_encode(['status' => 'error', 'message' => 'Unauthorized']);
    exit();
}

$therapist_id = $_SESSION['user_id'];

// Check if the necessary parameters are provided
if (!isset($_POST['group_id']) || !isset($_POST['date']) || !isset($_POST['time']) || !isset($_POST['status'])) {
    echo json_encode(['status' => 'error', 'message' => 'Group ID, Date, Time, and Status are required']);
    exit();
}

$group_id = intval($_POST['group_id']);
$session_date = $_POST['date'];
$session_time = $_POST['time'];
$notes = isset($_POST['notes']) ? $_POST['notes'] : '';
$status = $_POST['status'];

// Insert new session
$insertSessionQuery = "INSERT INTO sessions (group_id, therapist_id, session_date, session_time, notes, status) VALUES (?, ?, ?, ?, ?, ?)";
$stmt = $conn->prepare($insertSessionQuery);
$stmt->bind_param('iissss', $group_id, $therapist_id, $session_date, $session_time, $notes, $status);

if ($stmt->execute()) {
    echo json_encode(['status' => 'success', 'message' => 'Session created successfully']);
} else {
    echo json_encode(['status' => 'error', 'message' => 'Failed to create session']);
}

$stmt->close();
$conn->close();
?>
