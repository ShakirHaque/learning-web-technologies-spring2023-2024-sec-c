<?php
session_start();
require_once('../modul/db.php');

if (!isset($_SESSION['user_id'])) {
    header("Location: login.html");
    exit;
}

$conn = dbConnect();

if (!$conn) {
    die("Connection failed: " . mysqli_connect_error());
}

$user_id = $_SESSION['user_id'];
$sql = "SELECT * FROM cart WHERE user_id = $user_id";
$result = mysqli_query($conn, $sql);

$total = 0;

if (mysqli_num_rows($result) > 0) {
    echo "<fieldset style='width: 800px; padding: 20px;'>";
    echo "<legend><h2>Your Cart</h2></legend>";
    echo "<table border='1' cellspacing='0' cellpadding='10'>";
    echo "<tr><th>Hotel Name</th><th>Address</th><th>Number of Days</th><th>Number of Members</th><th>Total Price</th><th>Action</th></tr>";

    while ($row = mysqli_fetch_assoc($result)) {
        echo "<tr>";
        echo "<td>{$row['hotel_name']}</td>";
        echo "<td>{$row['hotel_address']}</td>";
        echo "<td>{$row['numDays']}</td>";
        echo "<td>{$row['numMembers']}</td>";
        echo "<td>{$row['total_price']}</td>";
        echo "<td><form action='' method='post'><input type='hidden' name='item_id' value='{$row['id']}'><input type='submit' name='remove' value='Remove'></form></td>";
        echo "</tr>";
        
        $total += $row['total_price'];
    }

    echo "</table>";
    echo "<p>Your total price is: $total</p>";

    echo "<form action='' method='post'>";
    echo "<label for='promo_code'>Enter Promo Code:</label>";
    echo "<input type='text' name='promo_code' id='promo_code'>";
    echo "<input type='submit' name='apply_promo' value='Apply Promo Code'>";
    echo "</form>";
    
    if (isset($_POST['apply_promo'])) {
        $promo_code = $_POST['promo_code'];
        
        $promo_query = "SELECT * FROM promo_code WHERE name = '$promo_code'";
        $promo_result = mysqli_query($conn, $promo_query);
        
        if (mysqli_num_rows($promo_result) > 0) {
            $promo_row = mysqli_fetch_assoc($promo_result);
            $discount = $promo_row['code'];
            $total -= $discount;
            echo "<p>Applied promo code: $promo_code. Discount: $discount. Updated total: $total</p>";
            
            $_SESSION['promo_code'] = $promo_code;
        } else {
            echo "<p>Invalid promo code.</p>";
        }
    }
    
    echo "</fieldset>";
} else {
    echo "<p>Your cart is empty.</p>";
}

if (isset($_POST['remove'])) {
    $item_id = $_POST['item_id'];
    $delete_sql = "DELETE FROM cart WHERE id = $item_id";
    if (mysqli_query($conn, $delete_sql)) {
        echo "<p>Item removed from cart.</p>";
        header("Location: cart.php");
        exit;
    } else {
        echo "Error removing item: " . mysqli_error($conn);
    }
}

mysqli_close($conn);
?>

<br>
<a href="book_hotel.php">Back to Booking Page</a>

<form action="payment.php" method="post">
    <input type="hidden" name="total" value="<?php echo $total; ?>">
    <input type="submit" name="make_payment" value="Make Payment">
</form>
