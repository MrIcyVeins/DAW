<?php
// Afiseaza erori
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

// Include clasele PHPMailer
require '../PHPMailer/Exception.php';
require '../PHPMailer/PHPMailer.php';
require '../PHPMailer/SMTP.php';

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

// Incarca valori din config.php
$config = require __DIR__ . '/../config/config.php';

// Mapeaza valorile cu variabile
$smtpHost = $config['smtp_host'];
$smtpPort = $config['smtp_port'];
$smtpEncryption = $config['smtp_encryption'];
$smtpUsername = $config['smtp_username'];
$smtpPassword = $config['smtp_password'];
$fromEmail = $config['from_email'];
$fromName = $config['from_name'];
$toEmail = ''; // Inlocuieste cu email-ul catre care se trimite testul

// Creaza instanta noua de PHPMailer
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
    $mail->addAddress($toEmail);    // destinatar
    
    // Continut mail
    $mail->isHTML(true);                                  // Seteaza formatul emailului ca HTML
    $mail->Subject = 'Test Email from PHPMailer';
    $mail->Body    = '<h1>This is a Test Email</h1><p>If you received this email, your SMTP configuration is correct.</p>';
    $mail->AltBody = 'This is a Test Email. If you received this email, your SMTP configuration is correct.';
    
    $mail->send();
    echo 'Test email has been sent successfully.';
} catch (Exception $e) {
    echo "Test email could not be sent. Mailer Error: {$mail->ErrorInfo}";
}
