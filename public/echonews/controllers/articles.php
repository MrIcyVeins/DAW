<?php
include '../config/db.php';
include '../config/session.php';

if (isAdmin() && $_SERVER['REQUEST_METHOD'] === 'POST') {
    $action = $_POST['action'];
    if ($action == 'add') {
        $title = htmlspecialchars($_POST['title']);
        $content = htmlspecialchars($_POST['content']);

        $stmt = $conn->prepare("INSERT INTO articles (title, content) VALUES (?, ?)");
        $stmt->execute([$title, $content]);

        header("Location: ../views/admin_dashboard.php");
    }

    if ($action == 'delete') {
        $id = $_POST['id'];
        $stmt = $conn->prepare("DELETE FROM articles WHERE id = ?");
        $stmt->execute([$id]);
        header("Location: ../views/admin_dashboard.php");
    }
}
?>
