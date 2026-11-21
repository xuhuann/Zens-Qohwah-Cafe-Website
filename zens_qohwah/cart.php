<?php
session_start();

if (!isset($_SESSION["user_id"])) {
    header("Location: login.php");
    exit();
}

require_once __DIR__ . '/config.php';
$conn = db_connect();

$cart = $_SESSION["cart"] ?? [];
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Cart - Zens Qohwah</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>

<?php include("header.php"); ?>

<main class="content">
    <h2 class="clean-title">Shopping Cart</h2>

    <div class="cart-layout">
        <div class="cart-left">
            <?php if (empty($cart)) { ?>
                <div class="contact-box center-box">
                    <p>Your cart is empty.</p><br>
                    <a href="menu.php" class="btn">Go to Menu</a>
                </div>
            <?php } else { ?>
                <h3>Order Items</h3>
                
                <?php
                $total = 0;
                foreach ($cart as $product_id => $qty) {
                    $sql = "SELECT name, temperature, price FROM products WHERE product_id='$product_id'";
                    $result = $conn->query($sql);
                    $p = $result->fetch_assoc();

                    $item_total = $p["price"] * $qty;
                    $total += $item_total;
                ?>
                    <div class="order-item">
                        <div>
                            <strong><?php echo $p["name"]; ?></strong>
                            <?php if ($p["temperature"] != NULL) { echo "<small>(" . $p["temperature"] . ")</small>"; } ?>
                            <br>Qty: <?php echo $qty; ?> | RM <?php echo number_format($p["price"], 2); ?>
                        </div>
                        <div class="text-right">
                            <b>RM <?php echo number_format($item_total, 2); ?></b><br>
                            <a href="remove_cart.php?id=<?php echo $product_id; ?>" class="text-xs danger-text">Remove</a>
                        </div>
                    </div>
                <?php } ?>

                <div class="mt-20">
                    <h3>Delivery & Payment Details</h3>
                    <form method="POST" action="check_out.php">
                        <div class="auth-group">
                            <label>Phone Number</label>
                            <input type="text" name="phone" placeholder="e.g. 0123456789" required>
                        </div>

                        <div class="auth-group">
                            <label>Delivery Address</label>
                            <input type="text" name="address" placeholder="Full address for delivery" required>
                        </div>

                        <div class="auth-group">
                            <label>Payment Method</label>
                            <select name="payment_method">
                                <option value="Cash">Cash on Delivery</option>
                                <option value="Online">Online Banking</option>
                            </select>
                        </div>

                        <input type="submit" class="btn btn-full mt-10" value="Place Order Now">
                    </form>
                </div>
            <?php } ?>
        </div>

        <div class="cart-right">
            <h3>Order Summary</h3>
            <div class="mt-20 mb-20">
                <p class="summary-row">
                    <span>Subtotal:</span> 
                    <span>RM <?php echo number_format($total ?? 0, 2); ?></span>
                </p>
                <p class="summary-row mt-10">
                    <span>Shipping:</span> 
                    <span>FREE</span>
                </p>
                <hr class="hr-dark">
                <p class="summary-total">
                    <span>Total:</span> 
                    <span>RM <?php echo number_format($total ?? 0, 2); ?></span>
                </p>
            </div>
            <p class="order-note">Secure Checkout Process</p>
        </div>
    </div>
</main>

<?php include("footer.php"); ?>

</body>
</html>