<?php
// Enable error reporting
error_reporting(E_ALL);
ini_set('display_errors', 1);

// Include database connection
include 'db.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $name = $_POST['name'];
    $email = $_POST['email'];
    $password = password_hash($_POST['password'], PASSWORD_BCRYPT);
    $role = $_POST['role'];
    $biography = isset($_POST['biography']) ? $_POST['biography'] : '';
    $artist_image = '';

    // Handle file upload for artist image
    if ($role == 'artist' && isset($_FILES['artist_image']) && $_FILES['artist_image']['error'] == UPLOAD_ERR_OK) {
        $target_dir = "uploads/";
        $target_file = $target_dir . basename($_FILES["artist_image"]["name"]);
        $imageFileType = strtolower(pathinfo($target_file, PATHINFO_EXTENSION));

        // Check if file is an image
        $check = getimagesize($_FILES["artist_image"]["tmp_name"]);
        if ($check !== false) {
            // Check file size (limit to 5MB)
            if ($_FILES["artist_image"]["size"] > 5000000) {
                echo 'Error: File size exceeds limit.';
                exit();
            }

            // Allow certain file formats
            if ($imageFileType != "jpg" && $imageFileType != "png" && $imageFileType != "jpeg" && $imageFileType != "gif") {
                echo 'Error: Only JPG, JPEG, PNG, and GIF files are allowed.';
                exit();
            }

            // Move file to target directory
            if (move_uploaded_file($_FILES["artist_image"]["tmp_name"], $target_file)) {
                $artist_image = basename($_FILES["artist_image"]["name"]);
            } else {
                echo 'Error: Failed to move uploaded file.';
                exit();
            }
        } else {
            echo 'Error: File is not an image.';
            exit();
        }
    }

    // Prepare the SQL statement
    if ($role == 'artist') {
        $sql = "INSERT INTO users (name, email, password, role, biography, artist_image) VALUES (?, ?, ?, ?, ?, ?)";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("ssssss", $name, $email, $password, $role, $biography, $artist_image);
    } else {
        $sql = "INSERT INTO users (name, email, password, role) VALUES (?, ?, ?, ?)";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("ssss", $name, $email, $password, $role);
    }

    if ($stmt->execute()) {
        // Redirect to front.php with success flag
        header("Location: front.php?status=success");
        exit();
    } else {
        // Display database error
        echo 'Database error: ' . $stmt->error;
        exit();
    }
}
?>
