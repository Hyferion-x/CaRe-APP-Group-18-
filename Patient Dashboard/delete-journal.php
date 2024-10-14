<?php
session_start();
//weli0007
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    
    $conn = new mysqli('localhost', 'root', '', 'care_db');

    
    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }

    
    if (!isset($_SESSION['user_id'])) {
        echo "Error: User ID not set in session. Please log in again.";
        exit();
    }

    
    $user_id = $_SESSION['user_id'];
    $entry_id = $conn->real_escape_string($_POST['id']);

    
    $sql = "DELETE FROM journal_entries WHERE id = '$entry_id' AND user_id = '$user_id'";

    if ($conn->query($sql) === TRUE) {
        echo "success";
    } else {
        echo "Error: " . $sql . "<br>" . $conn->error;
    }

    
    $conn->close();
}
?>
