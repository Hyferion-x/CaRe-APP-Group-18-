<?php
//weli0007
session_start();
include 'db_connect.php';

$user_id = $_SESSION['user_id']; 


$query = "SELECT date, energy_level FROM journal_entries WHERE user_id = ? ORDER BY date DESC";

if ($stmt = $conn->prepare($query)) {
    $stmt->bind_param("i", $user_id); 
    $stmt->execute();
    $result = $stmt->get_result();

    $energy_data = [];
    while ($row = $result->fetch_assoc()) {
        $energy_data[] = $row; 
    }

    
    header('Content-Type: application/json');
    echo json_encode($energy_data);
} else {
    echo json_encode(['error' => 'Failed to fetch energy data']);
}

$stmt->close();
$conn->close();
?>
