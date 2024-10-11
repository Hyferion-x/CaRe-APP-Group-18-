<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Groups Summary</title>
    <link rel="stylesheet" href="css/auditor.css">
</head>
<body>

    <nav>
        <ul>
            <li><a href="auditor_dashboard.php">Dashboard</a></li>
            <li><a href="auditor.php">Therapists</a></li>
            <li><a href="auditor_cases.php"  class="active">Groups</a></li>
            <li style="float:right"><a href="logout.php">Logout</a></li>
        </ul>
    </nav>


    <div class="container"> 
        <header class="page-header">
            <h1 class="page-title">Groups Summary</h1>
        </header>
        
        <section class="summary-section">
            <table class="summary-table">
                <thead>
                    <tr>
                        <th>Group</th>
                        <th>Number of Patients</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    
                    $conn = new mysqli("localhost", "root", "", "care_db");

                    if ($conn->connect_error) {
                        die("Connection failed: " . $conn->connect_error);
                    }

                    $sql = "SELECT groups.group_name AS group_type, COUNT(group_patients.patient_id) AS num_patients
                            FROM groups
                            JOIN group_patients ON groups.id = group_patients.group_id
                            GROUP BY groups.group_name";

                    $result = $conn->query($sql);

                    if ($result->num_rows > 0) {
                        while($row = $result->fetch_assoc()) {
                            echo "<tr>";
                            echo "<td>" . $row['group_type'] . "</td>";
                            echo "<td>" . $row['num_patients'] . "</td>";
                            echo "</tr>";
                        }
                    } else {
                        echo "<tr><td colspan='2'>No data found</td></tr>";
                    }

                    $conn->close();
                    ?>
                </tbody>
            </table>
        </section>
    </div>

</body>
</html>
