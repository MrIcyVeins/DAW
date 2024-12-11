<?php
// Enable error reporting for debugging (remove in production)
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

// Include PHPMailer classes
require '../PHPMailer/Exception.php';
require '../PHPMailer/PHPMailer.php';
require '../PHPMailer/SMTP.php';

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

// Load configuration from config.php (optional)
// $config = require 'config/config.php';

// Alternatively, define SMTP settings directly here
$smtpHost = 'smtp.mail.yahoo.com';          // Yahoo SMTP host
$smtpPort = 465;                            // SMTP port: 465 for SSL, 587 for TLS
$smtpEncryption = 'ssl';                    // Encryption: 'ssl' or 'tls'
$smtpUsername = '';     // Your Yahoo email address
$smtpPassword = '';        // Your Yahoo App Password
$fromEmail = 'no-reply@yourdomain.com';     // Sender's email address
$fromName = 'YourAppName';                  // Sender's name
$toEmail = '';         // Recipient's email address

// Create a new PHPMailer instance
$mail = new PHPMailer(true);

try {
    // Server settings
    $mail->isSMTP();                                      // Set mailer to use SMTP
    $mail->Host       = $smtpHost;                       // Specify main and backup SMTP servers
    $mail->SMTPAuth   = true;                             // Enable SMTP authentication
    $mail->Username   = $smtpUsername;                   // SMTP username
    $mail->Password   = $smtpPassword;                   // SMTP password
    $mail->SMTPSecure = $smtpEncryption;                 // Enable TLS encryption, `ssl` also accepted
    $mail->Port       = $smtpPort;                       // TCP port to connect to
    
    // Recipients
    $mail->setFrom($fromEmail, $fromName);
    $mail->addAddress($toEmail);                          // Add a recipient
    
    // Content
    $mail->isHTML(true);                                  // Set email format to HTML
    $mail->Subject = 'Test Email from PHPMailer';
    $mail->Body    = '<h1>This is a Test Email</h1><p>If you received this email, your SMTP configuration is correct.</p>';
    $mail->AltBody = 'This is a Test Email. If you received this email, your SMTP configuration is correct.';
    
    $mail->send();
    echo 'Test email has been sent successfully.';
} catch (Exception $e) {
    echo "Test email could not be sent. Mailer Error: {$mail->ErrorInfo}";
}
?>
