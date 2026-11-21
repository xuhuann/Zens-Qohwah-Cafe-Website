<?php
session_start();
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Zens Qohwah - Home</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>

<?php include("header.php"); ?>

<main class="content-full">

    <section class="home-section">
        <div class="hero">
            <h1>Welcome to Zens Qohwah</h1>
            <p>
                Love local coffee? Get it straight from the source. <br>
                By ordering directly with us, you get more value for your money — no service fees, no extra costs, just pure quality delivered fast.
            </p>
            <a class="btn mt-20" href="menu.php">Explore Menu</a>
        </div>
    </section>

    <section class="home-section">
        <div class="content-row">
            <div class="text-col">
                <h2 class="clean-title-left">Our Story</h2>
                <p>
                    At Zens Qohwah, we believe the best coffee is the one that fuels your ambition.
                    Whether you're powering through a deadline or enjoying a lazy weekend, we deliver fresh and high-quality brews right to you.
                </p>
            </div>
            <div class="image-col">
                <img src="images/bg/ourstory.png" alt="Our Shop" class="img-full-border">
            </div>
        </div>

        <div class="content-row reverse">
            <div class="text-col">
                <h2 class="clean-title-left">How It Works</h2>
                <p>
                    Good coffee should be within reach. Join our community and explore our carefully curated menu.
                    From the moment you place your order, we will providing real-time updates on your order preparation, packaging and delivery.
                    Your coffee cravings are always at your fingertips.
                </p>
            </div>
            <div class="image-col">
                <img src="images/bg/howitworks.png" alt="Ordering Process" class="img-full-border">
            </div>
        </div>
    </section>

<section class="home-section no-border">
    <div class="testimonials">
        <h2 class="clean-title text-center">Testimonials</h2>
        <p class="mb-40 text-center text-muted">What our community says about us</p>

        <div class="testimonial-cards">
            <?php
            require_once __DIR__ . '/config.php';
            $conn = db_connect();
            $result = $conn->query("SELECT name, message FROM feedback ORDER BY created_at DESC LIMIT 3");
            if ($result && $result->num_rows > 0) {
                while ($row = $result->fetch_assoc()) {
                    $name = htmlspecialchars($row['name']);
                    $message = htmlspecialchars($row['message']);
                    echo "
                    <div class=\"card\">
                        <p class=\"italic mb-15\">\"$message\"</p>
                        <strong>- $name</strong>
                    </div>";
                }
            } else {
                echo "<p class='text-center text-muted'>No testimonials yet. Be the first to share your experience!</p>";
            }
            ?>
        </div>
    </div>
</section>

</main> 

<?php include("footer.php"); ?>

</body>
</html>