<?php
// Start session
session_start();

// Check if user is logged in
if (!isset($_SESSION['loggedin']) || $_SESSION['loggedin'] !== true) {
    // Redirect user to login page if not logged in
    header("Location: login.php");
    exit;
}

// If user is logged in, welcome them
$username = $_SESSION['username'];
?>

<!DOCTYPE html>
<html>
<head>
    <title>Dashboard</title>
</head>
<body>
    <h1>Welcome, <?php echo $username; ?>!</h1>
    <p>This is your dashboard. You are logged in.</p>
    <a href="../controller/check_status.php">Status</a></br>
    <a href="add_hotel.html">Add Hotel</a><br>
    <a href="modify_hotel.php">update Hotel Details </a><br>
</body>
</html>
