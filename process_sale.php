<?php
// Start session to store success message
session_start();

// Include database connection
include 'db.php'; // Ensure this contains your DB connection

// Get POST data from the form
$artwork_id = $_POST['artwork_id'];
$user_id = $_POST['user_id'];
$sale_price = $_POST['sale_price'];
$payment_method = $_POST['payment_method'];

// Validate inputs
if (empty($artwork_id) || empty($user_id) || empty($sale_price) || empty($payment_method)) {
    die('Please fill in all fields.');
}

// Validate that sale_price is a number
if (!is_numeric($sale_price)) {
    die('Invalid sale price.');
}

// Prepare and execute the SQL query
$query = "INSERT INTO sales (artwork_id, user_id, sale_price, payment_method) 
          VALUES (?, ?, ?, ?)";

$stmt = $conn->prepare($query);
$stmt->bind_param("iiss", $artwork_id, $user_id, $sale_price, $payment_method);

if ($stmt->execute()) {
    // Set session variable for success message
    $_SESSION['sale_success'] = true;
} else {
    // Set session variable for error message
    $_SESSION['sale_error'] = 'Error processing sale: ' . $stmt->error;
}

// Close the statement and connection
$stmt->close();
$conn->close();

// Redirect back to index.php
header("Location: index.php#gallery");
exit();
?>

