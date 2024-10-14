<?php
session_start();
include 'db_connect.php'; 
//weli0007


if (!isset($_SESSION['user_id'])) {
    echo json_encode(['error' => 'User not logged in']);
    exit;
}

$user_id = $_SESSION['user_id']; 

$query = "SELECT username, email, name, photo, phone, mobile, gender, birthday, address, blood_type, allergies, insurance_id, bio 
          FROM users WHERE id = ?";

if ($stmt = $conn->prepare($query)) {
    $stmt->bind_param("i", $user_id);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        $user = $result->fetch_assoc();

        
        if (!empty($user['photo']) && !str_starts_with($user['photo'], 'uploads/')) {
            $user['photo'] = 'uploads/' . $user['photo'];
        }

        
        $user['bio'] = !empty($user['bio']) ? $user['bio'] : '';
        $user['phone'] = !empty($user['phone']) ? $user['phone'] : '';
        $user['mobile'] = !empty($user['mobile']) ? $user['mobile'] : '';
        $user['gender'] = !empty($user['gender']) ? $user['gender'] : '';
        $user['birthday'] = !empty($user['birthday']) ? $user['birthday'] : '';
        $user['address'] = !empty($user['address']) ? $user['address'] : '';
        $user['blood_type'] = !empty($user['blood_type']) ? $user['blood_type'] : '';
        $user['allergies'] = !empty($user['allergies']) ? $user['allergies'] : '';
        $user['insurance_id'] = !empty($user['insurance_id']) ? $user['insurance_id'] : '';

        echo json_encode($user); 
    } else {
        echo json_encode(['error' => 'No user found']);
    }

    $stmt->close();
} else {
    echo json_encode(['error' => 'Failed to prepare the query']);
}

$conn->close();
?>
