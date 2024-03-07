<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Hotel Information</title>
</head>
<body>

    <h2>Hotel Information</h2>

    <form action="<?php echo $_SERVER['PHP_SELF']; ?>" method="get">
        <label for="locationSelect">Select Location:</label>
        <select id="locationSelect" name="search">
            <option value="">All Locations</option>

            <?php
            // Connect to the database
            $conn = mysqli_connect('localhost', 'root', '', 'webtec_db');

            // Check connection
            if (!$conn) {
                die("Connection failed: " . mysqli_connect_error());
            }

            // Fetch distinct locations from the database
            $sql = "SELECT DISTINCT address FROM hotel_info";
            $result = mysqli_query($conn, $sql);

            // Display options in the dropdown
            while ($row = mysqli_fetch_assoc($result)) {
                $location = $row['address'];
                echo "<option value='$location'>$location</option>";
            }

            // Close the connection
            mysqli_close($conn);
            ?>
        </select>

        <input type="submit" value="Search">
    </form>

    <?php
    // Connect to the database
    $conn = mysqli_connect('localhost', 'root', '', 'webtec_db');

    // Check connection
    if (!$conn) {
        die("Connection failed: " . mysqli_connect_error());
    }

    // Handle search
    $search_query = '';
    if (isset($_GET['search'])) {
        $search_query = $_GET['search'];
        $sql = "SELECT hotel_id, name, address, prize, phone FROM hotel_info WHERE address LIKE '%$search_query%'";
    } else {
        // Fetch all data from the database if no search query
        $sql = "SELECT hotel_id, name, address, prize, phone FROM hotel_info";
    }

    $result = mysqli_query($conn, $sql);

    // Display the table
    echo "<table border='1'>";
    echo "<tr><th>Name</th><th>Location</th><th>Rent</th><th>Phone</th><th>Action</th></tr>";

    if (mysqli_num_rows($result) > 0) {
        // Output data of each row
        while ($row = mysqli_fetch_assoc($result)) {
            echo "<tr>";
            echo "<td>{$row['name']}</td>";
            echo "<td>{$row['address']}</td>";
            echo "<td>{$row['prize']}</td>";
            echo "<td>{$row['phone']}</td>";
            // Add a "Book" button that redirects to the book page with hotel ID as a parameter
            echo "<td><a href='book.php?hotel_id={$row['hotel_id']}'>Book</a></td>";
            echo "</tr>";
        }
    } else {
        echo "<tr><td colspan='5'>No hotels found</td></tr>";
    }

    echo "</table>";

    // Close the connection
    mysqli_close($conn);
    ?>

</body>
</html>
