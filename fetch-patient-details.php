<?php
session_start(); // Ensure the session is started

// Database connection
$servername = "localhost";
$username = "root"; // Replace with your database username
$password = ""; // Replace with your database password
$dbname = "care"; // Replace with your database name

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Assuming the user is logged in and the session holds the patient ID
$patient_id = $_SESSION['user_id'];  // Set the user ID via session

// Fetch user details from the `users` table based on the user ID
$sql = "SELECT name, email, mobile, phone, address, gender, birthday, allergies, age, blood_group, insurance_id, bio FROM users WHERE id = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $patient_id);
$stmt->execute();
$result = $stmt->get_result();

// If user data is found, assign to variables
if ($result->num_rows > 0) {
    $row = $result->fetch_assoc();
    $name = $row['name'];
    $email = $row['email'];
    $mobile = $row['mobile']; 
    $phone = $row['phone']; 
    $address = $row['address'];
    $gender = $row['gender'];
    $birthday = $row['birthday'];
    $allergies = $row['allergies'];
    $age = $row['age'];
    $blood_group = $row['blood_group'];
    $insurance_id = $row['insurance_id'];
    $bio = $row['bio'];
} else {
    echo "No user found.";
}

// Close connection
$stmt->close();
$conn->close();
?>
