<?php
// Database connection parameters
$servername = "localhost";
$username = "your_username";
$password = "your_password";
$dbname = "cara_db";

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Function to create a new user
function createUser($username, $email, $password, $name, $photo = null, $role) {
    global $conn;
    $hashed_password = password_hash($password, PASSWORD_DEFAULT);
    
    $sql = "INSERT INTO users (username, email, password, name, photo, role) VALUES (?, ?, ?, ?, ?, ?)";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("ssssss", $username, $email, $hashed_password, $name, $photo, $role);
    
    if ($stmt->execute()) {
        return "New user created successfully";
    } else {
        return "Error: " . $sql . "<br>" . $conn->error;
    }
}

// Function to read user data
function getUser($id) {
    global $conn;
    $sql = "SELECT id, username, email, name, photo, role FROM users WHERE id = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $id);
    $stmt->execute();
    $result = $stmt->get_result();
    
    if ($result->num_rows > 0) {
        return $result->fetch_assoc();
    } else {
        return "No user found with ID: " . $id;
    }
}

// Function to update user data
function updateUser($id, $username, $email, $name, $photo, $role) {
    global $conn;
    $sql = "UPDATE users SET username = ?, email = ?, name = ?, photo = ?, role = ? WHERE id = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("sssssi", $username, $email, $name, $photo, $role, $id);
    
    if ($stmt->execute()) {
        return "User updated successfully";
    } else {
        return "Error updating user: " . $conn->error;
    }
}

// Function to delete a user
function deleteUser($id) {
    global $conn;
    $sql = "DELETE FROM users WHERE id = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $id);
    
    if ($stmt->execute()) {
        return "User deleted successfully";
    } else {
        return "Error deleting user: " . $conn->error;
    }
}

// Close the database connection
$conn->close();
?>