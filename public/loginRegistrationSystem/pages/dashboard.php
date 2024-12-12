<?php
session_start();
require_once "../database/db_connect.php";

if (!isset($_SESSION['email'])) {
    header("Location: login.php");
    exit();
}

// Get user information
$email = $_SESSION['email'];
$stmt = $conn->prepare("SELECT verified FROM users WHERE email = ?");
$stmt->bind_param("s", $email);
$stmt->execute();
$res = $stmt->get_result();
$user = $res->fetch_assoc();

// Get any session message
$message = isset($_SESSION['message']) ? $_SESSION['message'] : '';
unset($_SESSION['message']);

include "../includes/header.php";
include "../includes/navbar.php";
?>

<div class="container mt-5">
    <?php if (!empty($message)): ?>
        <div class="alert alert-info"><?php echo htmlspecialchars($message); ?></div>
    <?php endif; ?>
    <h2 class="p-4">Welcome To Dashboard</h2>
    <p>Here you can browse freely. No restrictions imposed. But verifying your email is recommended.</p>
</div>

<?php include "../includes/footer.php"; ?>
