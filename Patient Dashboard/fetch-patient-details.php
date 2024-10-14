<?php
session_start(); 

//weli0007
$servername = "localhost";
$username = "root"; 
$password = ""; 
$dbname = "care"; 


$conn = new mysqli($servername, $username, $password, $dbname);


if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}


$patient_id = $_SESSION['user_id'];  


$sql = "SELECT name, email, mobile, phone, address, gender, birthday, allergies, age, blood_group, insurance_id, bio FROM users WHERE id = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $patient_id);
$stmt->execute();
$result = $stmt->get_result();


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

$stmt->close();
$conn->close();
?>
