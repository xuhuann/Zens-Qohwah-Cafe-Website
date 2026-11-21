<?php
session_start();

if (!isset($_SESSION["user_id"])) {
    header("Location: login.php");
    exit();
}

require_once __DIR__ . '/config.php';
$conn = db_connect();

$is_staff = ($_SESSION["role"] == "staff");

if ($is_staff && $_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['order_ids'])) {
    $ids = implode(",", $_POST['order_ids']);
    $new_status = $_POST['batch_status'];
    $conn->query("UPDATE orders SET order_status = '$new_status' WHERE order_id IN ($ids)");
    header("Location: dashboard.php?msg=updated"); 
    exit();
}

function get_status_color($status) {
    switch ($status) {
        case 'Pending': return '#e67e22';
        case 'Preparing': return '#3498db';
        case 'Ready': return '#2ecc71';
        case 'Completed': return '#7f8c8d';
        default: return '#000';
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Dashboard - Zens Qohwah</title>
    <link rel="stylesheet" href="style.css">
    <style>
        .tab-content { display: none; }
        .active-content { display: block; }
        .tab-btn { background: #555; color: white; padding: 10px 20px; border: none; cursor: pointer; border-radius: 5px; }
        .tab-btn.active { background: #000; }
        .customer-table { width: 100%; border-collapse: collapse; background: #fff; margin-top: 20px; }
        .customer-table th, .customer-table td { padding: 12px; border: 1px solid #eee; text-align: left; }
        .customer-table th { background: #f4f4f4; }
    </style>
</head>
<body>

<?php include("header.php"); ?>

<main class="content">
    <h2 class="clean-title">Dashboard</h2>

    <div class="contact-box flex-between mb-15">
        <div>
            <p class="m-0">Welcome, <strong><?php echo $_SESSION["name"]; ?></strong></p>
            <p class="text-small text-muted">Account Type: <?php echo strtoupper($_SESSION["role"]); ?></p>
        </div>
        <?php if ($is_staff) { ?>
            <div class="flex-gap-10">
                <a href="add_product.php" class="btn">+ Add Product</a>
            </div>
        <?php } ?>
    </div>

    <?php if ($is_staff) { ?>
        <div class="flex-gap-10 mb-15">
            <button class="tab-btn active" onclick="switchTab('orders-section', this)">Orders Management</button>
            <button class="tab-btn" onclick="switchTab('customers-section', this)">Customer Listing</button>
            <button class="tab-btn" onclick="switchTab('feedback-section', this)">Feedbacks</button>
        </div>
    <?php } ?>

    <div id="orders-section" class="tab-content active-content">
        <h3 class="section-title"><?php echo $is_staff ? "Orders Management" : "My Orders"; ?></h3>
        
        <form method="POST" action="dashboard.php">
            <?php if ($is_staff) { ?>
                <div class="contact-box flex-between flex-gap-10 mb-15">
                    <span class="text-small font-bold">BATCH ACTION:</span>
                    <select name="batch_status">
                        <option value="Pending">Set to Pending</option>
                        <option value="Preparing">Set to Preparing</option>
                        <option value="Ready">Set to Ready</option>
                        <option value="Completed">Set to Completed</option>
                    </select>
                    <input type="submit" class="btn btn-small" value="Update Selected">
                </div>
            <?php } ?>

            <div class="order-list">
                <?php
                $sql = "SELECT orders.*, products.name as product_name, users.full_name as customer_name 
                        FROM orders 
                        JOIN products ON orders.product_id = products.product_id
                        JOIN users ON orders.user_id = users.user_id"; 
                
                if (!$is_staff) {
                    $sql .= " WHERE orders.user_id = '{$_SESSION['user_id']}'";
                }
                $sql .= " ORDER BY orders.created_at DESC";
                $result = $conn->query($sql);

                if ($result->num_rows > 0) {
                    while($row = $result->fetch_assoc()) {
                        $color = get_status_color($row["order_status"]);
                ?>
                    <div class="card flex-between flex-gap-10 mb-15 p-15">
                        <?php if ($is_staff) { ?>
                            <input type="checkbox" name="order_ids[]" value="<?php echo $row['order_id']; ?>">
                        <?php } ?>

                        <div class="flex-1">
                            <div class="flex-between">
                                <strong><?php echo $row["product_name"]; ?> × <?php echo $row["quantity"]; ?></strong>
                                <span class="font-bold" style="color: <?php echo $color; ?>;">
                                    ● <?php echo strtoupper($row["order_status"]); ?>
                                </span>
                            </div>
                            <p class="text-small text-muted mt-5">
                                From: <?php echo $row["customer_name"]; ?> | <?php echo $row["created_at"]; ?>
                            </p>
                            <?php if ($is_staff) { ?>
                                <div class="address-box">
                                    Address: <?php echo $row["delivery_address"] ? $row["delivery_address"] : "Self-Pickup"; ?>
                                </div>
                            <?php } ?>
                        </div>
                    </div>
                <?php } } else { ?>
                    <div class="card center-box card-muted">No orders found.</div>
                <?php } ?>
            </div>
        </form>
    </div>

    <?php if ($is_staff) { ?>
        <div id="customers-section" class="tab-content">
            <h3 class="section-title">Registered Customers</h3>
            <table class="customer-table">
                <thead>
                    <tr>
                        <th>Customer Name</th>
                        <th>Email Address</th>
                        <th>Joined Date</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    $user_res = $conn->query("SELECT * FROM users WHERE role = 'customer' ORDER BY created_at DESC");
                    while($user = $user_res->fetch_assoc()) {
                    ?>
                        <tr>
                            <td><strong><?php echo htmlspecialchars($user['full_name']); ?></strong></td>
                            <td><?php echo htmlspecialchars($user['email']); ?></td>
                            <td><?php echo date('d M Y', strtotime($user['created_at'])); ?></td>
                        </tr>
                    <?php } ?>
                </tbody>
            </table>
        </div>

        <div id="feedback-section" class="tab-content">
            <h3 class="section-title section-title--danger">Customer Feedbacks</h3>
            <?php
            $fb_res = $conn->query("SELECT * FROM feedback ORDER BY created_at DESC");
            if ($fb_res->num_rows > 0) {
                while($fb = $fb_res->fetch_assoc()) {
                ?>
                    <div class="card feedback-card">
                        <strong><?php echo htmlspecialchars($fb['name']); ?></strong> 
                        <span class="text-xs float-right text-grey-soft"><?php echo $fb['created_at']; ?></span>
                        <p class="text-small mt-5 text-grey">
                            "<?php echo htmlspecialchars($fb['message']); ?>"
                        </p>
                    </div>
                <?php } 
            } else { echo '<div class="card card-muted">No feedbacks yet.</div>'; } ?>
        </div>
    <?php } ?>
</main>

<script>
    function switchTab(sectionId, btn) {
        const contents = document.querySelectorAll('.tab-content');
        contents.forEach(content => content.classList.remove('active-content'));
        
        const buttons = document.querySelectorAll('.tab-btn');
        buttons.forEach(button => button.classList.remove('active'));
        
        document.getElementById(sectionId).classList.add('active-content');
        btn.classList.add('active');
    }
</script>

<?php include("footer.php"); ?>
</body>
</html>