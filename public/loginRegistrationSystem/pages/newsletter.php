<?php
session_start();
require_once "../database/db_connect.php";

// Include header and navbar
include "../includes/header.php";
include "../includes/navbar.php";

// Check if the user is logged in
$isSubscribed = false;
if (isset($_SESSION['email'])) {
    $email = $_SESSION['email'];
    
    // Check if the user is already subscribed to the newsletter
    $stmt = $conn->prepare("SELECT * FROM newsletter_subscribers WHERE email = ?");
    $stmt->bind_param("s", $email);
    $stmt->execute();
    $res = $stmt->get_result();
    $isSubscribed = $res->num_rows > 0;
}
?>

<!-- Background Wrapper -->
<div class="page-wrapper">
    <!-- Newsletter Subscription Form -->
    <div class="page-content-container">
        <h2 class="mb-4">Newsletter Subscription</h2>
        <p>Subscribe to our newsletter to stay updated with the latest news and exclusive content.</p>

        <?php if (!isset($_SESSION['email'])): ?>
            <!-- Message for guests -->
            <div class="alert alert-warning">
                You must <a href="login" class="alert-link">log in</a> or <a href="register" class="alert-link">register</a> to subscribe to the newsletter.
            </div>
        <?php elseif ($isSubscribed): ?>
            <!-- Message for subscribed users -->
            <div class="alert alert-success">
                You are already subscribed to the newsletter. Thank you for staying connected!
            </div>
        <?php else: ?>
            <!-- Subscription form for logged-in users -->
            <form method="POST" action="subscribe_newsletter">
                <div class="mb-3">
                    <label for="email" class="form-label">Your Email Address:</label>
                    <input type="email" class="form-control" id="email" name="email" value="<?php echo htmlspecialchars($_SESSION['email']); ?>" readonly />
                </div>
                <button type="submit" class="btn btn-success w-100">Subscribe</button>
            </form>
        <?php endif; ?>
    </div>
</div>

<?php include "../includes/footer.php"; ?>
