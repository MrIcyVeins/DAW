<?php
session_start();
require_once "../database/db_connect.php";

// Include librarii PHPMailer
require '../PHPMailer/Exception.php';
require '../PHPMailer/PHPMailer.php';
require '../PHPMailer/SMTP.php';

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

// Incarca cofiguratia
$config = require __DIR__ . '/../config/config.php';

// Mapeaza valori din configuratie in variabile
$smtpHost = $config['smtp_host'];
$smtpPort = $config['smtp_port'];
$smtpEncryption = $config['smtp_encryption'];
$smtpUsername = $config['smtp_username'];
$smtpPassword = $config['smtp_password'];
$fromEmail = $config['from_email'];
$fromName = $config['from_name'];

$error = "";
$success = "";
$token = isset($_GET['token']) ? $_GET['token'] : "";
$pattern = '/^(?=.*[a-z])(?=.*[A-Z])(?=.*\d)(?=.*[!@#$%^&*(),.?":{}|<>])[A-Za-z\d!@#$%^&*(),.?":{}|<>]{8,}$/';

// Manage requesturi POST
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (isset($_POST['email']) && empty($token)) {
        // Userul a facut request pentru un link de reset
        $email = trim($_POST['email']);

        // Verifica daca emailul exista
        $stmt = $conn->prepare("SELECT id FROM users WHERE email = ?");
        $stmt->bind_param("s", $email);
        $stmt->execute();
        $res = $stmt->get_result();

        if ($res->num_rows === 1) {
            // Genereaza token pentru reset
            $resetToken = bin2hex(random_bytes(16));

            // Sterge token existent pentru acest email
            $del = $conn->prepare("DELETE FROM password_resets WHERE email = ?");
            $del->bind_param("s", $email);
            $del->execute();

            // Insereaza noul token pentru reset
            $ins = $conn->prepare("INSERT INTO password_resets (email, token) VALUES (?, ?)");
            $ins->bind_param("ss", $email, $resetToken);

            if ($ins->execute()) {
                // Trimite email cu PHPMailer
                $mail = new PHPMailer(true);
                try {
                    // Setari SMTP
                    $mail->isSMTP();
                    $mail->Host       = $smtpHost;
                    $mail->SMTPAuth   = true;
                    $mail->Username   = $smtpUsername;
                    $mail->Password   = $smtpPassword;
                    $mail->SMTPSecure = $smtpEncryption;
                    $mail->Port       = $smtpPort;

                    // Trimitator si destinatar
                    $mail->setFrom($fromEmail, $fromName);
                    $mail->addAddress($email);

                    // Continut email
                    $resetLink = "http://localhost/loginRegistrationSystem/pages/reset_password.php?token=$resetToken";
                    $mail->isHTML(true);
                    $mail->Subject = 'Reset Your Password';
                    $mail->Body    = "You requested a password reset. Click the link below to reset your password:<br><a href='$resetLink'>$resetLink</a>";

                    // Trimite email
                    $mail->send();
                    $success = "A password reset link has been sent to your email.";
                    // Redirectioneaza catre pagina de login cu mesaj de success
                    session_start();
                    $_SESSION['success_message'] = "A password reset link has been sent to your email. Please check your inbox.";
                    header("Location: login.php");
                    exit();
                } catch (Exception $e) {
                    $error = "Failed to send the reset email. Please try again.";
                }
            } else {
                $error = "Error generating reset token.";
            }
        } else {
            $error = "No account found with that email.";
        }
    } elseif (!empty($token) && isset($_POST['new_password']) && isset($_POST['confirm_password'])) {
        // Manage reset parola cu token
        $new_password = $_POST['new_password'];
        $confirm_password = $_POST['confirm_password'];

        if ($new_password !== $confirm_password) {
            $error = "Passwords do not match.";
        } else {
            if (!preg_match($pattern, $new_password)) {
                $error = "Password must have atleast one lowercase letter, one uppercase letter, one digit, one special character and length of atleast 8 characters.";
            } else {
                // Valideaza token
                $stmt = $conn->prepare("SELECT email FROM password_resets WHERE token = ?");
                $stmt->bind_param("s", $token);
                $stmt->execute();
                $res = $stmt->get_result();

                if ($res->num_rows === 1) {
                    $row = $res->fetch_assoc();
                    $email = $row['email'];

                    // Updateaza parola userului
                    $passwordHash = password_hash($new_password, PASSWORD_BCRYPT);
                    $upd = $conn->prepare("UPDATE users SET password_hash = ? WHERE email = ?");
                    $upd->bind_param("ss", $passwordHash, $email);

                    if ($upd->execute()) {
                        // Sterge tokenul folosit
                        $del = $conn->prepare("DELETE FROM password_resets WHERE token = ?");
                        $del->bind_param("s", $token);
                        $del->execute();

                        // Inchide sesiunea si redirectioneaza catre pagina de login
                        session_unset();
                        session_destroy();

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
        <!-- Show form to request reset link -->
        <form method="POST" action="reset_password.php">
            <div class="mb-3">
                <label>Your Email Address:</label>
                <input type="email" name="email" class="form-control" required />
            </div>
            <button type="submit" class="btn btn-success">Send Reset Link</button>
        </form>
    <?php else: ?>
        <!-- Show form to reset password -->
        <form method="POST" action="reset_password.php?token=<?php echo htmlspecialchars($token); ?>">
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
