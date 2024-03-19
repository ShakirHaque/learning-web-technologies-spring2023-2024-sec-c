<?php
session_start();
require_once('../modul/db.php');

if (!isset($_SESSION['user_id'])) {
    header("Location: login.html");
    exit;
}


if (!isset($_POST['total'])) {
    header("Location: cart.php");
    exit;
}

$total = $_POST['total'];

$conn = dbConnect();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Payment</title>
</head>
<body>
    <fieldset style="width: 400px; padding: 20px; margin: auto;">
        <legend><h1>Payment</h1></legend>
        <p>Total Amount: <?php echo $total; ?></p>
        
        <form action="../controller/process_payment.php" method="post">
            <label for="phone">Phone Number:</label><br>
            <input type="text" id="phone" name="phone" required><br>
            <label for="otp">OTP:</label><br>
            <input type="text" id="otp" name="otp" required><br><br>
            <input type="hidden" name="total" value="<?php echo $total; ?>">
            <input type="submit" value="Submit Payment">
        </form>
    </fieldset>
</body>
</html>
