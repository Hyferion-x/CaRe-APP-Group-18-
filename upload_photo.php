<?php
session_start();
//weli0007
include 'db_connect.php'; 

// Check if the file was uploaded
if (isset($_FILES['photo']) && isset($_POST['user_id'])) {
    $user_id = intval($_POST['user_id']); 

    
    $target_dir = "uploads/"; 
    $target_file = $target_dir . basename($_FILES["photo"]["name"]);
    $uploadOk = 1;
    $imageFileType = strtolower(pathinfo($target_file, PATHINFO_EXTENSION));

    // Check if image file is an actual image
    $check = getimagesize($_FILES["photo"]["tmp_name"]);
    if ($check !== false) {
        $uploadOk = 1;
    } else {
        echo "File is not an image.";
        $uploadOk = 0;
    }

    
    if ($_FILES["photo"]["size"] > 500000) { 
        echo "Sorry, your file is too large.";
        $uploadOk = 0;
    }

    
    if ($imageFileType != "jpg" && $imageFileType != "png" && $imageFileType != "jpeg") {
        echo "Sorry, only JPG, JPEG, & PNG files are allowed.";
        $uploadOk = 0;
    }

    
    if ($uploadOk == 1) {
        if (move_uploaded_file($_FILES["photo"]["tmp_name"], $target_file)) {
            // Update the database with the image path
            $query = "UPDATE users SET photo = ? WHERE id = ?";
            $stmt = $conn->prepare($query);
            $stmt->bind_param('si', $target_file, $user_id); 
            if ($stmt->execute()) {
                echo "The file " . basename($_FILES["photo"]["name"]) . " has been uploaded.";
            } else {
                echo "Sorry, there was an error updating your profile.";
            }
            $stmt->close();
        } else {
            echo "Sorry, there was an error uploading your file.";
        }
    }
} else {
    echo "No file or user ID provided.";
}

$conn->close();
?>
