<?php
include 'db.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $name = $_POST['name'];
    $phone = $_POST['phone'];
    $email = $_POST['email'];
    $message = $_POST['message'];

    $sql = "INSERT INTO contact_form (name, phone, email, message) VALUES ('$name', '$phone', '$email', '$message')";

    header('Content-Type: application/json');
    
    if ($conn->query($sql) === TRUE) {
        echo json_encode(["success" => true, "message" => "Message sent successfully!"]);
    } else {
        echo json_encode(["success" => false, "message" => "Error: " . $sql . "<br>" . $conn->error]);
    }

    $conn->close();
}
?>
