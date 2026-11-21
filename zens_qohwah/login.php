<?php
session_start();

require_once __DIR__ . '/config.php';
$conn = db_connect();

$message = "";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Use real_escape_string to reduce SQL injection risk
    $email = $conn->real_escape_string($_POST["email"]);
    $password = $conn->real_escape_string($_POST["password"]);

    if (empty($email) || empty($password)) {
        $message = "Please fill in all fields.";
    } else {
        $sql = "SELECT * FROM users WHERE email='$email'";
        $result = $conn->query($sql);

        if ($result->num_rows > 0) {
            $row = $result->fetch_assoc();

            if ($password == $row["password_hash"]) {
                $_SESSION["user_id"] = $row["user_id"];
                $_SESSION["name"] = $row["full_name"];
                $_SESSION["role"] = $row["role"];

                header("Location: dashboard.php");
                exit();
            } else {
                $message = "Wrong password.";
            }
        } else {
            $message = "User not found.";
        }
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Login - Zens Qohwah</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>

<?php include("header.php"); ?>

<main class="content">
    <h2 class="clean-title">Log In</h2>

    <form id="loginForm" class="auth-form" method="POST">
        
        <?php if ($message != "") { ?>
            <p class="text-center mb-15 danger-text">
                <?php echo $message; ?>
            </p>
        <?php } ?>

        <div class="auth-group">
            <label>Email Address</label>
            <input type="email" id="loginEmail" name="email" required>
        </div>

        <div class="auth-group">
            <label>Password</label>
            <input type="password" id="loginPass" name="password" required>
        </div>

        <input type="submit" class="btn btn-full" value="Log In">
        
        <p class="mt-20 text-small">
            Don't have an account? <a href="register.php" class="link-underline text-black font-bold">Register here</a>
        </p>
    </form>
</main>

<?php include("footer.php"); ?>

<script>
    document.getElementById('loginForm').addEventListener('submit', function(e) {
        const password = document.getElementById('loginPass').value;
        
        // 1. Client-side validation
        if (password.length < 4) {
            alert("Password must be at least 4 characters long.");
            e.preventDefault(); 
            return;
        }

        // 2. Simple UI feedback
        const submitBtn = this.querySelector('input[type="submit"]');
        submitBtn.value = "Authenticating...";
        submitBtn.style.opacity = "0.7";
    });
</script>

</body>
</html>