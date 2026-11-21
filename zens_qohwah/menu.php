<?php
session_start();
require_once __DIR__ . '/config.php';
$conn = db_connect();

// Get current category from URL, default to coffee
$current_category = isset($_GET['cat']) ? trim(strtolower($_GET['cat'])) : 'coffee';

// Select only products that are available in the current category
$sql = "SELECT * FROM products WHERE is_available=1 AND category='$current_category'";
$result = $conn->query($sql);
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Menu - Zens Qohwah</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>

<?php include("header.php"); ?>

<main class="content">
    <h2 class="clean-title">Menu</h2>

    <div class="menu-layout">
        <aside class="sidebar">
            <a href="menu.php?cat=coffee" class="<?php if($current_category == 'coffee') echo 'active'; ?>">Coffee</a>
            <a href="menu.php?cat=food" class="<?php if($current_category == 'food') echo 'active'; ?>">Food</a>
        </aside>

        <div class="menu-items">
            <?php
            if ($result && $result->num_rows > 0) {
                while($row = $result->fetch_assoc()) {
                    // Build the display title and image path
                    $title = $row["name"] . ($row["temperature"] ? " (" . $row["temperature"] . ")" : "");
                    $imagePath = "images/" . (!empty($row['image_name']) ? $row['image_name'] : "default.jpg");
            ?>
                    <div class="menu-card">
                        <div class="menu-img" style="background-image: url('<?php echo $imagePath; ?>');"></div> 

                        <div class="menu-info">
                            <div>
                                <h3><?php echo $title; ?></h3>
                                <p>RM <?php echo number_format($row["price"], 2); ?></p>
                            </div>

                            <div class="menu-actions">
                                <?php if (isset($_SESSION["role"]) && $_SESSION["role"] != "staff") { ?>
                                    <form method="POST" action="add_to_cart.php" class="cart-form">
                                        <input type="hidden" name="product_id" value="<?php echo $row["product_id"]; ?>">
                                        <input type="number" name="quantity" value="1" min="1" class="qty-input">
                                        <input type="submit" value="Add to Cart" class="btn-small">
                                    </form>
                                <?php } elseif (isset($_SESSION["role"]) && $_SESSION["role"] == "staff") { ?>
                                    <a href="edit_product.php?id=<?php echo $row['product_id']; ?>" class="btn-small">Edit Product</a>
                                <?php } else { ?>
                                    <p class="login-msg"><a href="login.php" class="link-underline">Log in</a> to order</p>
                                <?php } ?>
                            </div>
                        </div>
                    </div>
            <?php
                }
            } else {
                echo "<div class='contact-box' style='text-align:center; width: 100%;'>No items available in this category.</div>";
            }
            ?>
        </div> 
    </div>
</main>

<?php include("footer.php"); ?>
</body>
</html>