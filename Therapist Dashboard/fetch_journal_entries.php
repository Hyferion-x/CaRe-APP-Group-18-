<?php
//weli0007
header('Content-Type: application/json');
session_start();
include 'db_connect.php'; 


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

// Fetch journal entries for the specific user (patient)
$query = "
    SELECT date AS entry_date, mood, energy_level, entry 
    FROM journal_entries 
    WHERE user_id = ? 
    ORDER BY entry_date ASC";  

$stmt = $conn->prepare($query);
$stmt->bind_param('i', $user_id);
$stmt->execute();
$result = $stmt->get_result();

$journal_entries = [];
while ($row = $result->fetch_assoc()) {
    $journal_entries[] = $row;
}


echo json_encode($journal_entries);

$stmt->close();
$conn->close();
?>
