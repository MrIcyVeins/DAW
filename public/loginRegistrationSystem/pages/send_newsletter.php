<?php
session_start();
require_once "../database/db_connect.php";

// Protect this script so only admins can access it (optional)
if (!isset($_SESSION['is_admin']) || $_SESSION['is_admin'] !== true) {
    die("Access denied.");
}

// Include PHPMailer
require '../PHPMailer/Exception.php';
require '../PHPMailer/PHPMailer.php';
require '../PHPMailer/SMTP.php';

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

// Load configuration
$config = require __DIR__ . '/../config/config.php';

// Map SMTP configuration
$smtpHost = $config['smtp_host'];
$smtpPort = $config['smtp_port'];
$smtpEncryption = $config['smtp_encryption'];
$smtpUsername = $config['smtp_username'];
$smtpPassword = $config['smtp_password'];
$fromEmail = $config['from_email'];
$fromName = $config['from_name'];

// Define the newsletter content
$newsletterSubject = "Our Latest Updates!";
$newsletterBody = "
    <h1>Welcome to Our Newsletter!</h1>
    <p>We are excited to share our latest updates with you. Stay tuned for more great content!</p>
    <p>Best regards,<br>The Team</p>
";

try {
    // Fetch all subscribers
    $stmt = $conn->prepare("SELECT email FROM newsletter_subscribers");
    $stmt->execute();
    $result = $stmt->get_result();

    // Initialize PHPMailer
    $mail = new PHPMailer(true);
    $mail->isSMTP();
    $mail->Host = $smtpHost;
    $mail->SMTPAuth = true;
    $mail->Username = $smtpUsername;
    $mail->Password = $smtpPassword;
    $mail->SMTPSecure = $smtpEncryption;
    $mail->Port = $smtpPort;

    // Set sender info
    $mail->setFrom($fromEmail, $fromName);

    // Loop through subscribers and send emails
    while ($row = $result->fetch_assoc()) {
        $mail->clearAddresses(); // Clear previous recipient
        $mail->addAddress($row['email']);
        $mail->isHTML(true);
        $mail->Subject = $newsletterSubject;
        $mail->Body = $newsletterBody;

        try {
            $mail->send();
        } catch (Exception $e) {
            echo "Failed to send to {$row['email']}: {$mail->ErrorInfo}<br>";
        }
    }

    echo "Newsletter sent successfully!";
} catch (Exception $e) {
    echo "Error: " . $e->getMessage();
}
