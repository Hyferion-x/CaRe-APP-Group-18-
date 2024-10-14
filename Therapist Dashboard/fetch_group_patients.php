<?php
//weli0007
session_start();
header('Content-Type: application/json');
include 'db_connect.php'; 


if (!isset($_SESSION['user_id']) || $_SESSION['role'] !== 'therapist') {
    echo json_encode(['error' => 'Unauthorized']);
    exit();
}

// Check if group_id is provided
if (!isset($_GET['group_id'])) {
    echo json_encode(['error' => 'Group ID is required']);
    exit();
}

$group_id = intval($_GET['group_id']);
$therapist_id = $_SESSION['user_id'];

// Fetch group details and patients for the given group
$query = "
    SELECT g.group_name, u.name AS patient_name, u.id AS patient_id
    FROM groups g
    JOIN group_patients gp ON gp.group_id = g.id
    JOIN users u ON u.id = gp.patient_id
    WHERE g.id = ? AND g.therapist_id = ?
";

$stmt = $conn->prepare($query);
$stmt->bind_param('ii', $group_id, $therapist_id);
$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows > 0) {
    $groupData = [];
    while ($row = $result->fetch_assoc()) {
        $groupData[] = [
            'group_name' => $row['group_name'],
            'patient_name' => $row['patient_name'],
            'patient_id' => $row['patient_id']
        ];
    }
    echo json_encode($groupData);
} else {
    echo json_encode(['error' => 'Group not found or no patients assigned']);
}

$stmt->close();
$conn->close();
?>
