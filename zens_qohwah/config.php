<?php
// Simple shared configuration for database and common helpers

const DB_HOST = 'localhost';
const DB_USER = 'root';
const DB_PASS = '';
const DB_NAME = 'zens_qohwah';

function db_connect(): mysqli {
    static $conn = null;

    if ($conn instanceof mysqli) {
        return $conn;
    }

    $conn = new mysqli(DB_HOST, DB_USER, DB_PASS, DB_NAME);

    if ($conn->connect_error) {
        die('Connection failed: ' . $conn->connect_error);
    }

    return $conn;
}

// Return a color code for a given order status
function get_order_status_color(string $status): string {
    if ($status === 'Pending') {
        return '#f39c12';
    }
    if ($status === 'Preparing') {
        return '#3498db';
    }
    if ($status === 'Completed') {
        return '#2ecc71';
    }

    return '#000';
}

