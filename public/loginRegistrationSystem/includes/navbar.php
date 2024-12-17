<?php
// Start session and include database connection if not already included
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

// Initialize variables
$userEmail = $_SESSION['email'] ?? 'Guest'; // Default email if not logged in
$isLoggedIn = isset($_SESSION['email']);
?>

<div class="logo-container">
    <a href="/loginRegistrationSystem/pages/dashboard">
        <img src="/loginRegistrationSystem/assets/logo.png" alt="Logo" class="site-logo">
    </a>
</div>

<nav class="navbar custom-navbar">
    <div class="container-fluid">
        <!-- Centered Navbar Links -->
        <ul class="custom-navbar-links">
            <li><a class="nav-link" href="/loginRegistrationSystem/pages/dashboard">Home</a></li>
            <li><a class="nav-link" href="/loginRegistrationSystem/pages/category0">Trending</a></li>
            <li><a class="nav-link" href="/loginRegistrationSystem/pages/category1">World News & Politics</a></li>
            <li><a class="nav-link" href="/loginRegistrationSystem/pages/category2">Science, Tech & Innovation</a></li>
            <li><a class="nav-link" href="/loginRegistrationSystem/pages/category3">Lifestyle & Culture</a></li>
            <li><a class="nav-link" href="/loginRegistrationSystem/pages/newsletter">Newsletter</a></li>
            <li><a class="nav-link" href="/loginRegistrationSystem/pages/contact">Contact Us</a></li>
        </ul>

        <!-- Buttons Section -->
        <div class="custom-navbar-buttons">
            <?php if ($isLoggedIn): ?>
                <!-- Profile Dropdown -->
                <div class="dropdown">
                    <a href="#" class="dropdown-toggle profile-btn" id="profileDropdown" data-bs-toggle="dropdown" aria-expanded="false">
                        <i class="fas fa-user-circle profile-icon"></i>
                        <span class="profile-name"><?php echo htmlspecialchars($userEmail); ?></span>
                    </a>
                    <ul class="dropdown-menu dropdown-menu-end" aria-labelledby="profileDropdown">
                        <li><a class="dropdown-item" href="/loginRegistrationSystem/pages/profile">My Profile</a></li>
                        <li><a class="dropdown-item" href="/loginRegistrationSystem/pages/settings">Settings</a></li>
                        <li><hr class="dropdown-divider"></li>
                        <li><a class="dropdown-item" href="/loginRegistrationSystem/pages/logout">Logout</a></li>
                    </ul>
                </div>
            <?php else: ?>
                <a href="/loginRegistrationSystem/pages/login" class="btn btn-outline-success">Login</a>
                <a href="/loginRegistrationSystem/pages/register" class="btn btn-outline-success">Register</a>
            <?php endif; ?>
        </div>
    </div>
</nav>
