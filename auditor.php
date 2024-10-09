<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Auditor Summary</title>
    <link rel="stylesheet" href="css/auditor.css"> 
</head>
<body>

    <div class="container"> 
        <header class="page-header">
            <h1 class="page-title">Therapist Work Summary</h1>
        </header>

        <section class="summary-section">
            <table class="summary-table">
                <thead>
                    <tr>
                        <th>Therapist Name</th>
                        <th>Number of Patients</th>
                        <th>Types of Cases</th>
                        <th>Number of Sessions</th>
                        <th>Average Session Length</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    //Fetch summary data
                    $conn = new mysqli("localhost", "root", "", "care_db");

                    if ($conn->connect_error) {
                        die("Connection failed: " . $conn->connect_error);
                    }

                    $sql = "SELECT users.name AS therapist_name, COUNT(group_patients.patient_id) AS num_patients, 
                                    GROUP_CONCAT(DISTINCT groups.group_name) AS case_types 
                                    -- Awaits num_sessions & avg session length implementation
                            FROM users
                            JOIN groups ON users.id = groups.therapist_id
                            JOIN group_patients ON groups.id = group_patients.group_id
                            WHERE users.role = 'therapist'
                            GROUP BY users.id";

                    $result = $conn->query($sql);


                    if ($result->num_rows > 0) {
                        while($row = $result->fetch_assoc()) {
                            echo "<tr>";
                            echo "<td>" . $row['therapist_name'] . "</td>";
                            echo "<td>" . $row['num_patients'] . "</td>";
                            echo "<td>" . $row['case_types'] . "</td>";
                            // echo "<td>" . $row['num_sessions'] . "</td>";
                            // echo "<td>" . $row['avg_session_length'] . " mins</td>";
                            echo "</tr>";
                        }
                    } else {
                        echo "<tr><td colspan='5'>No data found</td></tr>";
                    }

                    $conn->close();
                    ?>
                </tbody>
            </table>
        </section>
    </div>

</body>
</html>
