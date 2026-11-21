<?php
session_start();

require_once __DIR__ . '/config.php';
$conn = db_connect();

if (!isset($_SESSION["user_id"]) || $_SESSION["role"] != "staff") {
    header("Location: login.php");
    exit();
}

$order_id = isset($_POST["order_id"]) ? $conn->real_escape_string($_POST["order_id"]) : '';
$status = isset($_POST["status"]) ? $conn->real_escape_string($_POST["status"]) : '';

if (!empty($order_id) && !empty($status)) {
    $sql = "UPDATE orders SET order_status='$status' WHERE order_id='$order_id'";

    if ($conn->query($sql) === TRUE) {
        header("Location: dashboard.php");
        exit();
    } else {
        echo "Error: " . $conn->error;
    }
} else {
    header("Location: dashboard.php");
    exit();
}
?>