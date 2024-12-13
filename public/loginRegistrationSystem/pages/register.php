<?php
session_start();
require_once "../database/db_connect.php";

// Încarcă configurația
$config = require __DIR__ . '/../config/config.php';

// Încarcă librăriile PHPMailer
require '../PHPMailer/Exception.php';
require '../PHPMailer/PHPMailer.php';
require '../PHPMailer/SMTP.php';

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

// Mapează valorile din config în variabile
$smtpHost = $config['smtp_host'];
$smtpPort = $config['smtp_port'];
$smtpEncryption = $config['smtp_encryption'];
$smtpUsername = $config['smtp_username'];
$smtpPassword = $config['smtp_password'];
$fromEmail = $config['from_email'];
$fromName = $config['from_name'];
$recaptchaSiteKey = $config['recaptcha_site_key']; // Site Key reCAPTCHA
$recaptchaSecretKey = $config['recaptcha_secret_key']; // Secret Key reCAPTCHA

// Verifică dacă utilizatorul este deja autentificat
if (isset($_SESSION['email'])) {
    header("Location: dashboard.php");
    exit();
}

$error = "";

// Gestionează trimiterea formularului
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $email = trim($_POST['email']);
    $password = $_POST['password'];
    $confirm_password = $_POST['confirm_password'];
    $recaptchaResponse = $_POST['g-recaptcha-response']; // Răspunsul reCAPTCHA

    /* Tipar regex pentru parola:
    - minim o literă mică (a-z)
    - minim o literă mare (A-Z)
    - minim un număr (0-9)
    - minim un caracter special (!@#$%^&*...)
    - lungime de cel puțin 8 caractere
    */
    $pattern = '/^(?=.*[a-z])(?=.*[A-Z])(?=.*\d)(?=.*[!@#$%^&*(),.?":{}|<>])[A-Za-z\d!@#$%^&*(),.?":{}|<>]{8,}$/';

    // Verificare reCAPTCHA
    if (empty($recaptchaResponse)) {
        $error = "Please complete the reCAPTCHA.";
    } else {
        // Verifică răspunsul reCAPTCHA prin API-ul Google
        $verifyURL = 'https://www.google.com/recaptcha/api/siteverify';
        $data = [
            'secret' => $recaptchaSecretKey,
            'response' => $recaptchaResponse,
            'remoteip' => $_SERVER['REMOTE_ADDR']
        ];

        // Utilizează cURL pentru a verifica răspunsul reCAPTCHA
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
    }

    // Continuă doar dacă reCAPTCHA este valid
    if (empty($error)) {
        // Validare parola și confirmare parola
        if ($password !== $confirm_password) {
            $error = "Passwords do not match.";
        } else {
            // Validarea emailului
            if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
                $error = "Please enter a valid email address.";
            } else {
                $domain = substr(strrchr($email, "@"), 1);
                if (!checkdnsrr($domain, "MX") && !checkdnsrr($domain, "A")) {
                    $error = "The email domain is invalid or cannot receive mail.";
                } else {
                    if (!preg_match($pattern, $password)) {
                        $error = "Password must have at least one lowercase letter, one uppercase letter, one digit, one special character, and a length of at least 8 characters.";
                    } else {
                        // Verifică dacă emailul există deja în baza de date
                        $check = $conn->prepare("SELECT id FROM users WHERE email = ?");
                        $check->bind_param("s", $email);
                        $check->execute();
                        $checkRes = $check->get_result();
                        if ($checkRes->num_rows > 0) {
                            $error = "Email already registered.";
                        } else {
                            // Inserează utilizatorul în baza de date
                            $passwordHash = password_hash($password, PASSWORD_BCRYPT);
                            $stmt = $conn->prepare("INSERT INTO users (email, password_hash) VALUES (?, ?)");
                            $stmt->bind_param("ss", $email, $passwordHash);
                            if ($stmt->execute()) {
                                $newUserId = $stmt->insert_id;
                                
                                // Generează token de verificare
                                $verificationToken = bin2hex(random_bytes(16));
                                $upd = $conn->prepare("UPDATE users SET verification_token = ? WHERE id = ?");
                                $upd->bind_param("si", $verificationToken, $newUserId);
                                $upd->execute();

                                // Trimite email de verificare folosind PHPMailer
                                $mail = new PHPMailer(true);
                                try {
                                    $mail->isSMTP();
                                    $mail->Host       = $smtpHost;
                                    $mail->SMTPAuth   = true;
                                    $mail->Username   = $smtpUsername;
                                    $mail->Password   = $smtpPassword;
                                    $mail->SMTPSecure = $smtpEncryption;
                                    $mail->Port       = $smtpPort;

                                    $mail->setFrom($fromEmail, $fromName);
                                    $mail->addAddress($email);

                                    $verifyLink = "http://localhost/loginRegistrationSystem/pages/verify.php?token=$verificationToken";
                                    $mail->isHTML(true);
                                    $mail->Subject = 'Verify Your Email';
                                    $mail->Body    = "Thank you for registering.<br>Please verify your email by clicking the link below:<br><a href='$verifyLink'>$verifyLink</a>";
                                    
                                    $mail->send();
                                } catch (Exception $e) {
                                    // Loghează eroarea, dacă este cazul
                                }

                                $_SESSION['email'] = $email;
                                header("Location: dashboard.php");
                                exit();
                            } else {
                                $error = "Error registering user.";
                            }
                        }
                    }
                }
            }
        }
    }
}

include "../includes/header.php";
?>

<div class="container mt-5">
    <h2>Register</h2>
    <?php if (!empty($error)): ?>
        <div class="alert alert-danger"><?php echo htmlspecialchars($error); ?></div>
    <?php endif; ?>
    <form method="POST" action="register.php">
        <div class="mb-3">
            <label>Email:</label>
            <input type="email" name="email" class="form-control" required />
        </div>
        <div class="mb-3">
            <label>Password:</label>
            <input type="password" name="password" class="form-control" required />
        </div>
        <div class="mb-3">
            <label>Confirm Password:</label>
            <input type="password" name="confirm_password" class="form-control" required />
        </div>
        <!-- Adaugă widget-ul reCAPTCHA -->
        <div class="g-recaptcha" data-sitekey="<?php echo htmlspecialchars($recaptchaSiteKey); ?>"></div>
        <button type="submit" class="btn btn-success mt-3">Register</button>
    </form>
    <p class="mt-2">Already have an account? <a href="login.php">Login here</a>.</p>
</div>

<!-- Include script-ul API reCAPTCHA -->
<script src="https://www.google.com/recaptcha/api.js" async defer></script>

<?php include "../includes/footer.php"; ?>
