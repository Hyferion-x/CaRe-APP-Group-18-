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
    $user_id = $_SESSION['user_id']; // Ensure this is set when the user logs in
    $date = $conn->real_escape_string($_POST['date']); // Use the provided date from the form
    $mood = $conn->real_escape_string($_POST['mood']);
    $energy_level = (int)$_POST['energy'];
    $entry = $conn->real_escape_string($_POST['entry']);

    // Insert journal entry into the database
    $sql = "INSERT INTO journal_entries (user_id, date, mood, energy_level, entry) VALUES ('$user_id', '$date', '$mood', '$energy_level', '$entry')";

    if ($conn->query($sql) === TRUE) {
        echo 'success';
    } else {
        echo "Error: " . $sql . "<br>" . $conn->error;
    }

    // Close the connection
    $conn->close();
}
?>
