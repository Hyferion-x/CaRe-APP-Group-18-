<?php
//weli0007
header('Content-Type: application/json');
session_start();
include 'db_connect.php'; 

// Check if the therapist is logged in 
if (!isset($_SESSION['user_id']) || $_SESSION['role'] !== 'therapist') {
    echo json_encode(['error' => 'Unauthorized']);
    exit();
}

$therapist_id = $_SESSION['user_id'];

// Query to fetch patients assigned to the logged-in therapist
$query = "
    SELECT p.id, p.name, p.age, p.photo AS profile_pic
    FROM users p
    WHERE p.therapist_id = ? AND p.role = 'patient'
";


$stmt = $conn->prepare($query);
if ($stmt === false) {
    echo json_encode(['error' => 'Error preparing the statement']);
    exit();
}

$stmt->bind_param('i', $therapist_id);
$stmt->execute();
$result = $stmt->get_result();


$patients = [];
if ($result->num_rows > 0) {
    // Fetch all patients
    while ($row = $result->fetch_assoc()) {
        $patients[] = $row;
    }
} else {
    
    echo json_encode(['error' => 'No patients assigned to this therapist']);
    exit();
}


echo json_encode($patients);


$stmt->close();
$conn->close();
?>
