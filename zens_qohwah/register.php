<?php
require_once __DIR__ . '/config.php';
$conn = db_connect();

$message = "";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $name = $conn->real_escape_string($_POST["full_name"]);
    $email = $conn->real_escape_string($_POST["email"]);
    $password = $conn->real_escape_string($_POST["password"]);

    $check_sql = "SELECT user_id FROM users WHERE email='$email'";
    $result = $conn->query($check_sql);

    if ($result->num_rows > 0) {
        $message = "Email already registered.";
    } else {
        $sql = "INSERT INTO users (full_name, email, password_hash, role)
                VALUES ('$name', '$email', '$password', 'customer')";

        if ($conn->query($sql) === TRUE) {
            $message = "Registration successful!";
        } else {
            $message = "Error: " . $conn->error;
        }
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Register - Zens Qohwah</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>

<?php include("header.php"); ?>

<main class="content">
    <h2 class="clean-title">Register</h2>

    <form class="auth-form" method="POST">
        
        <?php if ($message != "") { ?>
            <p class="mb-15" style="color: <?php echo ($message == 'Registration successful!') ? 'green' : 'red'; ?>;">
                <?php echo $message; ?>
            </p>
        <?php } ?>

        <div class="auth-group">
            <label>Full Name</label>
            <input type="text" name="full_name" required>
        </div>

        <div class="auth-group">
            <label>Email Address</label>
            <input type="email" name="email" required>
        </div>

        <div class="auth-group">
            <label>Password</label>
            <input type="password" name="password" required>
        </div>

        <input type="submit" class="btn" value="Register">
        
        <p class="mt-20">
            Already have an account? <a href="login.php" class="link-underline">Log In here</a>
        </p>
    </form>
</main>

<?php include("footer.php"); ?>

</body>
</html>