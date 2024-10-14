<?php
session_start();
//weli0007
include 'db_connect.php'; 


error_reporting(E_ALL);
ini_set('display_errors', 1);


if (!isset($_SESSION['user_id'])) {
    echo json_encode(['status' => 'error', 'message' => 'Unauthorized']);
    exit();
}

$therapist_id = $_SESSION['user_id'];


if (!isset($_POST['patient_id']) || !isset($_POST['group_id'])) {
    echo json_encode(['status' => 'error', 'message' => 'Missing patient_id or group_id']);
    exit();
}

$patient_id = $_POST['patient_id'];
$group_id = $_POST['group_id'];

// Check if the patient is assigned to this therapist before assigning them to a group
$checkPatientSql = "SELECT id FROM users WHERE id = ? AND therapist_id = ?";
$stmt = $conn->prepare($checkPatientSql);
$stmt->bind_param("ii", $patient_id, $therapist_id);
$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows === 0) {
    echo json_encode(['status' => 'error', 'message' => 'Patient not assigned to this therapist']);
    exit();
}

// Assign the patient to the group
$sql = "INSERT INTO group_patients (group_id, patient_id) VALUES (?, ?)";
$stmt = $conn->prepare($sql);
$stmt->bind_param("ii", $group_id, $patient_id);
if ($stmt->execute()) {
    echo json_encode(['status' => 'success']);
} else {
    echo json_encode(['status' => 'error', 'message' => 'Failed to assign patient to group']);
}


$stmt->close();
$conn->close();
?>
