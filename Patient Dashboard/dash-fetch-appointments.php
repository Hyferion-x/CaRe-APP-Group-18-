<?php
//weli0007
session_start();
include 'db_connect.php';

$user_id = $_SESSION['user_id']; 


$query = "SELECT date, description FROM notes WHERE user_id = ? AND date >= CURDATE() ORDER BY date ASC";

if ($stmt = $conn->prepare($query)) {
    $stmt->bind_param("i", $user_id); 
    $stmt->execute();
    $result = $stmt->get_result();

    $appointments = [];
    while ($row = $result->fetch_assoc()) {
        $appointments[] = $row; 
    }

    
    header('Content-Type: application/json');
    echo json_encode($appointments);
} else {
    echo json_encode(['error' => 'Failed to fetch upcoming appointments']);
}

$stmt->close();
$conn->close();
?>
