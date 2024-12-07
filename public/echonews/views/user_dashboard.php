<?php include '../views/partials/header.php'; ?>
<?php include '../analytics/visitor_tracker.php'; ?>

<div class="container">
    <h1>Welcome, <?php echo $_SESSION['user']['username']; ?>!</h1>
    <p>Here you can explore articles and interact with the platform.</p>

    <h2>Latest Articles</h2>
    <?php
    $stmt = $conn->query("SELECT * FROM articles ORDER BY created_at DESC LIMIT 5");
    while ($article = $stmt->fetch()): ?>
        <div>
            <h3><a href="article.php?id=<?php echo $article['id']; ?>"><?php echo htmlspecialchars($article['title']); ?></a></h3>
            <p><?php echo substr(htmlspecialchars($article['content']), 0, 100) . '...'; ?></p>
        </div>
    <?php endwhile; ?>
</div>

<?php include '../views/partials/footer.php'; ?>
