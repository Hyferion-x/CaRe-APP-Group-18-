<?php
session_start();
//weli0007
include 'db_connect.php'; 




ini_set('display_errors', 1);
error_reporting(E_ALL);


if (!isset($_SESSION['user_id'])) {
    header('Content-Type: application/json');
    echo json_encode(['status' => 'error', 'message' => 'Unauthorized']);
    exit();
}

$therapist_id = $_SESSION['user_id'];


header('Content-Type: application/json');

// Check if group name is provided
if (isset($_POST['group_name']) && !empty($_POST['group_name'])) {
    $group_name = $_POST['group_name'];

    // insert the new group into the database
    $stmt = $conn->prepare("INSERT INTO groups (therapist_id, group_name) VALUES (?, ?)");
    $stmt->bind_param('is', $therapist_id, $group_name);

    if ($stmt->execute()) {
        echo json_encode(['status' => 'success', 'group_id' => $conn->insert_id, 'group_name' => $group_name]);
    } else {
        echo json_encode(['status' => 'error', 'message' => 'Failed to create group.']);
    }

    $stmt->close();
} else {
    echo json_encode(['status' => 'error', 'message' => 'Group name is required.']);
}


$conn->close();
?>
