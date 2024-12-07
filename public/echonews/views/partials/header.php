<?php
include '../config/session.php';
?>
<header>
    <nav>
        <a href="../views/home.php">Home</a>
        <?php if (isLoggedIn()): ?>
            <a href="../views/<?php echo isAdmin() ? 'admin_dashboard.php' : 'user_dashboard.php'; ?>">Dashboard</a>
            <a href="../controllers/auth.php?action=logout">Logout</a>
        <?php else: ?>
            <a href="../views/login.php">Login</a>
            <a href="../views/register.php">Register</a>
        <?php endif; ?>
    </nav>
</header>
