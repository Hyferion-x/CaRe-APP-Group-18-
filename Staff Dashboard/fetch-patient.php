<?php
include 'db_connect.php'; // Connection to the database

if (isset($_GET['query'])) {
    $query = $_GET['query'];
    
    $stmt = $conn->prepare("SELECT * FROM users WHERE role = 'patient' AND (name LIKE ? OR id LIKE ?)");
    $searchTerm = "%$query%";
    $stmt->bind_param("ss", $searchTerm, $searchTerm);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        $patients = [];
        while ($row = $result->fetch_assoc()) {
            $patients[] = [
                'id' => $row['id'],
                'name' => $row['name']
            ];
        }
        echo json_encode(['success' => true, 'patients' => $patients]);
    } else {
        echo json_encode(['success' => false]);
    }
} elseif (isset($_GET['id'])) {
    $patientId = $_GET['id'];
    
    $stmt = $conn->prepare("SELECT * FROM users WHERE id = ? AND role = 'patient'");
    $stmt->bind_param("i", $patientId);
    $stmt->execute();
    $result = $stmt->get_result();
    
    if ($result->num_rows > 0) {
        $patient = $result->fetch_assoc();
        echo json_encode(['success' => true, 'name' => $patient['name'], 'age' => $patient['age'], 'gender' => $patient['gender'], 'email' => $patient['email'], 'phone' => $patient['phone'], 'mobile' => $patient['mobile'], 'address' => $patient['address'], 'birthday' => $patient['birthday'], 'allergies' => $patient['allergies'], 'blood_type' => $patient['blood_type'], 'insurance_id' => $patient['insurance_id'], 'bio' => $patient['bio']]);
    } else {
        echo json_encode(['success' => false]);
    }
}

$conn->close();
?>
