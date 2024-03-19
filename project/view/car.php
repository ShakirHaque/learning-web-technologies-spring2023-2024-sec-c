<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Car Information</title>
</head>
<body>

    <h2>Car Information</h2>

    <form action="<?php echo $_SERVER['PHP_SELF']; ?>" method="get">
        <label for="locationSelect">Select Start Place:</label>
        <select id="locationSelect" name="search">
            <option value="">All Places</option>

            <?php
            // Connect to the database
            $conn = mysqli_connect('localhost', 'root', '', 'webtec_db');

            // Check connection
            if (!$conn) {
                die("Connection failed: " . mysqli_connect_error());
            }

            // Fetch distinct start places from the database
            $sql = "SELECT DISTINCT start_place FROM vehicle_info";
            $result = mysqli_query($conn, $sql);

            // Display options in the dropdown
            while ($row = mysqli_fetch_assoc($result)) {
                $start_place = $row['start_place'];
                echo "<option value='$start_place'>$start_place</option>";
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
        $sql = "SELECT * FROM vehicle_info WHERE start_place LIKE '%$search_query%'";
    } else {
        // Fetch all data from the database if no search query
        $sql = "SELECT * FROM vehicle_info";
    }

    $result = mysqli_query($conn, $sql);

    // Display the table
    echo "<table border='1'>";
    echo "<tr><th>Name</th><th>Total Seat</th><th>Start Place</th><th>End Place</th><th>Time to Start</th><th>Date</th><th>Action</th></tr>";

    if (mysqli_num_rows($result) > 0) {
        // Output data of each row
        while ($row = mysqli_fetch_assoc($result)) {
            echo "<tr>";
            echo "<td>{$row['n_vehicle']}</td>";
            echo "<td>{$row['total_seat']}</td>";
            echo "<td>{$row['start_place']}</td>";
            echo "<td>{$row['end_place']}</td>";
            echo "<td>{$row['time_to_start']}</td>";
            echo "<td>{$row['date']}</td>";
            // Add a "Book" button for each car
            echo "<td><a href='book_car.php?id={$row['id']}'>Book</a></td>";
            echo "</tr>";
        }
    } else {
        echo "<tr><td colspan='7'>No cars found</td></tr>";
    }

    echo "</table>";

    // Close the connection
    mysqli_close($conn);
    ?>

</body>
</html>
