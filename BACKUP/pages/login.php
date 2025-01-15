<?php
session_start();
require_once "../database/db_connect.php";

// Include configuration
$config = require __DIR__ . '/../config/config.php';

// reCAPTCHA keys
$recaptchaSiteKey = $config['recaptcha_site_key'];
$recaptchaSecretKey = $config['recaptcha_secret_key'];

// Redirect to dashboard if already logged in
if (isset($_SESSION['email'])) {
    header("Location: dashboard");
    exit();
}

// Initialize error message and failed attempts counter
$error = "";
if (!isset($_SESSION['failed_attempts'])) {
    $_SESSION['failed_attempts'] = 0; // Initialize the failed attempts counter
}

// Handle POST request for login
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $email = trim($_POST['email']);
    $password = $_POST['password'];
    $recaptchaResponse = $_POST['g-recaptcha-response'] ?? '';

    // Check if reCAPTCHA is required
    $recaptchaRequired = $_SESSION['failed_attempts'] >= 3;

    if ($recaptchaRequired) {
        // reCAPTCHA validation
        if (!empty($recaptchaResponse)) {
            $verifyURL = 'https://www.google.com/recaptcha/api/siteverify';
            $data = [
                'secret' => $recaptchaSecretKey,
                'response' => $recaptchaResponse,
                'remoteip' => $_SERVER['REMOTE_ADDR']
            ];

            $ch = curl_init();
            curl_setopt($ch, CURLOPT_URL, $verifyURL);
            curl_setopt($ch, CURLOPT_POST, true);
            curl_setopt($ch, CURLOPT_POSTFIELDS, http_build_query($data));
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
            $response = curl_exec($ch);
            curl_close($ch);

            $responseKeys = json_decode($response, true);
            if (!$responseKeys['success']) {
                $error = "reCAPTCHA verification failed. Please try again.";
            }
        } else {
            $error = "Please complete the reCAPTCHA.";
        }
    }

    // If no error, verify login credentials
    if (empty($error)) {
        $stmt = $conn->prepare("SELECT id, password_hash, is_admin FROM users WHERE email = ?");
        if ($stmt) {
            $stmt->bind_param("s", $email);
            $stmt->execute();
            $res = $stmt->get_result();

            if ($res->num_rows === 1) {
                $row = $res->fetch_assoc();
                if (password_verify($password, $row['password_hash'])) {
                    // Successful login
                    $_SESSION['user_id'] = $row['id']; // Set user ID in session
                    $_SESSION['email'] = $email; // Optional: Store email
                    $_SESSION['is_admin'] = $row['is_admin']; // Set admin flag in session
                    $_SESSION['failed_attempts'] = 0; // Reset failed attempts
                    header("Location: dashboard");
                    exit();
                } else {
                    $error = "Invalid email or password.";
                }
            } else {
                $error = "Invalid email or password.";
            }
        } else {
            $error = "Database error occurred.";
        }
    }

    // Increment failed attempts if login fails
    if (!empty($error)) {
        $_SESSION['failed_attempts']++;
    }
}

include "../includes/header_simple.php";
?>
<!-- HTML Content Below -->
<div class="login-wrapper">
    <div class="login-container">
        <h2 class="text-center mb-4">Login</h2>
        <?php if (!empty($error)): ?>
            <div class="alert alert-danger"><?php echo htmlspecialchars($error); ?></div>
        <?php endif; ?>
        <form method="POST" action="login">
            <div class="mb-3">
                <label for="email" class="form-label">Email</label>
                <input type="email" name="email" id="email" class="form-control" required>
            </div>
            <div class="mb-3">
                <label for="password" class="form-label">Password</label>
                <input type="password" name="password" id="password" class="form-control" required>
            </div>
            <!-- Conditionally Show reCAPTCHA -->
            <?php if ($_SESSION['failed_attempts'] >= 3): ?>
                <div class="recaptcha-container mb-3">
                    <div class="g-recaptcha" data-sitekey="<?php echo htmlspecialchars($recaptchaSiteKey); ?>"></div>
                </div>
            <?php endif; ?>
            <button type="submit" class="btn btn-success w-100">Login</button>
        </form>
        <p class="text-center mt-3">Don't have an account? <a href="register">Register here</a>.</p>
        <p class="text-center">Forgot your password? <a href="reset_password">Reset it here</a>.</p>
    </div>
</div>
<?php if ($_SESSION['failed_attempts'] >= 3): ?>
    <script src="https://www.google.com/recaptcha/api.js" async defer></script>
<?php endif; ?>
