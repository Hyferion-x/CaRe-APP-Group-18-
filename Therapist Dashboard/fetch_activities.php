<?php
header('Content-Type: application/json');
session_start();
//weli0007
include 'db_connect.php'; 

// Check if the therapist is logged in
if (!isset($_SESSION['user_id']) || $_SESSION['role'] !== 'therapist') {
    echo json_encode(['error' => 'Unauthorized']);
    exit();
}

// Check if user_id (patient's ID) is passed
if (!isset($_GET['user_id'])) {
    echo json_encode(['error' => 'User ID is required']);
    exit();
}

$user_id = intval($_GET['user_id']);

// Ensure the connection is successful
if ($conn->connect_error) {
    echo json_encode(['error' => 'Database connection failed: ' . $conn->connect_error]);
    exit();
}

// Fetch activities for the specific user (patient)
$query = "
    SELECT activity_type, activity_time
    FROM activity_log 
    WHERE user_id = ?
    ORDER BY activity_time ASC";  

$stmt = $conn->prepare($query);

if ($stmt === false) {
    echo json_encode(['error' => 'Failed to prepare the query: ' . $conn->error]);
    exit();
}

$stmt->bind_param('i', $user_id);
$stmt->execute();

$result = $stmt->get_result();

if ($result === false) {
    echo json_encode(['error' => 'Failed to execute query: ' . $stmt->error]);
    exit();
}

$activities = [];
while ($row = $result->fetch_assoc()) {
    $activities[] = $row;
}


if (!empty($activities)) {
    echo json_encode($activities);
} else {
    echo json_encode(['message' => 'No activities found for this patient.']);
}

$stmt->close();
$conn->close();
?>
