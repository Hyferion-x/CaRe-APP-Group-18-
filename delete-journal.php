<?php
session_start();

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Connect to the database
    $conn = new mysqli('localhost', 'root', '', 'care_db');

    // Check connection
    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }

    // Check if user_id is set in session
    if (!isset($_SESSION['user_id'])) {
        echo "Error: User ID not set in session. Please log in again.";
        exit();
    }

    // Collect form data
    $user_id = $_SESSION['user_id'];
    $entry_id = $conn->real_escape_string($_POST['id']);

    // Delete journal entry from the database
    $sql = "DELETE FROM journal_entries WHERE id = '$entry_id' AND user_id = '$user_id'";

    if ($conn->query($sql) === TRUE) {
        echo "success";
    } else {
        echo "Error: " . $sql . "<br>" . $conn->error;
    }

    // Close the connection
    $conn->close();
}
?>
