<?php
//weli0007
error_reporting(E_ALL);
ini_set('display_errors', 1);

include 'db_connect.php'; 

// Get the incoming JSON request body
$data = json_decode(file_get_contents("php://input"), true);

if (isset($data['assignments'])) {
    foreach ($data['assignments'] as $assignment) {
        $patientId = intval($assignment['patientId']);
        $therapistId = intval($assignment['therapistId']);

        // Update the patient's therapist assignment in the database
        $stmt = $conn->prepare("UPDATE users SET therapist_id = ? WHERE id = ?");
        $stmt->bind_param("ii", $therapistId, $patientId);
        
        if (!$stmt->execute()) {
            
            echo json_encode(['success' => false, 'error' => 'Failed to assign therapist.']);
            error_log("Failed to assign therapist for patient $patientId. Error: " . $stmt->error);
            exit();
        }
    }

    
    error_log("Therapist assignments updated successfully");
    
    echo json_encode(['success' => true]);
} else {
    echo json_encode(['success' => false, 'error' => 'Invalid data.']);
    error_log("Invalid data received in assign_therapists.php");
}

$conn->close();
?>
