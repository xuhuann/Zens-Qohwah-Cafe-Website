<?php
session_start();

if (!isset($_SESSION["user_id"])) {
    header("Location: login.php");
    exit();
}

if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST["product_id"])) {
    $product_id = (int)$_POST["product_id"];
    $quantity = isset($_POST["quantity"]) ? (int)$_POST["quantity"] : 1;

    if ($quantity < 1) {
        $quantity = 1;
    }

    if (!isset($_SESSION["cart"])) {
        $_SESSION["cart"] = [];
    }

    if (isset($_SESSION["cart"][$product_id])) {
        $_SESSION["cart"][$product_id] += $quantity;
    } else {
        $_SESSION["cart"][$product_id] = $quantity;
    }

    header("Location: cart.php");
    exit();
}

header("Location: menu.php");
exit();
?>