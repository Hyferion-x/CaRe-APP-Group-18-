<?php
session_start();
include 'db_connect.php'; 
//weli0007

error_reporting(E_ALL);
ini_set('display_errors', 1);


if (!isset($_SESSION['user_id'])) {
    echo json_encode(['error' => 'User not logged in']);
    exit;
}

$user_id = $_SESSION['user_id']; 


$query = "SELECT session_date, session_time, status, notes
          FROM sessions
          WHERE therapist_id = ?"; 

if ($stmt = $conn->prepare($query)) {
    $stmt->bind_param("i", $user_id); 
    $stmt->execute();
    $result = $stmt->get_result();

    
    $sessions = [];

    
    while ($row = $result->fetch_assoc()) {
        $sessions[] = [
            'session_date' => $row['session_date'],
            'session_time' => $row['session_time'],
            'status' => $row['status'],
            'notes' => $row['notes'] ? $row['notes'] : 'No Description' 
        ];
    }

    
    if (empty($sessions)) {
        echo json_encode(['error' => 'No sessions found for the user']);
    } else {
        header('Content-Type: application/json');
        echo json_encode($sessions);
    }

    $stmt->close();
} else {
    
    echo json_encode(['error' => 'Failed to prepare session data query']);
}

$conn->close(); 
?>
