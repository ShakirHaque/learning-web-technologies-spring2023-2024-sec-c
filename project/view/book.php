<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Hotel Booking</title>
</head>
<body style="display: flex; justify-content: center; align-items: center; height: 100vh;">
    <fieldset style="width: 500px; padding: 20px;">
        <legend style="text-align: center;"><h2>Hotel Booking</h2></legend>

        <?php
        session_start();
        require_once('../modul/db.php');

        if (!isset($_SESSION['user_id'])) {
            header("Location: login.php");
            exit;
        }

        $user_id = $_SESSION['user_id'];
        $conn = dbConnect();

        if (!$conn) {
            die("Connection failed: " . mysqli_connect_error());
        }

        if (isset($_GET['hotel_id'])) {
            $hotel_id = $_GET['hotel_id'];

            $check_sql = "SELECT COUNT(*) as count FROM cart WHERE user_id = $user_id AND hotel_id = $hotel_id";
            $check_result = mysqli_query($conn, $check_sql);
            $check_row = mysqli_fetch_assoc($check_result);
            if ($check_row['count'] > 0) {
                echo "<p>This hotel is already selected in your cart.</p>";
            } else {
                $sql = "SELECT name, address, prize FROM hotel_info WHERE hotel_id = $hotel_id";
                $result = mysqli_query($conn, $sql);

                if (mysqli_num_rows($result) > 0) {
                    $row = mysqli_fetch_assoc($result);
                    echo "<p>Name:{$row['name']}</p>";
                    echo "<p>Location: {$row['address']}</p>";
                    echo "<p>Rent: {$row['prize']}</p>";

                    echo "<form action='' method='post'>";
                    echo "<label for='numDays'>Number of Days:</label>";
                    echo "<input type='number' name='numDays' id='numDays' value='1' min='1'><br>";
                    echo "<label for='numMembers'>Number of Members:</label>";
                    echo "<input type='number' name='numMembers' id='numMembers' value='1' min='1'><br>";

                    echo "<input type='hidden' name='hotel_id' value='$hotel_id'>";
                    echo "<input type='hidden' name='hotel_name' value='{$row['name']}'>";
                    echo "<input type='hidden' name='hotel_address' value='{$row['address']}'>";
                    echo "<input type='hidden' name='hotel_prize' value='{$row['prize']}'>";

                    echo "<input type='submit' name='calculateTotal' value='See Total'>";
                    echo "</form>";
                } else {
                    echo "<p>Hotel not found</p>";
                }
            }
        }

        if (isset($_POST['calculateTotal'])) {
            $numDays = $_POST['numDays'];
            $numMembers = $_POST['numMembers'];
            $hotelPrize = $_POST['hotel_prize'];
            $total_price = $numDays * $numMembers * $hotelPrize;
            echo "<p>Total Price: $total_price</p>";
            echo "<form action='' method='post'>";
            echo "<input type='hidden' name='hotel_id' value='{$_POST['hotel_id']}'>";
            echo "<input type='hidden' name='hotel_name' value='{$_POST['hotel_name']}'>";
            echo "<input type='hidden' name='hotel_address' value='{$_POST['hotel_address']}'>";
            echo "<input type='hidden' name='hotel_prize' value='{$_POST['hotel_prize']}'>";
            echo "<input type='hidden' name='numDays' value='$numDays'>";
            echo "<input type='hidden' name='numMembers' value='$numMembers'>";
            echo "<input type='submit' name='addToCart' value='Add to Cart'>";
            echo "</form>";
        }

        if (isset($_POST['addToCart'])) {
            $hotel_id = $_POST['hotel_id'];
            $hotel_name = $_POST['hotel_name'];
            $hotel_address = $_POST['hotel_address'];
            $numDays = $_POST['numDays'];
            $numMembers = $_POST['numMembers'];
            $total_price = $_POST['hotel_prize'] * $_POST['numDays'] * $_POST['numMembers'];

            $insert_sql = "INSERT INTO cart (user_id, hotel_id, hotel_name, hotel_address, numDays, numMembers, total_price)
                           VALUES ('$user_id', '$hotel_id', '$hotel_name', '$hotel_address', '$numDays', '$numMembers', '$total_price')";
            if (mysqli_query($conn, $insert_sql)) {
                echo "<p>Added to Cart</p>";
            } else {
                echo "Error: " . $insert_sql . "<br>" . mysqli_error($conn);
            }
        }

        mysqli_close($conn);
        ?>

        <a href="cart.php">Go to Cart</a>
    </fieldset>
</body>
</html>
