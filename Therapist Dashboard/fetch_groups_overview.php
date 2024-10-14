<?php
//weli0007
session_start();
include 'db_connect.php'; 

header('Content-Type: application/json');


ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

// Check if the therapist is logged in 
if (!isset($_SESSION['user_id'])) {
    echo json_encode(['status' => 'error', 'message' => 'Unauthorized']);
    exit();
}

$therapist_id = $_SESSION['user_id'];

// Fetch the groups for the overview in groups.html
$sql = "SELECT g.id, g.group_name 
        FROM groups g
        WHERE g.therapist_id = ?";
$stmt = $conn->prepare($sql);
if (!$stmt) {
    echo json_encode(['status' => 'error', 'message' => 'Database query preparation failed']);
    exit();
}

$stmt->bind_param("i", $therapist_id);
$stmt->execute();
$result = $stmt->get_result();

$groups = [];
while ($row = $result->fetch_assoc()) {
    $groups[] = [
        'id' => $row['id'],
        'group_name' => $row['group_name']
    ];
}


echo json_encode(['status' => 'success', 'groups' => $groups]);


$stmt->close();
$conn->close();
