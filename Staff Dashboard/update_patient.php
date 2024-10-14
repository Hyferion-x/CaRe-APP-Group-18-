<?php
session_start();
require 'db_connect.php'; // Assuming you have a file to handle database connection

// Enable error reporting for debugging
error_reporting(E_ALL);
ini_set('display_errors', 1);

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Get the patient ID from the POST request
    if (!isset($_POST['id'])) {
        echo json_encode(['success' => false, 'error' => 'No patient ID provided.']);
        exit();
    }

    $id = intval($_POST['id']);  // Patient ID

    // Retrieve and sanitize input data
    $name = $conn->real_escape_string($_POST['name']);
    $age = intval($_POST['age']);
    $gender = $conn->real_escape_string($_POST['gender']);
    $email = $conn->real_escape_string($_POST['email']);
    $phone = $conn->real_escape_string($_POST['phone']);
    $mobile = $conn->real_escape_string($_POST['mobile']);
    $address = $conn->real_escape_string($_POST['address']);
    $birthday = $conn->real_escape_string($_POST['birthday']);
    $allergies = $conn->real_escape_string($_POST['allergies']);
    $blood_type = $conn->real_escape_string($_POST['blood_type']);
    $insurance_id = $conn->real_escape_string($_POST['insurance_id']);
    $bio = $conn->real_escape_string($_POST['bio']);

    // Update the user details in the database
    $query = "UPDATE users SET 
              name = ?, 
              age = ?, 
              gender = ?, 
              email = ?, 
              phone = ?, 
              mobile = ?, 
              address = ?, 
              birthday = ?, 
              allergies = ?, 
              blood_type = ?, 
              insurance_id = ?, 
              bio = ?
              WHERE id = ?";

    $stmt = $conn->prepare($query);
    if ($stmt) {
        // Bind the parameters to the query
        $stmt->bind_param(
            'sissssssssssi', 
            $name, $age, $gender, $email, $phone, $mobile, $address, $birthday, 
            $allergies, $blood_type, $insurance_id, $bio, $id
        );

        // Execute the query
        if ($stmt->execute()) {
            // Send success response
            echo json_encode(['success' => true]);
        } else {
            // Send detailed error response if query fails
            echo json_encode(['success' => false, 'error' => 'Failed to update patient details.', 'sql_error' => $stmt->error]);
        }
        $stmt->close();
    } else {
        echo json_encode(['success' => false, 'error' => 'Failed to prepare the update query.', 'sql_error' => $conn->error]);
    }
} else {
    echo json_encode(['success' => false, 'error' => 'Invalid request method.']);
}

// Close the database connection
$conn->close();
?>
