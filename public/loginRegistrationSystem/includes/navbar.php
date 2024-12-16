<?php
// Start session and include database connection if not already included
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

require_once "../database/db_connect.php";

// Check if user is logged in and fetch verification status
$user = null; // Initialize user variable
$showVerificationWarning = false; // Flag to show email verification warning
if (isset($_SESSION['email'])) {
    $email = $_SESSION['email'];
    $stmt = $conn->prepare("SELECT verified FROM users WHERE email = ?");
    $stmt->bind_param("s", $email);
    $stmt->execute();
    $res = $stmt->get_result();
    $user = $res->fetch_assoc();
    $showVerificationWarning = !$user['verified']; // Show warning if user is not verified
}
?>

<div class="logo-container">
    <a href="/loginRegistrationSystem/pages/dashboard.php">
        <img src="/loginRegistrationSystem/assets/logo.png" alt="Logo" class="site-logo">
    </a>
</div>

<nav class="navbar navbar-expand-lg">
    <div class="container">
        <!-- Navbar Links -->
        <div class="collapse navbar-collapse justify-content-center" id="navbarNavDropdown">
            <ul class="navbar-nav">
                <li class="nav-item">
                    <a class="nav-item-line nav-link" href="/loginRegistrationSystem/pages/dashboard.php">Home</a>
                </li>
                <li class="nav-item">
                    <a class="nav-item-line nav-link" href="/loginRegistrationSystem/pages/category1.php">World News & Politics</a>
                </li>
                <li class="nav-item">
                    <a class="nav-item-line nav-link" href="/loginRegistrationSystem/pages/category2.php">Science, Tech & Innovation</a>
                </li>
                <li class="nav-item">
                    <a class="nav-item-line nav-link" href="/loginRegistrationSystem/pages/category3.php">Lifestyle & Culture</a>
                </li>
                <li class="nav-item">
                    <a class="nav-item-line nav-link" href="/loginRegistrationSystem/pages/newsletter.php">Newsletter</a>
                </li>
                <li class="nav-item">
                    <a class="nav-item-line nav-link" href="/loginRegistrationSystem/pages/contact.php">Contact Us</a>
                </li>
            </ul>
            <div class="d-flex">
                <?php if (!isset($_SESSION['email'])): ?>
                    <!-- Login and Register Buttons -->
                    <a href="/loginRegistrationSystem/pages/login.php" class="btn btn-outline-success">Login</a>
                    <a href="/loginRegistrationSystem/pages/register.php" class="btn btn-outline-success">Register</a>
                <?php else: ?>
                    <!-- Logout Button -->
                    <a href="/loginRegistrationSystem/pages/logout.php" class="btn btn-outline-danger">Logout</a>
                <?php endif; ?>
            </div>
        </div>
    </div>
</nav>

<?php if (isset($_SESSION['email']) && $showVerificationWarning): ?>
    <!-- Email Verification Warning for Logged-In Users -->
    <div class="alert alert-warning text-center mb-0">
        Your email is not verified. <a href="/loginRegistrationSystem/pages/resend_verification.php">Verify your email</a> to unlock all features.
    </div>
<?php elseif (!isset($_SESSION['email'])): ?>
    <!-- Guest Encouragement Message -->
    <div class="alert alert-info text-center mb-0">
        You are browsing as a guest. <a href="/loginRegistrationSystem/pages/register.php">Register</a> now to enjoy exclusive features!
    </div>
<?php endif; ?>
