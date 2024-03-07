<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Book Hotel</title>
</head>
<body>

    <h2>Book Hotel</h2>

    <?php
    // Connect to the database
    $conn = mysqli_connect('localhost', 'root', '', 'webtec_db');

    // Check connection
    if (!$conn) {
        die("Connection failed: " . mysqli_connect_error());
    }

    // Handle hotel ID parameter
    if (isset($_GET['hotel_id'])) {
        $hotel_id = $_GET['hotel_id'];

        // Fetch hotel details from the database
        $sql = "SELECT name, address, prize FROM hotel_info WHERE hotel_id = $hotel_id";
        $result = mysqli_query($conn, $sql);

        if (mysqli_num_rows($result) > 0) {
            $row = mysqli_fetch_assoc($result);
            echo "<p>Name: {$row['name']}</p>";
            echo "<p>Location: {$row['address']}</p>";
            echo "<p>Rent: {$row['prize']}</p>";

            // Form for additional details
            echo "<form action='' method='post'>";
            echo "<label for='numDays'>Number of Days:</label>";
            echo "<input type='number' name='numDays' id='numDays' value='1' min='1'><br>";

            echo "<label for='numMembers'>Number of Members:</label>";
            echo "<input type='number' name='numMembers' id='numMembers' value='1' min='1'><br>";

            // Include hidden fields for hotel ID and other necessary data
            echo "<input type='hidden' name='hotel_id' value='$hotel_id'>";
            echo "<input type='hidden' name='hotel_name' value='{$row['name']}'>";
            echo "<input type='hidden' name='hotel_address' value='{$row['address']}'>";
            echo "<input type='hidden' name='hotel_prize' value='{$row['prize']}'>";

            // Submit the form
            echo "<input type='submit' name='showTotal' value='Show Total'>";

            // Handle form submission
            if (isset($_POST['showTotal'])) {
                $numDays = isset($_POST['numDays']) ? $_POST['numDays'] : 1;
                $numMembers = isset($_POST['numMembers']) ? $_POST['numMembers'] : 1;
                $total = $numDays * $numMembers * $row['prize'];

                echo "<p>Total: $" . number_format($total, 2) . "</p>";
                
                // Display the "Add to Cart" button after showing the total
                echo "<input type='submit' name='submit' value='Add to Cart'>";
            }

            echo "</form>";

            if (isset($_POST['submit'])) {
                // Handle adding to cart here
                // You may redirect to a cart page or perform other actions
                echo "<p>Added to Cart</p>";
            }
        } else {
            echo "<p>Hotel not found</p>";
        }
    } else {
        echo "<p>No hotel selected</p>";
    }

    // Close the connection
    mysqli_close($conn);
    ?>

</body>
</html>
