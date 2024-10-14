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

// Fetch groups associated with the therapist
$groupsQuery = "SELECT id, group_name FROM groups WHERE therapist_id = ?";
$stmt = $conn->prepare($groupsQuery);
$stmt->bind_param('i', $therapist_id);
$stmt->execute();
$result = $stmt->get_result();

$groups = [];
while ($group = $result->fetch_assoc()) {
    $groups[] = ['id' => $group['id'], 'group_name' => $group['group_name']];
}

if (!empty($groups)) {
    echo json_encode(['status' => 'success', 'groups' => $groups]);
} else {
    echo json_encode(['status' => 'error', 'message' => 'No groups found']);
}

$stmt->close();
$conn->close();
?>
