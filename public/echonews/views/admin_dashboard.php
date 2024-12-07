<?php include '../views/partials/header.php'; ?>
<div class="container">
    <h1>Admin Dashboard</h1>
    <h2>Manage Articles</h2>
    <form method="POST" action="../controllers/articles.php">
        <input type="hidden" name="action" value="add">
        <input type="text" name="title" placeholder="Title" required>
        <textarea name="content" placeholder="Content" required></textarea>
        <button type="submit">Add Article</button>
    </form>

    <h2>Existing Articles</h2>
    <?php
    $stmt = $conn->query("SELECT * FROM articles");
    while ($article = $stmt->fetch()): ?>
        <div>
            <h3><?php echo htmlspecialchars($article['title']); ?></h3>
            <form method="POST" action="../controllers/articles.php">
                <input type="hidden" name="action" value="delete">
                <input type="hidden" name="id" value="<?php echo $article['id']; ?>">
                <button type="submit">Delete</button>
            </form>
        </div>
    <?php endwhile; ?>
</div>

<?php include '../views/partials/footer.php'; ?>
