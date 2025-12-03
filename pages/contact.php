<?php
// pages/contact.php
include '../includes/header.php';

// Check if form was submitted
$messageSent = false;
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Logic to send email/save to DB
    $messageSent = true;
}
?>

<link rel="stylesheet" href="../css/contact.css">

<div class="contact-container">
    <div class="contact-wrapper">
        
        <div class="contact-form-section">
            <h1>Send us a Message</h1>
            
            <?php if ($messageSent): ?>
                <div class="alert-success">
                    Message sent successfully! We'll be in touch.
                </div>
            <?php endif; ?>

            <form action="contact.php" method="POST">
                <div class="form-group">
                    <label for="name">Your Name</label>
                    <input type="text" id="name" name="name" required>
                </div>
                <div class="form-group">
                    <label for="email">Email Address</label>
                    <input type="email" id="email" name="email" required>
                </div>
                <div class="form-group">
                    <label for="message">Message</label>
                    <textarea id="message" name="message" rows="5" required></textarea>
                </div>
                <button type="submit" class="btn-submit">Send Message</button>
            </form>
        </div>

        <div class="contact-info-section">
            <h2>Contact Info</h2>
            
            <div class="info-item">
                <span class="icon">📍</span>
                <p>Jeddah<br>Saudi Arabia, Almrwah</p>
            </div>

            <div class="info-item">
                <span class="icon">📞</span>
                <p><a href="tel:+966582637864">+966 58 263 7864</a></p>
            </div>

            <div class="info-item">
                <span class="icon">📧</span>
                <p><a href="mailto:support@electrotech.com">support@electrotech.com</a></p>
            </div>

            <div class="social-media">
                <h3>Follow Us</h3>
                <div class="social-icons">
                    <a href="https://facebook.com" class="social-icon" title="Facebook">f</a>
                    <a href="https://x.com" class="social-icon" title="x">x</a>
                    <a href="https://instagram.com" class="social-icon" title="Instagram">ig</a>
                    <a href="https://linkedin.com" class="social-icon" title="LinkedIn">in</a>
                </div>
            </div>
        </div>

    </div>
</div>

<?php
include '../includes/footer.php';
?>