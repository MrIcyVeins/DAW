<?php
// Start session if not already started
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Echo News Magazine</title>
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Custom CSS -->
    <link rel="stylesheet" href="/loginRegistrationSystem/css/style.css">
</head>
<body>
    <!-- Centered Logo -->
    <div class="logo-container text-center my-4">
        <a href="/loginRegistrationSystem/pages/dashboard.php">
            <img src="/loginRegistrationSystem/assets/logo.png" alt="EchoNews Logo" class="site-logo">
        </a>
    </div>
