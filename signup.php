<?php
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Connect to the database
    $conn = new mysqli('localhost', 'root', '', 'care_db');

    // Check connection
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

    // Handle file upload for photo
    if (isset($_FILES['photo']) && $_FILES['photo']['error'] == 0) {
        $photo = $_FILES['photo']['name'];
        $photoTmpName = $_FILES['photo']['tmp_name'];
        $photoPath = 'uploads/' . basename($photo);
        move_uploaded_file($photoTmpName, $photoPath);
    } else {
        $photoPath = NULL; // No photo uploaded
    }

    // Validate passwords
    if ($password !== $confirmPassword) {
        die("Passwords do not match.");
    }

    // Hash the password
    $hashedPassword = password_hash($password, PASSWORD_DEFAULT);

    // Insert user into the database
    $sql = "INSERT INTO users (username, email, password, name, photo, phone, mobile, address, gender, birthday, allergies, blood_type, insurance_id, bio, role)
            VALUES ('$username', '$email', '$hashedPassword', '$name', '$photoPath', '$phone', '$mobile', '$address', '$gender', '$birthday', '$allergies', '$blood_type', '$insurance_id', '$bio', '$role')";

    if ($conn->query($sql) === TRUE) {
        // Redirect to login page
        header('Location: login.html');
    } else {
        die("Database error: " . $conn->error);
    }

    // Close the connection
    $conn->close();
}
?>
