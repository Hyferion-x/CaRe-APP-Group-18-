<?php
session_start(); 
//weli0007


$conn = new mysqli('localhost', 'root', '', 'care_db');


if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}


$patient_id = $_SESSION['user_id']; 


$sql = "SELECT name, email, mobile, phone, address, gender, birthday, allergies, age, blood_group, insurance_id, bio FROM users WHERE id = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $patient_id);
$stmt->execute();
$result = $stmt->get_result();


if ($result->num_rows > 0) {
    $row = $result->fetch_assoc();
    $name = $row['name'];
    $email = $row['email'];
    $mobile = $row['mobile'];
    $phone = $row['phone'];
    $address = $row['address'];
    $gender = $row['gender'];
    $birthday = $row['birthday'];
    $allergies = $row['allergies'];
    $age = $row['age'];
    $blood_group = $row['blood_group'];
    $insurance_id = $row['insurance_id'];
    $bio = $row['bio'];
} else {
    echo "No user found.";
}


$stmt->close();
$conn->close();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>My Profile</title>
    <link rel="stylesheet" href="../Patient Dashboard/profile.css">
</head>

<body>

    
    <header>
        <div class="contact-icons">
            <a href="#"><img src="images/phone.png" alt="Phone"></a>
            <a href="#"><img src="images/envelope.png" alt="Email"></a>
            <a href="#"><img src="images/facebook.png" alt="Facebook"></a>
        </div>
        <div class="search">
            <input class="srch" type="search" placeholder="Type to text">
            <a href="#"><button class="srch_btn">Search</button></a> 
        </div>
        <div class="nav-right">
            <a href="#">Notifications</a>
            <a href="profile.php">My Account</a>
        </div>
    </header>

    
    <div class="main">
        <div class="navbar">
            <div class="icon">
                <img src="images/logo.jpg" alt="My Logo" class="logo-img">
                <h2 class="logo">CaRe</h2>
            </div>
            <div class="menu">
                <ul>
                    <li><a href="patient-dashboard.html">Home</a></li>
                    <li><a href="journal.html">Journal</a></li>
                    <li><a href="activity.html">Activities</a></li>
                    <li><a href="#">Appointments</a></li>
                    <li><a href="#">History</a></li>
                    <li><a href="profile.php" class="active">Profile</a></li>
                    <li><a href="#">Support</a></li>
                </ul>
            </div>
        </div>

        
        <div class="patient_info">
            <div id="profilePicContainer">
                <img id="profilePic" src="images/profilepic.jpg" alt="Profile Picture">
                <input type="file" id="profilePicInput" style="display:none" accept="image/*">
            </div>

            <h2 id="user_name"><?php echo $name; ?></h2>

            <div class="profile_dropdown">
                <img id="menu_img" src="images/menu.png" class="menu_img" alt="Profile Menu" onclick="toggleMenu()">
                <ul id="dropdownMenu" class="dropdown hidden">
                    <li><a href="#" onclick="openModal()">Edit Profile</a></li>
                    <li><a href="#">Settings</a></li>
                </ul>
            </div>
        </div>

        
        <div class="info-card">
            <h3>Contact Details:</h3>
            <div class="profile_details">
                <p>📱 <?php echo $mobile; ?></p><br>
                <p>📞 <?php echo $phone; ?></p><br>
                <p>📧 <?php echo $email; ?></p><br>
                <p>🏠 <?php echo $address; ?></p>
            </div>
        </div>

        
        <div class="Overview">
            <h3>General Information:</h3>
            <div class="general-info">
                <div class="grid-container"> 
                    <div class="info-row">
                        <div class="info-column">   
                            <p><strong>Gender:</strong> <span id="display-gender"><?php echo $gender; ?></span></p>
                            <p><strong>Birthday:</strong> <span id="display-birthday"><?php echo $birthday; ?></span></p>
                            <p><strong>Allergies:</strong> <span id="display-allergies"><?php echo $allergies; ?></span></p>
                        </div>
                        <div class="info-column"> 
                            <p><strong>Age:</strong> <span id="display-age"><?php echo $age; ?> years old</span></p>
                            <p><strong>Blood Type:</strong> <span id="display-blood"><?php echo $blood_group; ?></span></p>
                            <p><strong>Insurance ID:</strong> <span id="display-insuranceId"><?php echo $insurance_id; ?></span></p>
                        </div>
                        <div class="info-column"> 
                            <p><strong>Bio:</strong> <textarea rows="4" cols="50" readonly><?php echo $bio; ?></textarea></p>
                            <button class="general-info_btn" onclick="openForm('generalInfoForm')">Edit Info</button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    
    <footer>
        <p>&copy; Group 18 - WebX.js Group 2024</p>
    </footer>

    <script src="scripts/profile.js"></script>

</body>
</html>
