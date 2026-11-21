<?php
session_start();

if (!isset($_SESSION["user_id"]) || $_SESSION["role"] != "staff") {
    header("Location: login.php");
    exit();
}

require_once __DIR__ . '/config.php';
$conn = db_connect();

$product_id = isset($_GET['id']) ? (int) $_GET['id'] : 0;

if ($product_id <= 0) {
    header("Location: menu.php");
    exit();
}

$sql = "SELECT * FROM products WHERE product_id = $product_id";
$result = $conn->query($sql);

if (!$result || $result->num_rows === 0) {
    header("Location: menu.php");
    exit();
}

$product = $result->fetch_assoc();
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Edit Product - Zens Qohwah</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>

<?php include("header.php"); ?>

<main class="content">
    <h2 class="clean-title">Edit Product</h2>
    
    <form class="auth-form" action="update_product.php" method="POST">
        <input type="hidden" name="product_id" value="<?php echo $product['product_id']; ?>">

        <div class="auth-group">
            <label>Product Name</label>
            <input type="text" name="name" value="<?php echo htmlspecialchars($product['name']); ?>" required>
        </div>

        <div class="auth-group">
            <label>Category</label>
            <select name="category">
                <option value="coffee" <?php if ($product['category'] === 'coffee') echo 'selected'; ?>>Coffee</option>
                <option value="food" <?php if ($product['category'] === 'food') echo 'selected'; ?>>Food</option>
            </select>
        </div>

        <div class="auth-group">
            <label>Temperature (Optional)</label>
            <input type="text" name="temperature" value="<?php echo htmlspecialchars($product['temperature']); ?>" placeholder="Hot / Ice / Regular">
        </div>

        <div class="auth-group">
            <label>Price (RM)</label>
            <input type="number" step="0.01" name="price" value="<?php echo htmlspecialchars($product['price']); ?>" required>
        </div>

        <div class="auth-group">
            <label>Image Filename</label>
            <input type="text" name="image_name" value="<?php echo htmlspecialchars($product['image_name']); ?>" required>
        </div>

        <input type="submit" class="btn btn-full" value="Update Product">

        <div class="mt-20 text-center">
            <a href="menu.php?cat=<?php echo $product['category']; ?>" class="text-small text-muted link-underline">Back to Menu</a>
        </div>
    </form>
</main>

<?php include("footer.php"); ?>

</body>
</html>

