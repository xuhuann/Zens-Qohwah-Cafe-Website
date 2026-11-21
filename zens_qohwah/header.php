<?php 
if (session_status() === PHP_SESSION_NONE) { 
    session_start(); 
} 
?>

<header class="header">
    <div class="logo">
        <a href="index.php">
            <img src="images/logo/logo.jpg" alt="Zens Qohwah Logo" id="headerLogo">
            <span class="logo-text">Zens Qohwah</span>
        </a>
    </div>

    <nav class="nav">
        <a href="index.php">Home</a>
        <a href="menu.php">Menu</a>
        
        <?php 
        // Show Contact Us for non-staff users
        if (!isset($_SESSION["role"]) || $_SESSION["role"] !== "staff") { ?>
            <a href="contact.php">Contact Us</a>
        <?php } ?>
        
        <?php 
        if (isset($_SESSION["user_id"])) { 
            // Show Cart only for non-staff users
            if ($_SESSION["role"] !== "staff") { ?>
                <a href="cart.php">Cart</a>
            <?php } ?>
            
            <a href="dashboard.php">Dashboard</a>
        <?php } ?>
    </nav>

    <div class="auth">
        <?php if (isset($_SESSION["user_id"])) { ?>
            <a href="logout.php" class="btn-logout">Log Out</a>
        <?php } else { ?>
            <a href="login.php">Log In</a>
            <a href="register.php" class="btn-reg">Register</a>
        <?php } ?>
    </div>
</header>