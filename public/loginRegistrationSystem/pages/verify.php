<?php
require_once "../database/db_connect.php";

$token = $_GET['token'] ?? '';

$message = "Invalid or expired verification token.";

if ($token) {
    $stmt = $conn->prepare("SELECT id FROM users WHERE verification_token = ?");
    $stmt->bind_param("s", $token);
    $stmt->execute();
    $res = $stmt->get_result();

    if ($res->num_rows === 1) {
        $row = $res->fetch_assoc();
        $userId = $row['id'];

        $update = $conn->prepare("UPDATE users SET verified = 1, verification_token = NULL WHERE id = ?");
        $update->bind_param("i", $userId);
        if ($update->execute()) {
            $message = "Your email has been verified. Thank you!";
        } else {
            $message = "Error verifying your account.";
        }
    }
}

// Just show a simple message
?>
<?php include "../includes/header.php"; ?>
<div class="container mt-5">
    <h2>Email Verification</h2>
    <div class="alert alert-info"><?php echo htmlspecialchars($message); ?></div>
    <p><a href="login.php">Go to Login</a></p>
</div>
<?php include "../includes/footer.php"; ?>
