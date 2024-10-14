<?php
//weli0007
require 'db_connect.php'; 

header('Content-Type: application/json');

// Fetch patients with role 'patient'
$patientsQuery = "SELECT u.id, u.name, u.therapist_id, t.name as current_therapist 
                  FROM users u
                  LEFT JOIN users t ON u.therapist_id = t.id
                  WHERE u.role = 'patient'";

$therapistsQuery = "SELECT id, name FROM users WHERE role = 'therapist'";

$patientsResult = $conn->query($patientsQuery);
$therapistsResult = $conn->query($therapistsQuery);

$patients = [];
$therapists = [];

if ($patientsResult->num_rows > 0) {
    while ($row = $patientsResult->fetch_assoc()) {
        $patients[] = [
            'id' => $row['id'],
            'name' => $row['name'],
            'therapist_id' => $row['therapist_id'],
            'current_therapist' => $row['current_therapist']
        ];
    }
}

if ($therapistsResult->num_rows > 0) {
    while ($row = $therapistsResult->fetch_assoc()) {
        $therapists[] = ['id' => $row['id'], 'name' => $row['name']];
    }
}

echo json_encode([
    'success' => true,
    'patients' => $patients,
    'therapists' => $therapists
]);

$conn->close();
?>
