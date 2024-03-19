<?php
session_start();

// Function to establish database connection
function connectToDatabase() {
    $conn = mysqli_connect('localhost', 'root', '', 'webtec_db');

    // Check connection
    if (!$conn) {
        die("Connection failed: " . mysqli_connect_error());
    }

    return $conn;
}

// Function to remove items from cart
function removeFromCart($user_id, $conn) {
    // Prepare and execute SQL query to delete items from cart for the user
    $delete_sql = "DELETE FROM cart WHERE user_id = ?";
    $stmt = mysqli_prepare($conn, $delete_sql);
    mysqli_stmt_bind_param($stmt, "i", $user_id);
    mysqli_stmt_execute($stmt);
    mysqli_stmt_close($stmt);
}

// Check if user is logged in
if (!isset($_SESSION['user_id'])) {
    // Redirect user to login page if not logged in
    header("Location: login.html");
    exit;
}

// Check if form data is received
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Validate and sanitize input data
    $phone = $_POST['phone'];
    $otp = $_POST['otp'];
    $total = $_POST['total'];

    // Additional validation can be added here as per your requirements

    // Establish database connection
    $conn = connectToDatabase();

    // Get user ID from session
    $user_id = $_SESSION['user_id'];

    // Prepare and execute SQL query to insert payment details into the database
    $sql = "INSERT INTO payments (user_id, phone, otp, total, status) VALUES (?, ?, ?, ?, 'Pending')";
    $stmt = mysqli_prepare($conn, $sql);
    mysqli_stmt_bind_param($stmt, "isdi", $user_id, $phone, $otp, $total);
    mysqli_stmt_execute($stmt);

    // Check if the payment was successfully inserted
    if (mysqli_stmt_affected_rows($stmt) > 0) {
        // Payment submitted successfully. Remove items from cart.
        removeFromCart($user_id, $conn);
        
        // Redirect to status page
        header("Location: ../view/status.php");
        exit;
    } else {
        // Error occurred while submitting payment
        echo "Error submitting payment: " . mysqli_error($conn);
    }

    // Close statement and database connection
    mysqli_stmt_close($stmt);
    mysqli_close($conn);
} else {
    // If form data is not received through POST method
    echo "Form data not received.";
}
?>
