<?php
session_start();

if (!isset($_SESSION["user_id"]) || $_SESSION["role"] != "staff") {
    header("Location: login.php");
    exit();
}

require_once __DIR__ . '/config.php';
$conn = db_connect();

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $name = $conn->real_escape_string($_POST["name"]);
    $category = $conn->real_escape_string($_POST["category"]);
    $temp = $conn->real_escape_string($_POST["temperature"]);
    $price = $conn->real_escape_string($_POST["price"]);
    $image_name = !empty($_POST["image_name"]) ? $conn->real_escape_string($_POST["image_name"]) : "default.jpg";

    $sql = "INSERT INTO products (name, category, temperature, price, image_name, is_available)
            VALUES ('$name', '$category', '$temp', '$price', '$image_name', 1)";

    if ($conn->query($sql) === TRUE) {
        header("Location: menu.php?cat=$category");
        exit();
    } else {
        echo "Error: " . $conn->error;
    }
}
?>