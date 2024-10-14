<?php
session_start();
//weli0007
$servername = "localhost";
$username = "root"; 
$password = ""; 
$dbname = "care_db"; 


$conn = new mysqli($servername, $username, $password, $dbname);


if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}


$therapist_id = $_SESSION['user_id'];

// Fetch notes associated with the therapist's patients
$sql = "SELECT n.note_date, n.note_content, u.name as patient_name FROM notes n
        INNER JOIN patients p ON n.patient_id = p.id
        INNER JOIN users u ON p.user_id = u.id
        WHERE p.therapist_id = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $therapist_id);
$stmt->execute();
$result = $stmt->get_result();

$notes = [];
if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        $notes[] = [
            'note_date' => $row['note_date'],
            'note_content' => $row['note_content'],
            'patient_name' => $row['patient_name']
        ];
    }
} else {
    echo json_encode(['message' => 'No notes found']);
    exit;
}


header('Content-Type: application/json');
echo json_encode($notes);


$stmt->close();
$conn->close();
?>
