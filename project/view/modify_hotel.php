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

function sanitizeData($data) {
    return htmlspecialchars(strip_tags($data));
}

if (isset($_POST['edit'])) {
    $hotel_id = sanitizeData($_POST['hotel_id']);
    $name = sanitizeData($_POST['name']);
    $address = sanitizeData($_POST['address']);
    $prize = sanitizeData($_POST['prize']);
    $phone = sanitizeData($_POST['phone']);

    $sql = "UPDATE hotel_info SET name='$name', address='$address', prize='$prize', phone='$phone' WHERE hotel_id=$hotel_id";

    if (mysqli_query($conn, $sql)) {
        echo "Record updated successfully";
    } else {
        echo "Error updating record: " . mysqli_error($conn);
    }
}

if (isset($_POST['delete'])) {
    $hotel_id = sanitizeData($_POST['hotel_id']);

    $sql = "DELETE FROM hotel_info WHERE hotel_id=$hotel_id";

    if (mysqli_query($conn, $sql)) {
        echo "Record deleted successfully";
    } else {
        echo "Error deleting record: " . mysqli_error($conn);
    }
}

$sql = "SELECT * FROM hotel_info";
$result = mysqli_query($conn, $sql);

if (mysqli_num_rows($result) > 0) {
    echo "<table border='1'>";
    echo "<tr><th>ID</th><th>Name</th><th>Address</th><th>Prize</th><th>Phone</th><th>Action</th></tr>";

    while ($row = mysqli_fetch_assoc($result)) {
        echo "<form method='post'>";
        echo "<input type='hidden' name='hotel_id' value='{$row['hotel_id']}'>";
        echo "<tr>";
        echo "<td>{$row['hotel_id']}</td>";
        echo "<td><input type='text' name='name' value='{$row['name']}'></td>";
        echo "<td><input type='text' name='address' value='{$row['address']}'></td>";
        echo "<td><input type='text' name='prize' value='{$row['prize']}'></td>";
        echo "<td><input type='text' name='phone' value='{$row['phone']}'></td>";
        echo "<td><button type='submit' name='edit'>Update</button> <button type='submit' name='delete'>Delete</button></td>";
        echo "</tr>";
        echo "</form>";
    }

    echo "</table>";
} else {
    echo "0 results found";
}

mysqli_close($conn);
?>
