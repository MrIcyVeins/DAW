<?php
use PHPMailer\PHPMailer\PHPMailer;

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $email = htmlspecialchars($_POST['email']);
    $message = htmlspecialchars($_POST['message']);

    require '../vendor/autoload.php';
    $mail = new PHPMailer(true);

    try {
        $mail->setFrom($email);
        $mail->addAddress("admin@echonews.com");
        $mail->Subject = "Contact Form Submission";
        $mail->Body = $message;
        $mail->send();
        echo "Message sent!";
    } catch (Exception $e) {
        echo "Message could not be sent. Error: {$mail->ErrorInfo}";
    }
}
?>
