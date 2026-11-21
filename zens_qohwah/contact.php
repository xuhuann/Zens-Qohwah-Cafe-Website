<?php
session_start();
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Contact Us - Zens Qohwah</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>

<?php include("header.php"); ?>

<main class="content">
    <div class="contact-container">
        
        <h2 class="clean-title text-center">Contact Us</h2>

        <div class="contact-info-grid">
            <div class="contact-box">
                <strong>Location</strong>
                <p>Survey Lot 4339 A (Gnd Floor)<br>Parent Lot 861 Block 6 RKB, Jln Banting,<br>98850 Lawas, Sarawak, Malaysia</p>
            </div>

            <div class="contact-box">
                <strong>WhatsApp</strong>
                <p><a href="https://wa.me/60133220626">+60 13-3220626</a></p>
            </div>

            <div class="contact-box">
                <strong>Business Hours</strong>
                <p>Open Daily except Tuesday<br>10:00 AM - 07:00 PM</p>
            </div>
        </div>

            <div class="contact-form-container">
            <h3 class="section-title">Send Us Your Feedback</h3>
            
            <form id="feedbackForm" action="process_feedback.php" method="POST" class="auth-form auth-form-wide">
                <div class="auth-group">
                    <label>Name</label>
                    <input type="text" id="name" name="name" placeholder="Your Name" required>
                </div>

                <div class="auth-group">
                    <label>Email</label>
                    <input type="email" id="email" name="email" placeholder="Your Email Address" required>
                </div>

                <div class="auth-group">
                    <label>Feedback</label>
                    <textarea id="feedback" name="feedback" rows="6" placeholder="Type your message here..." required></textarea>
                </div>

                <div class="form-actions mt-20">
                    <input type="submit" class="btn" value="Submit Feedback">
                </div>
            </form>
        </div>
    </div>
</main>

<?php include("footer.php"); ?>

<script>
    document.getElementById('feedbackForm').addEventListener('submit', function(e) {
        const feedbackText = document.getElementById('feedback').value;

        // 1. Validate feedback length
        if (feedbackText.trim().length < 5) {
            alert("Please write at least 5 characters for your feedback.");
            e.preventDefault(); 
            return;
        }

        // 2. Ask for confirmation before sending
        const confirmMsg = confirm("Confirm to submit your feedback to Zens Qohwah?");
        if (!confirmMsg) {
            e.preventDefault(); 
        }
    });
</script>

</body>
</html>