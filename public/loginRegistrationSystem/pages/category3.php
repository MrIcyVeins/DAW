<?php
session_start();
require_once "../database/db_connect.php";

// Include header and navbar
include "../includes/header.php";
include "../includes/navbar.php";
?>

<div class="container mt-5">
    <h2>Category 1</h2>
    <p>Explore content in this category. <a href="register.php">Register</a> to unlock exclusive features!</p>
</div>

<?php include "../includes/footer.php"; ?>
