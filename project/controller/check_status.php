<?php
session_start();
require_once('../modul/db.php');
if (!isset($_SESSION['user_id']) || $_SESSION['username'] !== 'admin') {
    header("Location: login.html");
    exit;
}

$conn = dbConnect();

if (!$conn) {
    die("Connection failed: " . mysqli_connect_error());
}

if(isset($_POST['update_status'])) {
    foreach($_POST['payment_id'] as $key => $payment_id) {
        $status = $_POST['status'][$key];
        $update_sql = "UPDATE payments SET status='$status' WHERE id='$payment_id'";
        mysqli_query($conn, $update_sql);
    }
    header("Refresh:0");
}

if(isset($_POST['delete_payment'])) {
    foreach($_POST['payment_id'] as $key => $payment_id) {
        $delete_sql = "DELETE FROM payments WHERE id='$payment_id'";
        mysqli_query($conn, $delete_sql);
    }
    header("Refresh:0");
}

$sql = "SELECT * FROM payments";
$result = mysqli_query($conn, $sql);

echo "<h1>Payment Details</h1>";
echo "<form action='' method='post'>";
echo "<table border='1'>";
echo "<tr><th>ID</th><th>User_ID</th>";
if ($_SESSION['username'] === 'admin') {
    echo "<th>Phone</th>";
}
echo "<th>Transation Id</th><th>Total</th><th>Status</th><th>Action</th></tr>";
while ($row = mysqli_fetch_assoc($result)) {
    echo "<tr>";
    echo "<td>{$row['id']}</td>";
    echo "<td>{$row['user_id']}</td>";
    if ($_SESSION['username'] === 'admin') {
        echo "<td>{$row['phone']}</td>";
    }
    echo "<td>{$row['otp']}</td>";
    echo "<td>{$row['total']}</td>";
    echo "<td>{$row['status']}</td>";
    echo "<td>";
    echo "<select name='status[]'>";
    echo "<option value='processing' ".($row['status'] == 'processing' ? 'selected' : '').">Processing</option>";
    echo "<option value='accepted' ".($row['status'] == 'accepted' ? 'selected' : '').">Accepted</option>";
    echo "<option value='rejected' ".($row['status'] == 'rejected' ? 'selected' : '').">Rejected</option>";
    echo "</select>";
    echo "<input type='hidden' name='payment_id[]' value='{$row['id']}'>";
    echo "<button type='submit' name='delete_payment' value='{$row['id']}'>Delete</button>";
    echo "</td>";
    echo "</tr>";
}
echo "</table>";
echo "<br>";
echo "<input type='submit' name='update_status' value='Update Status'>";
echo "</form>";

mysqli_close($conn);
?>
