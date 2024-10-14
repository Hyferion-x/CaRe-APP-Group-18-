<?php
session_start();


error_reporting(E_ALL);
ini_set('display_errors', 1);

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    
    $conn = new mysqli('localhost', 'root', '', 'care_db');

    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }

    // Collect form data
    $username = $conn->real_escape_string($_POST['username']);
    $email = $conn->real_escape_string($_POST['email']);
    $password = $conn->real_escape_string($_POST['password']);
    $confirmPassword = $conn->real_escape_string($_POST['confirm-password']);
    $name = $conn->real_escape_string($_POST['name']);
    $phone = $conn->real_escape_string($_POST['phone']);
    $mobile = $conn->real_escape_string($_POST['mobile']);
    $address = $conn->real_escape_string($_POST['address']);
    $gender = $conn->real_escape_string($_POST['gender']);
    $birthday = $conn->real_escape_string($_POST['birthday']);
    $allergies = $conn->real_escape_string($_POST['allergies']);
    $blood_type = $conn->real_escape_string($_POST['blood_type']);
    $insurance_id = $conn->real_escape_string($_POST['insurance_id']);
    $bio = $conn->real_escape_string($_POST['bio']);
    $role = $conn->real_escape_string($_POST['role']);

    // Validate passwords
    if ($password !== $confirmPassword) {
        die(json_encode(['error' => 'Passwords do not match.']));
    }

    // Check if username or email already exists
    $checkUserSql = "SELECT id FROM users WHERE username='$username' OR email='$email'";
    $checkUserResult = $conn->query($checkUserSql);

    if ($checkUserResult && $checkUserResult->num_rows > 0) {
        die(json_encode(['error' => 'Username or email already exists. Please choose another.']));
    }

    // Handle file upload (photo)
    $targetDir = "uploads/";  
    $photoPath = NULL;

    if (!empty($_FILES['photo']['name'])) {
        $photoName = basename($_FILES['photo']['name']);
        $targetFilePath = $targetDir . $photoName;
        $imageFileType = strtolower(pathinfo($targetFilePath, PATHINFO_EXTENSION));

        // Validate image type
        $validExtensions = ['jpg', 'jpeg', 'png', 'gif'];
        if (in_array($imageFileType, $validExtensions)) {
            if (move_uploaded_file($_FILES['photo']['tmp_name'], $targetFilePath)) {
                $photoPath = $targetFilePath; 
            } else {
                die(json_encode(['error' => 'There was an error uploading the file.']));
            }
        } else {
            die(json_encode(['error' => 'Only JPG, JPEG, PNG & GIF files are allowed.']));
        }
    }

    // Hash the password
    $hashedPassword = password_hash($password, PASSWORD_DEFAULT);

    
    $sql = "INSERT INTO users (username, email, password, name, phone, mobile, address, gender, birthday, allergies, blood_type, insurance_id, bio, role, photo)
            VALUES ('$username', '$email', '$hashedPassword', '$name', '$phone', '$mobile', '$address', '$gender', '$birthday', '$allergies', '$blood_type', '$insurance_id', '$bio', '$role', '$photoPath')";

    if ($conn->query($sql) === TRUE) {
        
        echo json_encode(['success' => true, 'message' => 'Signup successful.']);
    } else {
        die(json_encode(['error' => 'Database error: ' . $conn->error]));
    }

    
    $conn->close();
}
?>
