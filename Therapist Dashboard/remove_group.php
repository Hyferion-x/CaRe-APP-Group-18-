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
    echo json_encode(['error' => 'Unauthorized']);
    exit();
}

$therapist_id = $_SESSION['user_id'];

// Check if the group_id is provided
if (!isset($_POST['group_id'])) {
    echo json_encode(['status' => 'error', 'message' => 'Group ID is required']);
    exit();
}

$group_id = intval($_POST['group_id']);

// Check if the group belongs to the therapist
$checkQuery = "SELECT id FROM groups WHERE id = ? AND therapist_id = ?";
$stmt = $conn->prepare($checkQuery);
$stmt->bind_param('ii', $group_id, $therapist_id);
$stmt->execute();
$stmt->store_result();

if ($stmt->num_rows === 0) {
    echo json_encode(['status' => 'error', 'message' => 'Group not found or unauthorized access']);
    exit();
}

// Delete the group
$deleteQuery = "DELETE FROM groups WHERE id = ?";
$stmt = $conn->prepare($deleteQuery);
$stmt->bind_param('i', $group_id);

if ($stmt->execute()) {
    echo json_encode(['status' => 'success', 'message' => 'Group removed successfully']);
} else {
    echo json_encode(['status' => 'error', 'message' => 'Failed to remove group']);
}

$stmt->close();
$conn->close();
?>
