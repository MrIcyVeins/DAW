<?php
session_start();
require_once "../database/db_connect.php";

// Incarca valori din config.php
$config = require __DIR__ . '/../config/config.php';

// Incarca librarii PHPMailer

require '../PHPMailer/Exception.php';
require '../PHPMailer/PHPMailer.php';
require '../PHPMailer/SMTP.php';

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

// Mapeaza valorile cu variabile
$smtpHost = $config['smtp_host'];
$smtpPort = $config['smtp_port'];
$smtpEncryption = $config['smtp_encryption'];
$smtpUsername = $config['smtp_username'];
$smtpPassword = $config['smtp_password'];
$fromEmail = $config['from_email'];
$fromName = $config['from_name'];
$toEmail = ''; // Inlocuieste cu email-ul catre care se trimite testul

if (isset($_SESSION['email'])) {
    header("Location: dashboard.php");
    exit();
}

$error = "";

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $email = trim($_POST['email']);
    $password = $_POST['password'];
    $confirm_password = $_POST['confirm_password'];
    /* Tipar regex pentru parola 
    https://regex101.com/
    Parola trebuie sa contina:
    - macar o litera mica a-z 
    - macar o litera mare A-Z
    - macar un numar 1-9
    - macar un simbol special !@#$%^&*(),.?":{}|<>])[A-Za-z\d!@#$%^&*(),.?":{}|<>
    - lungimea parolei sa fie 8 caractere
    */
    $pattern = '/^(?=.*[a-z])(?=.*[A-Z])(?=.*\d)(?=.*[!@#$%^&*(),.?":{}|<>])[A-Za-z\d!@#$%^&*(),.?":{}|<>]{8,}$/';

    // Validare parola si confirmare parola
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
                    $error = "Password must have atleast one lowercase letter, one uppercase letter, one digit, one special character and length of atleast 8 characters.";
                } else {
                    // Verifica daca userul exista deja in baza de date
                    $check = $conn->prepare("SELECT id FROM users WHERE email = ?");
                    $check->bind_param("s", $email);
                    $check->execute();
                    $checkRes = $check->get_result();
                    if ($checkRes->num_rows > 0) {
                        $error = "Email already registered.";
                    } else {
                        // Insereaza userul
                        $passwordHash = password_hash($password, PASSWORD_BCRYPT);
                        $stmt = $conn->prepare("INSERT INTO users (email, password_hash) VALUES (?, ?)");
                        $stmt->bind_param("ss", $email, $passwordHash);
                        if ($stmt->execute()) {
                            $newUserId = $stmt->insert_id;
                            
                            // Generate verification token
                            $verificationToken = bin2hex(random_bytes(16));
                            $upd = $conn->prepare("UPDATE users SET verification_token = ? WHERE id = ?");
                            $upd->bind_param("si", $verificationToken, $newUserId);
                            $upd->execute();

                            // Send verification email using PHPMailer
                            $mail = new PHPMailer(true);
                            try {
                                // Setari server
                                $mail->isSMTP();                                     // Seteaza mailer sa foloseasca SMTP
                                $mail->Host       = $smtpHost;                       // Specifica hostul SMTP
                                $mail->SMTPAuth   = true;                            // Initializeaza autentificare in SMTP
                                $mail->Username   = $smtpUsername;                   // Username SMTP
                                $mail->Password   = $smtpPassword;                   // Parola SMTP 
                                $mail->SMTPSecure = $smtpEncryption;                 // Activeaza encriptia
                                $mail->Port       = $smtpPort;                       // port TCP pentru conexiune

                                // Seteaza trimitatorul si destinatarul
                                $mail->setFrom($fromEmail, $fromName); // trimitator
                                $mail->addAddress($email); // destinatar

                                // Continutul emailului
                                $verifyLink = "http://localhost/loginRegistrationSystem/pages/verify.php?token=$verificationToken";
                                $mail->isHTML(true);
                                $mail->Subject = 'Verify Your Email';
                                $mail->Body    = "Thank you for registering.<br>Please verify your email by clicking the link below:<br><a href='$verifyLink'>$verifyLink</a>";
                                
                                $mail->send();
                            } catch (Exception $e) {
                                // If email fails to send, you can log or handle the error
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
        <button type="submit" class="btn btn-success">Register</button>
    </form>
    <p class="mt-2">Already have an account? <a href="login.php">Login here</a>.</p>
</div>

<?php include "../includes/footer.php"; ?>
