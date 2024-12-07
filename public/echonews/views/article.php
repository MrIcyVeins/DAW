<?php include '../views/partials/header.php'; ?>
<?php
$id = $_GET['id'];
$stmt = $conn->prepare("SELECT * FROM articles WHERE id = ?");
$stmt->execute([$id]);
$article = $stmt->fetch();
?>

<div class="container">
    <h1><?php echo htmlspecialchars($article['title']); ?></h1>
    <p><?php echo htmlspecialchars($article['content']); ?></p>
</div>

<?php include '../views/partials/footer.php'; ?>
