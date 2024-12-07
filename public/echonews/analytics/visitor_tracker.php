<?php
include '../config/db.php';

$ip = $_SERVER['REMOTE_ADDR'];
$page = $_SERVER['PHP_SELF'];

$stmt = $conn->prepare("INSERT INTO analytics (page, visitor_ip) VALUES (?, ?)");
$stmt->execute([$page, $ip]);
?>
