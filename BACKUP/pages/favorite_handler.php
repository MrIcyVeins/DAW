<?php
session_start();
require_once "../database/db_connect.php";

if (!isset($_SESSION['user_id'])) {
    echo json_encode(['status' => 'error', 'message' => 'User not logged in']);
    exit();
}

$userId = $_SESSION['user_id'];
$articleId = $_POST['article_id'] ?? '';
$title = $_POST['title'] ?? '';
$link = $_POST['link'] ?? '';

if (empty($articleId) || empty($title) || empty($link)) {
    echo json_encode(['status' => 'error', 'message' => 'Invalid data']);
    exit();
}

$stmt = $conn->prepare("SELECT 1 FROM favorites WHERE user_id = ? AND article_id = ?");
$stmt->bind_param("is", $userId, $articleId);
$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows > 0) {
    $stmt = $conn->prepare("DELETE FROM favorites WHERE user_id = ? AND article_id = ?");
    $stmt->bind_param("is", $userId, $articleId);
    $stmt->execute();
    echo json_encode(['status' => 'unfavorited']);
} else {
    $stmt = $conn->prepare("INSERT INTO favorites (user_id, article_id, title, link) VALUES (?, ?, ?, ?)");
    $stmt->bind_param("isss", $userId, $articleId, $title, $link);
    $stmt->execute();
    echo json_encode(['status' => 'favorited']);
}
exit();
