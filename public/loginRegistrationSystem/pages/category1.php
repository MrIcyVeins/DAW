<?php
session_start();
if (!isset($_SESSION['email'])) {
    header("Location: login.php");
    exit();
}

include "../includes/header.php";
include "../includes/navbar.php";
?>

<div class="container mt-5">
    <h2>Category 1</h2>
    <p>Content for Category 1 goes here.</p>
</div>

<?php include "../includes/footer.php"; ?>
