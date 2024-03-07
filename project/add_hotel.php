<?php
// Connect to the database
$conn = mysqli_connect('localhost', 'root', '', 'webtec_db');

// Check connection
if (!$conn) {
    die("Connection failed: " . mysqli_connect_error());
}

// Handle form submission
if (isset($_POST['name'], $_POST['address'], $_POST['prize'], $_POST['phone'])) {
    // Get form data
    $name = $_POST['name'];
    $address = $_POST['address'];
    $prize = $_POST['prize'];
    $phone = $_POST['phone'];

    // Insert data into the database
    $sql = "INSERT INTO hotel_info (name, address, prize, phone) VALUES ('$name', '$address', '$prize', '$phone')";

    if (mysqli_query($conn, $sql)) {
        echo "Hotel added successfully";
    } else {
        echo "Error: " . $sql . "<br>" . mysqli_error($conn);
    }
}

// Close the connection
mysqli_close($conn);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Add Hotel</title>
</head>
<body>

    <h2>Add Hotel</h2>

    <form action="<?php echo $_SERVER['PHP_SELF']; ?>" method="post">
        <label for="name">Name:</label>
        <input type="text" id="name" name="name" required><br>

        <label for="address">Address:</label>
        <input type="text" id="address" name="address" required><br>

        <label for="prize">Prize:</label>
        <input type="text" id="prize" name="prize" required><br>

        <!-- Add new input for 'phone' -->
        <label for="phone">Phone:</label>
        <input type="text" id="phone" name="phone" required><br>

        <input type="submit" value="Add Hotel">
    </form>

</body>
</html>
