<?php
session_start();

if (!isset($_SESSION['user_id'])) {
    header("Location: login.html");
    exit;
}

$conn = mysqli_connect('localhost', 'root', '', 'webtec_db');

if (!$conn) {
    die("Connection failed: " . mysqli_connect_error());
}

if ($_FILES['file']['error'] === UPLOAD_ERR_OK) {
    $file_name = $_FILES['file']['name'];
    $file_tmp = $_FILES['file']['tmp_name'];
    $file_size = $_FILES['file']['size'];
    $file_type = $_FILES['file']['type'];

    if (strpos($file_type, 'image') !== false) {
        $upload_dir = '../asset/uploads/';
        $user_dir = $upload_dir . $_SESSION['user_id'] . '/';
        $unique_file_name = uniqid() . '_' . $file_name;
        
        if (move_uploaded_file($file_tmp, $user_dir . $unique_file_name)) {
            $file_path = $user_dir . $unique_file_name;
            $user_id = $_SESSION['user_id'];
            $sql_insert_file = "INSERT INTO user_files (user_id, file_name, file_path) VALUES ('$user_id', '$file_name', '$file_path')";
            if (mysqli_query($conn, $sql_insert_file)) {
                echo "File uploaded successfully.";
            } else {
                echo "Error: " . $sql_insert_file . "<br>" . mysqli_error($conn);
            }
        } else {
            echo "Error uploading file.";
        }
    } else {
        echo "Only image files are allowed.";
    }
} else {
    echo "Error uploading file.";
}

mysqli_close($conn);
?>
