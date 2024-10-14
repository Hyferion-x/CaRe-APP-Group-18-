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

// Fetch patients associated with the therapist's groups from the group_patients table
$patientsQuery = "
    SELECT DISTINCT u.id, u.name 
    FROM users u
    JOIN group_patients gp ON u.id = gp.patient_id
    JOIN groups g ON gp.group_id = g.id
    WHERE g.therapist_id = ?
";
$stmt = $conn->prepare($patientsQuery);

if (!$stmt) {
    echo json_encode(['status' => 'error', 'message' => 'Failed to prepare query']);
    exit();
}

$stmt->bind_param('i', $therapist_id);
$stmt->execute();
$patientsResult = $stmt->get_result();

$patients = [];
while ($patient = $patientsResult->fetch_assoc()) {
    $patients[] = ['id' => $patient['id'], 'name' => $patient['name']];
}


if (!empty($patients)) {
    echo json_encode(['status' => 'success', 'patients' => $patients]);
} else {
    echo json_encode(['status' => 'error', 'message' => 'No patients available']);
}


$stmt->close();
$conn->close();
?>
