<?php
session_start();

if (!isset($_SESSION["user_id"]) || $_SESSION["role"] != "staff") {
    header("Location: login.php"); 
    exit();
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Add Product - Zens Qohwah</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>

<?php include("header.php"); ?>

<main class="content">
    <h2 class="clean-title">Add New Product</h2>
    
    <form class="auth-form" action="save_product.php" method="POST">
        
        <div class="auth-group">
            <label>Product Name</label>
            <input type="text" name="name" placeholder="e.g. Hazelnut Latte" required>
        </div>

        <div class="auth-group">
            <label>Category</label>
            <select name="category">
                <option value="coffee">Coffee</option>
                <option value="food">Food</option>
            </select>
        </div>

        <div class="auth-group">
            <label>Temperature (Optional)</label>
            <input type="text" name="temperature" placeholder="Hot / Cold / Regular">
        </div>

        <div class="auth-group">
            <label>Price (RM)</label>
            <input type="number" step="0.01" name="price" placeholder="e.g. 12.50" required>
        </div>

        <div class="auth-group">
            <label>Image Filename</label>
            <input type="text" name="image_name" placeholder="e.g. Mocha.jpg" required>
        </div>

        <input type="submit" class="btn btn-full" value="Save Product">
        
        <div class="mt-20 text-center">
            <a href="dashboard.php" class="text-small text-muted link-underline">Back to Dashboard</a>
        </div>
    </form>
</main>

<?php include("footer.php"); ?>

</body>
</html>