<?php
session_start();

if (!isset($_SESSION["user_id"])) {
    header("Location: login.php");
    exit();
}

require_once __DIR__ . '/config.php';
$conn = db_connect();

$user_id = $_SESSION["user_id"];
$customer_name = $conn->real_escape_string($_SESSION["name"] ?? '');
$phone = $conn->real_escape_string($_POST["phone"] ?? '');
$address = $conn->real_escape_string($_POST["address"] ?? '');
$payment_method = $conn->real_escape_string($_POST["payment_method"] ?? 'Cash');
$cart = $_SESSION["cart"] ?? [];

$payment_status = ($payment_method == "Cash") ? "Unpaid" : "Paid";

$success = false;

if (!empty($cart) && !empty($phone) && !empty($address)) {
    $order_group_time = date("Y-m-d H:i:s");

    foreach ($cart as $product_id => $qty) {
        $sql = "INSERT INTO orders (user_id, customer_name, product_id, quantity, phone, delivery_address, order_status, payment_method, payment_status, created_at)
                VALUES ('$user_id', '$customer_name', '$product_id', '$qty', '$phone', '$address', 'Pending', '$payment_method', '$payment_status', '$order_group_time')";

        $conn->query($sql);
    }

    unset($_SESSION["cart"]);
    $success = true;
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Order Status - Zens Qohwah</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>

<?php include("header.php"); ?>

<main class="content">
    
    <?php if ($success) { ?>
        <h2 class="clean-title">Success!</h2>
        <div class="contact-box center-box">
            <p class="mb-15">Your order has been placed successfully!</p>
            
            <div class="pill-box mb-15">
                <p><strong>Payment:</strong> <?php echo $payment_method; ?></p>
                <p><strong>Status:</strong> <span class="status-paid"><?php echo $payment_status; ?></span></p>
                <p><strong>Phone:</strong> <?php echo $phone; ?></p>
            </div>

            <p>Our team is now preparing your items. You can track your order in the dashboard.</p>
            <br>
            <a href="dashboard.php" class="btn">View My Orders</a>
        </div>
    <?php } else { ?>
        <h2 class="clean-title">Error</h2>
        <div class="contact-box center-box">
            <p>Something went wrong. Your cart might be empty or required information is missing.</p>
            <br>
            <a href="menu.php" class="btn">Back to Menu</a>
        </div>
    <?php } ?>

</main>

<?php include("footer.php"); ?>

</body>
</html>