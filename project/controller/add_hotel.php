<?php
session_start();
require_once('../modul/db.php');

function isValidInput($input) {
    return isset($input) && !empty($input);
}

function isValidPositiveNumber($number) {
    return isset($number) && !empty($number) && is_numeric($number) && $number > 0;
}

if (!isset($_SESSION['user_id']) || $_SESSION['username'] !== 'admin') {
    header("Location: ../index.html");
    exit;
}

$conn = dbConnect();

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $name = $_POST['name'];
    $address = $_POST['address'];
    $prize = $_POST['prize'];
    $phone = $_POST['phone'];

    // Validate input
    if (!isValidInput($name) || !isValidInput($address) || !isValidPositiveNumber($prize) || !isValidInput($phone)) {
        echo "Please fill in all fields and ensure prize is a positive number.";
    } else {
        $sql = "INSERT INTO hotel_info (name, address, prize, phone) VALUES (?, ?, ?, ?)";
        $stmt = mysqli_prepare($conn, $sql);
        mysqli_stmt_bind_param($stmt, "ssis", $name, $address, $prize, $phone);
        mysqli_stmt_execute($stmt);

        if (mysqli_stmt_affected_rows($stmt) > 0) {
            echo "Hotel added successfully";
        } else {
            echo "Error adding hotel: " . mysqli_error($conn);
        }

        mysqli_stmt_close($stmt);
    }
}

mysqli_close($conn);
?>
