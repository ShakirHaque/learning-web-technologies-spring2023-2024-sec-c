<?php
session_start();
require_once('../modul/db.php');
require_once('../modul/statusfunction.php');

if (!isset($_SESSION['user_id'])) {
    header("Location: login.html");
    exit;
}

$user_id = $_SESSION['user_id'];

$conn = dbConnect();

$payments = getPaymentDetails($conn, $user_id);
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Payment Status</title>
</head>
<body>
    <fieldset style="width: 600px; margin: auto;">
        <legend><h1>Payment Status</h1></legend>
        <?php if (!empty($payments)): ?>
            <table border='1' cellspacing='0' cellpadding='10'>
                <tr>
                    <th>ID</th>
                    <th>User ID</th>
                    <th>Phone</th>
                    <th>OTP</th>
                    <th>Total</th>
                    <th>Status</th>
                    <th>Action</th>
                </tr>
                <?php foreach ($payments as $payment): ?>
                    <tr>
                        <td><?php echo $payment['id']; ?></td>
                        <td><?php echo $payment['user_id']; ?></td>
                        <td><?php echo $payment['phone']; ?></td>
                        <td><?php echo $payment['otp']; ?></td>
                        <td><?php echo $payment['total']; ?></td>
                        <td><?php echo $payment['status']; ?></td>
                        <td>
                            <form action="status.php" method="post">
                                <input type="hidden" name="payment_id" value="<?php echo $payment['id']; ?>">
                                <input type="submit" name="delete_payment" value="Delete">
                            </form>
                        </td>
                    </tr>
                <?php endforeach; ?>
            </table>
        <?php else: ?>
            <p>No payment records found.</p>
        <?php endif; ?>

        <?php
        // Process payment deletion
        if (isset($_POST['delete_payment'])) {
            $payment_id = $_POST['payment_id'];
            deletePaymentRecord($conn, $payment_id);
            // Refresh the page to reflect changes
            header("Location: status.php");
            exit;
        }
        ?>
        <p>If your payment is rejected . if you have enough prove , send us your prove </p>
    <a href="upload.html">click Here </a>
    </fieldset>
    
</body>
</html>
