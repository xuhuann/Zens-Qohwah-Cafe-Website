<?php
session_start();

if (!isset($_SESSION["user_id"]) || $_SESSION["role"] != "staff") {
    header("Location: login.php");
    exit();
}

require_once __DIR__ . '/config.php';
$conn = db_connect();

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $product_id = isset($_POST["product_id"]) ? (int) $_POST["product_id"] : 0;

    if ($product_id <= 0) {
        header("Location: menu.php");
        exit();
    }

    $name = $conn->real_escape_string($_POST["name"]);
    $category = $conn->real_escape_string($_POST["category"]);
    $temp = $conn->real_escape_string($_POST["temperature"]);
    $price = $conn->real_escape_string($_POST["price"]);
    $image_name = $conn->real_escape_string($_POST["image_name"]);

    $sql = "UPDATE products 
            SET name = '$name',
                category = '$category',
                temperature = '$temp',
                price = '$price',
                image_name = '$image_name'
            WHERE product_id = $product_id";

    if ($conn->query($sql) === TRUE) {
        header("Location: menu.php?cat=$category");
        exit();
    } else {
        echo "Error: " . $conn->error;
    }
} else {
    header("Location: menu.php");
    exit();
}

