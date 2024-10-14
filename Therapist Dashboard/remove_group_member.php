<?php
session_start();
//weli0007
include 'db_connect.php'; 

header('Content-Type: application/json');


ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

// Check if group_patient_id is provided
if (!isset($_POST['group_patient_id'])) {
    echo json_encode(['status' => 'error', 'message' => 'group_patient_id is required']);
    exit();
}

$group_patient_id = intval($_POST['group_patient_id']); // This is the primary key ID from group_patients

// Verify if the row exists in the database before deleting
$checkQuery = "SELECT * FROM group_patients WHERE id = ?";
$stmt = $conn->prepare($checkQuery);
$stmt->bind_param('i', $group_patient_id);
$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows > 0) {
    // The member exists, proceed to delete
    $deleteQuery = "DELETE FROM group_patients WHERE id = ?";
    $stmt = $conn->prepare($deleteQuery);
    $stmt->bind_param('i', $group_patient_id);

    if ($stmt->execute()) {
        if ($stmt->affected_rows > 0) {
            echo json_encode(['status' => 'success', 'message' => 'Member removed successfully']);
        } else {
            echo json_encode(['status' => 'error', 'message' => 'No rows affected. Please check if the member exists in the group.']);
        }
    } else {
        echo json_encode(['status' => 'error', 'message' => 'Failed to remove member']);
    }
} else {
    echo json_encode(['status' => 'error', 'message' => 'Member not found in group_patients']);
}

$stmt->close();
$conn->close();
?>
