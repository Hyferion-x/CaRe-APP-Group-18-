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

$therapist_id = $_SESSION['user_id'];

// Fetch the sessions
$query = "SELECT id, session_date, session_time FROM sessions WHERE therapist_id = ?";
$stmt = $conn->prepare($query);
$stmt->bind_param("i", $therapist_id);
$stmt->execute();
$result = $stmt->get_result();

$sessions = [];
while ($row = $result->fetch_assoc()) {
    $sessions[] = [
        'id' => $row['id'],
        'date' => $row['session_date'],
        'time' => $row['session_time'],
    ];
}

if (!empty($sessions)) {
    echo json_encode(['status' => 'success', 'sessions' => $sessions]);
} else {
    echo json_encode(['status' => 'error', 'message' => 'No sessions found']);
}

$stmt->close();
$conn->close();
?>
