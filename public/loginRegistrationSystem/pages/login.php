<?php
// login.php

session_start();
require_once "../database/db_connect.php";

// Încarcă configurația
$config = require __DIR__ . '/../config/config.php';

// Atribuie cheile reCAPTCHA din config
$recaptchaSiteKey = $config['recaptcha_site_key'];
$recaptchaSecretKey = $config['recaptcha_secret_key'];

// Dacă utilizatorul este deja autentificat, redirecționează la dashboard
if (isset($_SESSION['email'])) {
    header("Location: dashboard.php");
    exit();
}

// Inițializează sau recuperează numărul de încercări eșuate din sesiune
if (!isset($_SESSION['failed_attempts'])) {
    $_SESSION['failed_attempts'] = 0;
}

// Afișează mesajul de succes după resetarea parolei
if (isset($_SESSION['success_message'])) {
    echo '<div class="alert alert-success">' . htmlspecialchars($_SESSION['success_message']) . '</div>';
    unset($_SESSION['success_message']);
}

// Inițializează mesajul de eroare
$error = "";

// Gestionează trimiterea formularului
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $email = trim($_POST['email']);
    $password = $_POST['password'];
    $recaptchaRequired = $_SESSION['failed_attempts'] >= 3; // Cere reCAPTCHA după 3 încercări eșuate

    if ($recaptchaRequired) {
        // Verifică răspunsul reCAPTCHA
        if (isset($_POST['g-recaptcha-response'])) {
            $recaptchaResponse = $_POST['g-recaptcha-response'];
            $verifyURL = 'https://www.google.com/recaptcha/api/siteverify';

            // Pregătește datele pentru cererea POST
            $data = [
                'secret' => $recaptchaSecretKey,
                'response' => $recaptchaResponse,
                'remoteip' => $_SERVER['REMOTE_ADDR']
            ];

            // Utilizează cURL pentru a face cererea POST
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

    if (empty($error)) {
        // Continuă cu verificarea autentificării
        $stmt = $conn->prepare("SELECT id, password_hash FROM users WHERE email = ?");
        if ($stmt === false) {
            $error = "Database error: Unable to prepare the query.";
        } else {
            $stmt->bind_param("s", $email);
            $stmt->execute();
            $res = $stmt->get_result();

            if ($res->num_rows === 1) {
                $row = $res->fetch_assoc();
                if (password_verify($password, $row['password_hash'])) {
                    // Autentificare reușită
                    session_regenerate_id(true); // Securizează sesiunea
                    $_SESSION['email'] = $email;
                    $_SESSION['failed_attempts'] = 0; // Resetează încercările eșuate
                    header("Location: dashboard.php");
                    exit();
                } else {
                    $error = "Invalid email or password.";
                }
            } else {
                $error = "Invalid email or password.";
            }
        }
    }

    // Incrementază numărul de încercări eșuate dacă autentificarea eșuează
    if (!empty($error)) {
        $_SESSION['failed_attempts']++;
    }
}

include "../includes/header.php";
?>

<div class="container mt-5">
    <h2>Login</h2>
    <?php if (!empty($error)): ?>
        <div class="alert alert-danger"><?php echo htmlspecialchars($error); ?></div>
    <?php endif; ?>
    <form method="POST" action="login.php">
        <div class="mb-3">
            <label>Email:</label>
            <input type="email" name="email" class="form-control" required />
        </div>
        <div class="mb-3">
            <label>Password:</label>
            <input type="password" name="password" class="form-control" required />
        </div>
        <?php if ($_SESSION['failed_attempts'] >= 3): ?>
            <!-- Afișează widget-ul reCAPTCHA v2 după 3 încercări eșuate -->
            <div class="g-recaptcha" data-sitekey="<?php echo htmlspecialchars($recaptchaSiteKey); ?>"></div>
        <?php endif; ?>
        <button type="submit" class="btn btn-success mt-3">Login</button>
    </form>
    <p class="mt-2">Don't have an account? <a href="register.php">Register here</a>.</p>
    <p class="mt-2">Forgot your password? <a href="reset_password.php">Reset it here</a>.</p>
</div>

<!-- Include script-ul API reCAPTCHA doar dacă este necesar -->
<?php if ($_SESSION['failed_attempts'] >= 3): ?>
    <script src="https://www.google.com/recaptcha/api.js" async defer></script>
<?php endif; ?>

<?php include "../includes/footer.php"; ?>
