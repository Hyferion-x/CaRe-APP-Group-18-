<?php
session_start();
//weli0007

include 'db_connect.php';
if (!isset($_SESSION['user_id'])) {
    echo json_encode(['error' => 'User not logged in']);
    exit;
}

$user_id = $_SESSION['user_id']; 


$email = filter_var($_POST['email'] ?? '', FILTER_SANITIZE_EMAIL);
$phone = filter_var($_POST['phone'] ?? '', FILTER_SANITIZE_STRING);
$mobile = filter_var($_POST['mobile'] ?? '', FILTER_SANITIZE_STRING);
$gender = filter_var($_POST['gender'] ?? '', FILTER_SANITIZE_STRING);
$birthday = $_POST['birthday'] ?? ''; 
$address = filter_var($_POST['address'] ?? '', FILTER_SANITIZE_STRING);
$blood_type = filter_var($_POST['blood_type'] ?? '', FILTER_SANITIZE_STRING);
$allergies = filter_var($_POST['allergies'] ?? '', FILTER_SANITIZE_STRING);
$insurance_id = filter_var($_POST['insurance_id'] ?? '', FILTER_SANITIZE_STRING);

// Validate email
if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
    echo json_encode(['error' => 'Invalid email address.']);
    exit;
}

//update query 
$query = "UPDATE users SET email = ?, phone = ?, mobile = ?, gender = ?, birthday = ?, address = ?, blood_type = ?, allergies = ?, insurance_id = ? WHERE id = ?";

if ($stmt = $conn->prepare($query)) {
    
    $stmt->bind_param("sssssssssi", $email, $phone, $mobile, $gender, $birthday, $address, $blood_type, $allergies, $insurance_id, $user_id);
    
    
    if ($stmt->execute()) {
        
        if ($stmt->affected_rows > 0) {
            echo json_encode(['success' => true]); 
        } else {
            echo json_encode(['error' => 'No changes made or the data is identical.']);
        }
    } else {
        echo json_encode(['error' => 'Error updating profile: ' . $stmt->error]);
    }

    $stmt->close();
} else {
    echo json_encode(['error' => 'Failed to prepare the query: ' . $conn->error]);
}

$conn->close();
?>
