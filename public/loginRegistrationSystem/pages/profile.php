<?php
session_start();
require_once "../database/db_connect.php";

if (!isset($_SESSION['email'])) {
    header("Location: login.php");
    exit();
}

$userEmail = $_SESSION['email'];

include "../includes/header_simple.php";
?>


<?php include "../includes/footer.php"; ?>
