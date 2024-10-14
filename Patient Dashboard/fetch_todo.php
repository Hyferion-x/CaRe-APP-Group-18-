<?php
session_start();
//weli0007
include 'db_connect.php';


$patient_id = $_SESSION['patient_id'];


$sql = "SELECT * FROM todo_list WHERE patient_id = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $patient_id);
$stmt->execute();
$result = $stmt->get_result();

$stmt->close();
?>

<h3>To-Do List</h3>
<ul>
    <?php while ($row = $result->fetch_assoc()) { ?>
        <li><?= $row['note'] ?> - Added on <?= $row['note_date'] ?></li>
    <?php } ?>
</ul>
