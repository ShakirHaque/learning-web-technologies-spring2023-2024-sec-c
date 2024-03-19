<?php
session_start();

if (!isset($_SESSION['loggedin']) || $_SESSION['loggedin'] !== true) {
    
    header("Location: login.php");
    exit;
}

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
    <a href="book_hotel.php">book Hotel</a></br>
    <a href="cart.php">View Cart</a></br>
    <a href="status.php">Status</a></br>
    <a href="todo_list.php">Your check list</a></br>

</body>
</html>
