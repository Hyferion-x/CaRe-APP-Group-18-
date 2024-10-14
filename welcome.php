<?php
session_start();
//weli0007

if (!isset($_SESSION['username'])) {
    header('Location: login.html'); 
    exit();
}

// Get user information from session
$username = $_SESSION['username'];
$name = $_SESSION['name'];
$photo = $_SESSION['photo'];
$role = $_SESSION['role'];

// Redirect based on user role
switch ($role) {
    case 'patient':
        header('Location: patient-dashboard.html');
        exit();
    case 'therapist':
        header('Location: therapist-dashboard.html');
        exit();
    case 'staff':
        header('Location: staff-dashboard.html');
        exit();
    case 'auditor':
        header('Location: auditor-dashboard.html');
        exit();
    default:
        echo "Invalid user role.";
        exit();
}
?>
