<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Hotel Information</title>
</head>
<body style="display: flex; justify-content: center; align-items: center; height: 100vh;">

    <fieldset style="width: 300px; padding: 20px;">
        <legend ><h2>Choose Your Hotel</h2></legend>
        

        <form action="<?php echo $_SERVER['PHP_SELF']; ?>" method="get">
            <label for="locationSelect">Select Location:</label>
            <select id="locationSelect" name="search">
                <option value="">All Locations</option>

                <?php
                $conn = mysqli_connect('localhost', 'root', '', 'webtec_db');

                if (!$conn) {
                    die("Connection failed: " . mysqli_connect_error());
                }

                $sql = "SELECT DISTINCT address FROM hotel_info";
                $result = mysqli_query($conn, $sql);

                while ($row = mysqli_fetch_assoc($result)) {
                    $location = $row['address'];
                    echo "<option value='$location'>$location</option>";
                }

                
                mysqli_close($conn);
                ?>
            </select>

            <input type="submit" value="Search">
        </form>

        <?php
       
        $conn = mysqli_connect('localhost', 'root', '', 'webtec_db');

     
        if (!$conn) {
            die("Connection failed: " . mysqli_connect_error());
        }

       
        $search_query = '';
        if (isset($_GET['search'])) {
            $search_query = $_GET['search'];
            $sql = "SELECT hotel_id, name, address, prize, phone FROM hotel_info WHERE address LIKE '%$search_query%'";
        } else {
            
            $sql = "SELECT hotel_id, name, address, prize, phone FROM hotel_info";
        }

        $result = mysqli_query($conn, $sql);

     
        echo "<table border='1' cellspacing='0' cellpadding='10'>";
        echo "<tr><th>Name</th><th>Location</th><th>Rent</th><th>Phone</th><th>Book</th></tr>";

        if (mysqli_num_rows($result) > 0) {
       
            while ($row = mysqli_fetch_assoc($result)) {
                echo "<tr>";
                echo "<td>{$row['name']}</td>";
                echo "<td>{$row['address']}</td>";
                echo "<td>{$row['prize']}</td>";
                echo "<td>{$row['phone']}</td>";
              
                echo "<td><a href='book.php?hotel_id={$row['hotel_id']}'>Book</a></td>";
                echo "</tr>";
            }
        } else {
            echo "<tr><td colspan='5'>No hotels found</td></tr>";
        }

        echo "</table>";

      
        mysqli_close($conn);
        ?>
    </fieldset>

</body>
</html>
