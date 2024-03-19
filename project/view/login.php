<?php
$conn = mysqli_connect('localhost', 'root', '', 'webtec_db');
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Start session
session_start();

// Check if form is submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $username = $_POST['username'];
    $password = $_POST['password'];
    $sql = "SELECT id, username FROM login WHERE username='$username' AND password='$password'";
    $result = $conn->query($sql);

    // Check if user exists
    if ($result->num_rows > 0) {
        // Fetch user data
        $row = $result->fetch_assoc();
        
        // Check if the user ID is "admin"
        if ($row['username'] == 'admin') {
            // Set session variables
            $_SESSION['user_id'] = $row['id']; // Add user id to session
            $_SESSION['username'] = $row['username'];
            $_SESSION['loggedin'] = true;

            // Redirect user to admin dashboard
            header("Location: admin_dashboard.php");
            exit;
        } else {
            // Set session variables for regular user
            $_SESSION['user_id'] = $row['id']; // Add user id to session
            $_SESSION['username'] = $row['username'];
            $_SESSION['loggedin'] = true;

            // Redirect user to regular dashboard or any other page
            header("Location: dashboard.php");
            exit;
        }
    } else {
        echo "Invalid username or password";
    }
}

$conn->close();
?>
