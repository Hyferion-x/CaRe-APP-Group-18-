<?php
//weli0007
session_start();
include 'db_connect.php';

$user_id = $_SESSION['user_id']; 


$fromDate = isset($_GET['fromDate']) ? $_GET['fromDate'] : '';
$toDate = isset($_GET['toDate']) ? $_GET['toDate'] : '';


$query = "SELECT mood, COUNT(mood) as mood_count FROM journal_entries WHERE user_id = ?";


if ($fromDate && $toDate) {
    $query .= " AND date BETWEEN ? AND ?";
}

$query .= " GROUP BY mood ORDER BY mood_count DESC";

if ($stmt = $conn->prepare($query)) {
    if ($fromDate && $toDate) {
        $stmt->bind_param("iss", $user_id, $fromDate, $toDate); 
    } else {
        $stmt->bind_param("i", $user_id); 
    }

    $stmt->execute();
    $result = $stmt->get_result();

    $feeling_data = [];
    while ($row = $result->fetch_assoc()) {
        $feeling_data[] = $row; 
    }

    
    header('Content-Type: application/json');
    echo json_encode($feeling_data);
} else {
    echo json_encode(['error' => 'Failed to fetch feeling data']);
}

$stmt->close();
$conn->close();
?>
