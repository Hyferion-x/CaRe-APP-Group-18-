<?php
//weli0007
session_start();
include 'db_connect.php';

$user_id = $_SESSION['user_id']; 


$query = "SELECT date, mood FROM journal_entries WHERE user_id = ? ORDER BY date DESC";

if ($stmt = $conn->prepare($query)) {
    $stmt->bind_param("i", $user_id); 
    $stmt->execute();
    $result = $stmt->get_result();

    $mood_data = [];
    while ($row = $result->fetch_assoc()) {
        $mood_data[] = $row; 
    }

    
    header('Content-Type: application/json');
    echo json_encode($mood_data);
} else {
    echo json_encode(['error' => 'Failed to fetch mood data']);
}

$stmt->close();
$conn->close();
?>
