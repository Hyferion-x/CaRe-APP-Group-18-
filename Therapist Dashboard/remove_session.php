<?php
session_start();
//weli0007


include 'db_connect.php'; 

header('Content-Type: application/json'); 

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $sessionId = $_POST['session_id'];

    if (empty($sessionId)) {
        echo json_encode(['status' => 'error', 'message' => 'Invalid session ID']);
        exit;
    }

    // Execute the deletion query
    $query = "DELETE FROM sessions WHERE id = ?";
    $stmt = $conn->prepare($query);
    
    if (!$stmt) {
        echo json_encode(['status' => 'error', 'message' => 'Query preparation failed']);
        exit;
    }

    $stmt->bind_param('i', $sessionId);

    if ($stmt->execute()) {
        echo json_encode(['status' => 'success']);
    } else {
        echo json_encode(['status' => 'error', 'message' => 'Failed to delete session']);
    }

    $stmt->close();
    $conn->close();
} else {
    echo json_encode(['status' => 'error', 'message' => 'Invalid request method']);
}
?>
