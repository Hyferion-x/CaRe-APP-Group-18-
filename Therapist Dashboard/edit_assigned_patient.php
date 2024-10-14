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

// Check if the necessary parameters are provided
if (!isset($_POST['patient_id']) || !isset($_POST['group_id']) || !isset($_POST['action'])) {
    echo json_encode(['status' => 'error', 'message' => 'Patient ID, Group ID, and Action are required']);
    exit();
}

$patient_id = intval($_POST['patient_id']);
$group_id = intval($_POST['group_id']);
$action = $_POST['action'];

// Check if the therapist owns the group
$checkGroupSql = "SELECT id FROM groups WHERE id = ? AND therapist_id = ?";
$stmt = $conn->prepare($checkGroupSql);
$stmt->bind_param('ii', $group_id, $therapist_id);
$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows === 0) {
    echo json_encode(['status' => 'error', 'message' => 'Group not found or unauthorized']);
    exit();
}

if ($action === 'add') {
    // Check if the patient is already in the group
    $checkPatientSql = "SELECT * FROM group_patients WHERE group_id = ? AND patient_id = ?";
    $stmt = $conn->prepare($checkPatientSql);
    $stmt->bind_param('ii', $group_id, $patient_id);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        echo json_encode(['status' => 'error', 'message' => 'Patient is already in the group']);
        exit();
    }

    // Add the patient to the group
    $assignSql = "INSERT INTO group_patients (group_id, patient_id) VALUES (?, ?)";
    $stmt = $conn->prepare($assignSql);
    $stmt->bind_param('ii', $group_id, $patient_id);

    if ($stmt->execute()) {
        echo json_encode(['status' => 'success', 'message' => 'Patient added to the group']);
    } else {
        echo json_encode(['status' => 'error', 'message' => 'Failed to add patient']);
    }
} elseif ($action === 'remove') {
    // Remove the patient from the group
    $removeSql = "DELETE FROM group_patients WHERE group_id = ? AND patient_id = ?";
    $stmt = $conn->prepare($removeSql);
    $stmt->bind_param('ii', $group_id, $patient_id);

    if ($stmt->execute() && $stmt->affected_rows > 0) {
        echo json_encode(['status' => 'success', 'message' => 'Patient removed from the group']);
    } else {
        echo json_encode(['status' => 'error', 'message' => 'Failed to remove patient or patient not in the group']);
    }
} else {
    echo json_encode(['status' => 'error', 'message' => 'Invalid action']);
}

$stmt->close();
$conn->close();
?>
