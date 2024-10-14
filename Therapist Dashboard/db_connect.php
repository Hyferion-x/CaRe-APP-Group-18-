<?php
$servername = "localhost"; // or your database server IP
$username = "root"; // your MySQL username
$password = ""; // your MySQL password
$dbname = "care_db"; // your database name

// Create a connection
$conn = new mysqli($servername, $username, $password, $dbname);

// Check the connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}
?>


