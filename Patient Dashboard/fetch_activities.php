<?php
session_start();
//weli0007
include 'db_connect.php'; 


if (!isset($_SESSION['user_id'])) {
    echo "<tr><td colspan='3'>User not logged in.</td></tr>";
    exit();
}

$user_id = $_SESSION['user_id'];


$sql_past = "SELECT * FROM activity_log WHERE user_id = ? ORDER BY activity_date DESC, activity_time DESC";
$stmt_past = $conn->prepare($sql_past);
$stmt_past->bind_param("i", $user_id);
$stmt_past->execute();
$result_past = $stmt_past->get_result();


if ($result_past->num_rows > 0) {
    
    while ($row = $result_past->fetch_assoc()) {
        echo "<tr data-activity-type='" . htmlspecialchars($row['activity_type']) . "' data-activity-date='" . htmlspecialchars($row['activity_date']) . "' data-activity-time='" . htmlspecialchars($row['activity_time']) . "'>";
        echo "<td>" . htmlspecialchars($row['activity_type']) . "</td>";
        echo "<td>" . htmlspecialchars($row['activity_date']) . "</td>";
        echo "<td>" . htmlspecialchars($row['activity_time']) . "</td>";
        echo "</tr>";
    }
} else {
    echo "<tr><td colspan='3'>No past activities found</td></tr>";
}


$stmt_past->close();
$conn->close();
?>
