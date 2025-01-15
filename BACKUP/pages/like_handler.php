<?php
session_start();
require_once "../database/db_connect.php";

// Check if the user is logged in
if (!isset($_SESSION['user_id'])) {
    echo json_encode(['status' => 'error', 'message' => 'User not logged in']);
    exit();
}

$userId = $_SESSION['user_id'];
$articleId = $_POST['article_id'] ?? '';

if (empty($articleId)) {
    echo json_encode(['status' => 'error', 'message' => 'Invalid article ID']);
    exit();
}

// Check if the user already liked the article
$stmt = $conn->prepare("SELECT 1 FROM likes WHERE user_id = ? AND article_id = ?");
$stmt->bind_param("is", $userId, $articleId);
$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows > 0) {
    // User already liked the article; remove the like
    $stmt = $conn->prepare("DELETE FROM likes WHERE user_id = ? AND article_id = ?");
    $stmt->bind_param("is", $userId, $articleId);
    $stmt->execute();
    echo json_encode(['status' => 'unliked']);
} else {
    // Add the like
    $stmt = $conn->prepare("INSERT INTO likes (user_id, article_id) VALUES (?, ?)");
    $stmt->bind_param("is", $userId, $articleId);
    $stmt->execute();
    echo json_encode(['status' => 'liked']);
}

exit();
