<?php
//weli0007
session_start();
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

// Get the group_id from the request
$group_id = isset($_GET['group_id']) ? intval($_GET['group_id']) : 0;

if ($group_id === 0) {
    echo json_encode(['error' => 'Group ID is required']);
    exit();
}

// Fetch group members including the id from group_patients (group_patient_id)
$membersQuery = "
    SELECT gp.id AS group_patient_id, u.name AS member_name
    FROM users u
    JOIN group_patients gp ON u.id = gp.patient_id
    WHERE gp.group_id = ?
";
$stmt = $conn->prepare($membersQuery);
$stmt->bind_param('i', $group_id);
$stmt->execute();
$membersResult = $stmt->get_result();

$members = [];
while ($member = $membersResult->fetch_assoc()) {
    $members[] = [
        'group_patient_id' => $member['group_patient_id'], 
        'name' => $member['member_name']
    ];
}


echo json_encode([
    'status' => 'success',
    'members' => $members
]);


$stmt->close();
$conn->close();
?>
