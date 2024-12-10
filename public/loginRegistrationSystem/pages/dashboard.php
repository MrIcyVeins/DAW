<?php
session_start();
require_once "../database/db_connect.php";

if (!isset($_SESSION['email'])) {
    header("Location: login.php");
    exit();
}

// Check verification status
$email = $_SESSION['email'];
$stmt = $conn->prepare("SELECT verified FROM users WHERE email = ?");
$stmt->bind_param("s", $email);
$stmt->execute();
$res = $stmt->get_result();
$user = $res->fetch_assoc();

include "../includes/header.php";
include "../includes/navbar.php";
?>

<div class="container mt-5">
    <?php if (!$user['verified']): ?>
        <div class="alert alert-warning">
            Your email is not verified. Consider verifying it if you'd like to subscribe to our newsletter or receive exclusive updates.
        </div>
    <?php endif; ?>
    <h2 class="p-4">Welcome To Dashboard</h2>
    <p>Here you can browse freely. No restrictions imposed. But verifying your email is recommended.</p>
</div>

<?php include "../includes/footer.php"; ?>
