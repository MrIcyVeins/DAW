<?php
// Start session and include database connection if not already included
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

require_once "../database/db_connect.php";

// Check if user is logged in and fetch verification status
$user = null; // Initialize user variable
if (isset($_SESSION['email'])) {
    $email = $_SESSION['email'];
    $stmt = $conn->prepare("SELECT verified FROM users WHERE email = ?");
    $stmt->bind_param("s", $email);
    $stmt->execute();
    $res = $stmt->get_result();
    $user = $res->fetch_assoc();
}
?>

<nav class="navbar navbar-expand-sm navbar-light bg-success">
    <div class="container">
        <a class="navbar-brand" href="/loginRegistrationSystem/pages/dashboard.php" style="font-weight:bold; color:white;">Dashboard</a>
        <button class="navbar-toggler d-lg-none" type="button" data-bs-toggle="collapse"
                data-bs-target="#collapsibleNavId" aria-controls="collapsibleNavId"
                aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="collapsibleNavId">
            <ul class="navbar-nav m-auto mt-2 mt-lg-0">
                <li class="nav-item">
                    <a class="nav-link" href="/loginRegistrationSystem/pages/category1.php">Category1</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="/loginRegistrationSystem/pages/category2.php">Category2</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="/loginRegistrationSystem/pages/category3.php">Category3</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="/loginRegistrationSystem/pages/newsletter.php">Newsletter</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="/loginRegistrationSystem/pages/contact.php">Contact Us</a>
                </li>
            </ul>
            <form class="d-flex my-2 my-lg-0">
                <?php if (!isset($_SESSION['email'])): ?>
                    <!-- Show login and register buttons for guests -->
                    <a href="/loginRegistrationSystem/pages/login.php" class="btn btn-light me-2"
                       style="font-weight:bolder;color:green;">Login</a>
                    <a href="/loginRegistrationSystem/pages/register.php" class="btn btn-outline-light"
                       style="font-weight:bolder;color:white;">Register</a>
                <?php else: ?>
                    <!-- Show logout button for authenticated users -->
                    <a href="/loginRegistrationSystem/pages/logout.php" class="btn btn-light"
                       style="font-weight:bolder;color:green;">Logout</a>
                <?php endif; ?>
            </form>
        </div>
    </div>
</nav>

<?php if (!isset($_SESSION['email'])): ?>
    <!-- Display encouragement message for guests -->
    <div class="alert alert-info text-center mb-0">
        You are browsing as a guest. <a href="/loginRegistrationSystem/pages/register.php">Register</a> now to enjoy exclusive features!
    </div>
<?php endif; ?>
