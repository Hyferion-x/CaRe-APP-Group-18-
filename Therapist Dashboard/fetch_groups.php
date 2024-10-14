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
    echo json_encode(['status' => 'error', 'message' => 'Unauthorized']);
    exit();
}

$therapist_id = $_SESSION['user_id'];

// Fetch the groups created by this therapist
$sql = "SELECT g.id, g.name, GROUP_CONCAT(p.name SEPARATOR ', ') AS patient_names
        FROM groups g
        LEFT JOIN group_patients gp ON g.id = gp.group_id
        LEFT JOIN patients p ON gp.patient_id = p.id
        WHERE g.therapist_id = ?
        GROUP BY g.id";
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
        'name' => $row['name'],
        'patients' => $row['patient_names'] ? explode(', ', $row['patient_names']) : [] 
    ];
}


echo json_encode(['status' => 'success', 'groups' => $groups]);


$stmt->close();
$conn->close();
