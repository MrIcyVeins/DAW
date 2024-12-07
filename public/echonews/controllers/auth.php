<?php
include '../config/db.php';
include '../config/session.php';

// Function to check if the password is breached (HIBP API)
function isPasswordPwned($password) {
    $sha1 = strtoupper(sha1($password));
    $prefix = substr($sha1, 0, 5);
    $suffix = substr($sha1, 5);

    $url = "https://api.pwnedpasswords.com/range/$prefix";
    $response = file_get_contents($url);

    // Check if the suffix is in the response
    return strpos($response, $suffix) !== false;
}

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $action = $_POST['action'];

    // User Registration
    if ($action === 'register') {
        $username = htmlspecialchars($_POST['username']);
        $password = $_POST['password'];
        $role = $_POST['role'];

        // Check if the password is compromised
        if (isPasswordPwned($password)) {
            die("This password has been compromised in a data breach. Please choose a different one.");
        }

        // Password strength validation (server-side)
        if (!preg_match('/^(?=.*[A-Z])(?=.*\d)(?=.*[\W_]).{8,}$/', $password)) {
            die("Password must include at least 8 characters, one uppercase letter, one number, and one special character.");
        }

        // Hash the password before storing it
        $hashedPassword = password_hash($password, PASSWORD_DEFAULT);

        // Insert the new user into the database
        $stmt = $conn->prepare("INSERT INTO users (username, password, role) VALUES (?, ?, ?)");
        $stmt->execute([$username, $hashedPassword, $role]);

        // Redirect to the login page after successful registration
        header("Location: ../views/login.php");
        exit();
    }

    // User Login
    if ($action === 'login') {
        $username = $_POST['username'];
        $password = $_POST['password'];

        // Fetch the user from the database
        $stmt = $conn->prepare("SELECT * FROM users WHERE username = ?");
        $stmt->execute([$username]);
        $user = $stmt->fetch();

        // Verify the entered password against the stored hash
        if ($user && password_verify($password, $user['password'])) {
            // Start session and store user information
            $_SESSION['user'] = $user;

            // Redirect to the appropriate dashboard
            header("Location: ../views/" . ($user['role'] === 'admin' ? "admin_dashboard.php" : "user_dashboard.php"));
            exit();
        } else {
            echo "Invalid credentials.";
        }
    }
}
?>
