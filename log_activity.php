<?php
session_start();
//weli0007
header('Content-Type: application/json'); 
include 'db_connect.php'; 


if (!isset($_SESSION['user_id'])) {
    echo json_encode(['status' => 'error', 'message' => 'User not logged in.']);
    exit;
}

// Check if the form was submitted
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    
    $user_id = $_SESSION['user_id'];
    $activity_type = $_POST['activity-type'];
    $activity_date = $_POST['date'];
    $activity_time = $_POST['time'];

    // Insert the activity into the activity_log table
    $sql = "INSERT INTO activity_log (user_id, activity_type, activity_date, activity_time) VALUES (?, ?, ?, ?)";

    
    $stmt = $conn->prepare($sql);
    if ($stmt === false) {
        echo json_encode(['status' => 'error', 'message' => 'Error preparing statement: ' . $conn->error]);
        exit;
    }

    $stmt->bind_param("isss", $user_id, $activity_type, $activity_date, $activity_time);

    if ($stmt->execute()) {
        echo json_encode(['status' => 'success', 'message' => 'Activity logged successfully!']);
    } else {
        echo json_encode(['status' => 'error', 'message' => 'Error logging activity: ' . $conn->error]);
    }

    $stmt->close();
    $conn->close();
} else {
    echo json_encode(['status' => 'error', 'message' => 'Invalid request method']);
}
?>
