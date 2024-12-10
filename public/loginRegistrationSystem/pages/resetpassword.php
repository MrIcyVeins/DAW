<?php
session_start();
require_once "../database/db_connect.php";

// Enable error reporting for debugging (remove in production)
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

$error = "";
$success = "";
$token = isset($_GET['token']) ? $_GET['token'] : "";

// If a token is provided, user is attempting to reset password.
// If no token is provided, user is initiating the reset process by entering their email.
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (isset($_POST['email']) && empty($token)) {
        // User requested a reset link by providing email
        $email = trim($_POST['email']);

        // Check if email exists
        $stmt = $conn->prepare("SELECT id FROM users WHERE email = ?");
        $stmt->bind_param("s", $email);
        $stmt->execute();
        $res = $stmt->get_result();

        if ($res->num_rows === 1) {
            // User exists, generate token and store it
            $resetToken = bin2hex(random_bytes(16)); // secure random token

            // Delete any existing token for this email (optional cleanup)
            $del = $conn->prepare("DELETE FROM password_resets WHERE email = ?");
            $del->bind_param("s", $email);
            $del->execute();

            $ins = $conn->prepare("INSERT INTO password_resets (email, token) VALUES (?, ?)");
            $ins->bind_param("ss", $email, $resetToken);
            if ($ins->execute()) {
                // In a real scenario, send an email with this link:
                // http://localhost/loginRegistrationSystem/pages/resetpassword.php?token=$resetToken
                // For demo, we’ll just show the link:
                $success = "A password reset link has been generated. Use this link (in a real system, this would be emailed):";
                $success .= "<br><a href=\"resetpassword.php?token=$resetToken\">Reset Password Link</a>";
            } else {
                $error = "Error generating reset token.";
            }
        } else {
            $error = "No account found with that email.";
        }

    } elseif (!empty($token) && isset($_POST['new_password']) && isset($_POST['confirm_password'])) {
        // User is attempting to set a new password with a valid token
        $new_password = $_POST['new_password'];
        $confirm_password = $_POST['confirm_password'];

        if ($new_password !== $confirm_password) {
            $error = "Passwords do not match.";
        } else {
            // Check if token is valid
            $stmt = $conn->prepare("SELECT email FROM password_resets WHERE token = ?");
            $stmt->bind_param("s", $token);
            $stmt->execute();
            $res = $stmt->get_result();

            if ($res->num_rows === 1) {
                $row = $res->fetch_assoc();
                $email = $row['email'];

                // Update user's password
                $passwordHash = password_hash($new_password, PASSWORD_BCRYPT);
                $upd = $conn->prepare("UPDATE users SET password_hash = ? WHERE email = ?");
                $upd->bind_param("ss", $passwordHash, $email);

                if ($upd->execute()) {
                    // Delete the used token
                    $del = $conn->prepare("DELETE FROM password_resets WHERE token = ?");
                    $del->bind_param("s", $token);
                    $del->execute();

                    // Log out the user by clearing session
                    session_unset();
                    session_destroy();

                    // Redirect immediately to login page
                    header("Location: login.php");
                    exit();
                } else {
                    $error = "Error updating your password.";
                }
            } else {
                $error = "Invalid or expired token.";
            }
        }
    }
}

include "../includes/header.php";
?>

<div class="container mt-5">
    <h2>Reset Password</h2>
    <?php if (!empty($error)): ?>
        <div class="alert alert-danger"><?php echo htmlspecialchars($error); ?></div>
    <?php endif; ?>
    <?php if (!empty($success)): ?>
        <div class="alert alert-success"><?php echo $success; ?></div>
    <?php endif; ?>

    <?php if (empty($token)): ?>
        <!-- No token given, show form to request a reset link -->
        <form method="POST" action="resetpassword.php">
            <div class="mb-3">
                <label>Your Email Address:</label>
                <input type="email" name="email" class="form-control" required />
            </div>
            <button type="submit" class="btn btn-success">Send Reset Link</button>
        </form>
    <?php else: ?>
        <!-- Token is provided, show form to set a new password -->
        <form method="POST" action="resetpassword.php?token=<?php echo htmlspecialchars($token); ?>">
            <div class="mb-3">
                <label>New Password:</label>
                <input type="password" name="new_password" class="form-control" required />
            </div>
            <div class="mb-3">
                <label>Confirm New Password:</label>
                <input type="password" name="confirm_password" class="form-control" required />
            </div>
            <button type="submit" class="btn btn-success">Reset Password</button>
        </form>
    <?php endif; ?>
</div>

<?php include "../includes/footer.php"; ?>
