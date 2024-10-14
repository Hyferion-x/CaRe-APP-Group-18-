<?php
session_start();
//weli0007
header('Content-Type: application/json');
include 'db_connect.php'; 


if (!isset($_SESSION['user_id']) || $_SESSION['role'] !== 'therapist') {
    echo json_encode(['error' => 'Unauthorized']);
    exit();
}

if (!isset($_GET['user_id'])) {
    echo json_encode(['error' => 'User ID is required']);
    exit();
}

$therapist_id = $_SESSION['user_id'];
$user_id = intval($_GET['user_id']); 

// Query to fetch patient details
$query = "
    SELECT id, name, age, phone, address, gender, birthday, allergies, blood_type, photo
    FROM users
    WHERE id = ? AND therapist_id = ? AND role = 'patient'
";



$stmt = $conn->prepare($query);
$stmt->bind_param('ii', $user_id, $therapist_id); 
$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows > 0) {
    $patient = $result->fetch_assoc();
    echo json_encode($patient); 
} else {
    echo json_encode(['error' => 'Patient not found or not assigned to this therapist']);
}

$stmt->close();
$conn->close();
?>
