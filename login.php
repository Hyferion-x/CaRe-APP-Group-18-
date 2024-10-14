<?php
session_start();
//weli0007
error_reporting(E_ALL);
ini_set('display_errors', 1);

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    
    $conn = new mysqli('localhost', 'root', '', 'care_db');

    
    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }

    // Collect form data
    $username = $conn->real_escape_string($_POST['username']);
    $password = $_POST['password']; 

    // Fetch user from the database
    $sql = "SELECT * FROM users WHERE username='$username'";
    $result = $conn->query($sql);

    if ($result && $result->num_rows > 0) {
        $user = $result->fetch_assoc();

        // Verify the password
        if (password_verify($password, $user['password'])) {
            
            $_SESSION['user_id'] = $user['id']; 
            $_SESSION['username'] = $user['username'];
            $_SESSION['name'] = $user['name'];
            $_SESSION['photo'] = $user['photo'];
            $_SESSION['role'] = $user['role'];

            
            echo json_encode(['role' => $user['role']]);
            exit();
        } else {
            echo json_encode(['error' => 'Invalid password.']);
        }
    } else {
        echo json_encode(['error' => 'No user found with that username.']);
    }

    
    $conn->close();
}
