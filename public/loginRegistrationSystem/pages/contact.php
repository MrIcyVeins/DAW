<?php
session_start();
require_once "../database/db_connect.php";

// Încarcă configurația
$config = require __DIR__ . '/../config/config.php';

// Include header și navbar
include "../includes/header.php";
include "../includes/navbar.php";

// Verifică dacă utilizatorul este autentificat
$isLoggedIn = isset($_SESSION['email']);
?>

<div class="container mt-5">
    <h2 class="p-4">Contact Us</h2>
    <p>If you have any questions, feedback, or concerns, feel free to reach out to us using the form below.</p>

    <?php if (!$isLoggedIn): ?>
        <!-- Mesaj pentru utilizatorii neautentificați -->
        <div class="alert alert-warning">
            You must <a href="login.php">log in</a> or <a href="register.php">register</a> to use the contact form.
        </div>
    <?php else: ?>
        <!-- Formă de contact pentru utilizatorii autentificați -->
        <form method="POST" action="contact_process.php">
            <div class="mb-3">
                <label for="name" class="form-label">Your Name:</label>
                <input type="text" class="form-control" id="name" name="name" required>
            </div>
            <div class="mb-3">
                <label for="email" class="form-label">Your Email Address:</label>
                <input type="email" class="form-control" id="email" name="email" value="<?php echo htmlspecialchars($_SESSION['email']); ?>" readonly>
            </div>
            <div class="mb-3">
                <label for="message" class="form-label">Your Message:</label>
                <textarea class="form-control" id="message" name="message" rows="5" required></textarea>
            </div>
            
            <!-- Adaugă widget-ul reCAPTCHA -->
            <div class="g-recaptcha" data-sitekey="<?php echo htmlspecialchars($config['recaptcha_site_key']); ?>"></div>
            
            <button type="submit" class="btn btn-success mt-3">Send Message</button>
        </form>
    <?php endif; ?>
</div>

<!-- Include script-ul API reCAPTCHA -->
<script src="https://www.google.com/recaptcha/api.js" async defer></script>

<?php include "../includes/footer.php"; ?>
