<?php
session_start();
//weli0007
include 'db_connect.php'; 

header('Content-Type: application/json');


if (!isset($_GET['session_id']) || empty($_GET['session_id'])) {
    echo json_encode(['status' => 'error', 'message' => 'No session ID provided']);
    exit();
}

$session_id = intval($_GET['session_id']);

// Fetch session details, including the group_id
$query = "SELECT id, session_date, session_time, notes, group_id 
          FROM sessions 
          WHERE id = ?";
$stmt = $conn->prepare($query);
$stmt->bind_param('i', $session_id);
$stmt->execute();
$result = $stmt->get_result();
$session = $result->fetch_assoc();

if (!$session) {
    echo json_encode(['status' => 'error', 'message' => 'Session not found']);
    exit();
}

// Fetch group members if group_id is available
$group_members = [];
if (!empty($session['group_id'])) {
    $group_id = $session['group_id'];
    
    // Fetch the patient names from group_patients and users table
    $member_query = "SELECT u.username 
                     FROM group_patients gp
                     JOIN users u ON gp.patient_id = u.id
                     WHERE gp.group_id = ?";
    $member_stmt = $conn->prepare($member_query);
    $member_stmt->bind_param('i', $group_id);
    $member_stmt->execute();
    $members_result = $member_stmt->get_result();
    
    while ($row = $members_result->fetch_assoc()) {
        $group_members[] = $row['username']; 
    }
}

echo json_encode([
    'status' => 'success',
    'id' => $session['id'],
    'session_date' => $session['session_date'],
    'session_time' => $session['session_time'],
    'notes' => $session['notes'],
    'group_members' => $group_members
]);

$stmt->close();
$conn->close();
?>
