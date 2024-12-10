<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, initial-scale=1.0">
    <title>My Application</title>
    <!-- Global CSS -->
    <link rel="stylesheet" href="/loginRegistrationSystem/css/style.css">
    <!-- If you want, conditionally include dashboard CSS when on dashboard page -->
    <?php if (basename($_SERVER['PHP_SELF']) === 'dashboard.php'): ?>
        <link rel="stylesheet" href="/loginRegistrationSystem/css/dashboard.css">
    <?php endif; ?>

    <!-- Bootstrap CSS -->
    <link rel="stylesheet"
          href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css">
    <!-- Font Awesome -->
    <link rel="stylesheet"
          href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.css">
    <!-- Favicon -->
    <link rel="shortcut icon" href="https://cdn-icons-png.flaticon.com/512/295/295128.png">
</head>
<body>
