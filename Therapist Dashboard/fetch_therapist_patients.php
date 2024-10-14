<?php
session_start();
//weli0007
include 'db_connect.php'; 

header('Content-Type: application/json');

// Check if the therapist is logged in
if (!isset($_SESSION['user_id']) || $_SESSION['role'] != 'therapist') {
    echo json_encode(['status' => 'error', 'message' => 'Unauthorized']);
    exit();
}

$therapist_id = $_SESSION['user_id'];

// Fetch patients assigned to the logged-in therapist
$sql = "SELECT id, name FROM users WHERE role = 'patient' AND therapist_id = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $therapist_id);
$stmt->execute();
$result = $stmt->get_result();

$patients = [];
while ($row = $result->fetch_assoc()) {
    $patients[] = $row;
}

echo json_encode($patients);

$stmt->close();
$conn->close();
?>
