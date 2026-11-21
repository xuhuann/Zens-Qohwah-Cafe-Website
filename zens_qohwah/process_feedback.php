<?php
session_start();

require_once __DIR__ . '/config.php';
$conn = db_connect();

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    
    $name = $conn->real_escape_string($_POST['name']);
    $email = $conn->real_escape_string($_POST['email']);
    $feedback = $conn->real_escape_string($_POST['feedback']);

    // Insert feedback into the database
    $sql = "INSERT INTO feedback (name, email, message) VALUES ('$name', '$email', '$feedback')";

    if ($conn->query($sql) === TRUE) {
        echo "<script>
                alert('Thank you! Your feedback has been submitted successfully.');
                window.location.href = 'contact.php';
              </script>";
    } else {
        echo "Error: " . $conn->error;
    }
} else {
    header("Location: contact.php");
}

$conn->close();
?>