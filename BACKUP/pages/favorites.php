<?php
session_start();
require_once "../database/db_connect.php";

if (!isset($_SESSION['user_id'])) {
    header("Location: /pages/login.php");
    exit();
}

$userId = $_SESSION['user_id'];

$stmt = $conn->prepare("SELECT * FROM favorites WHERE user_id = ?");
$stmt->bind_param("i", $userId);
$stmt->execute();
$result = $stmt->get_result();

$favorites = [];
while ($row = $result->fetch_assoc()) {
    $favorites[] = $row;
}

include "../includes/header.php";
include "../includes/navbar.php";

// Function to remove a favorite
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['remove_favorite'])) {
    $articleId = $_POST['article_id'];

    $stmt = $conn->prepare("DELETE FROM favorites WHERE user_id = ? AND article_id = ?");
    $stmt->bind_param("is", $userId, $articleId);

    if ($stmt->execute()) {
        echo "<script>alert('Favorite removed successfully.'); window.location.href='favorites.php';</script>";
    } else {
        echo "<script>alert('Failed to remove favorite.');</script>";
    }
}
?>

<div class="container mt-5">
    <h2 class="mb-4 text-center" style="font-family: 'Times New Roman', serif;">Your Favorites</h2>
    <div class="row row-cols-1 row-cols-md-2 g-4">
        <?php if (empty($favorites)): ?>
            <div class="col">
                <div class="alert alert-warning">No favorites yet!</div>
            </div>
        <?php else: ?>
            <?php foreach ($favorites as $favorite): ?>
                <div class="col">
                    <div class="card h-100 shadow-sm" style="font-family: 'Georgia', serif;">
                        <div class="card-body">
                            <h5 class="card-title" style="font-weight: bold;">
                                <a href="<?= htmlspecialchars($favorite['link']) ?>" target="_blank" style="text-decoration: none; color: inherit;">
                                    <?= htmlspecialchars($favorite['title']) ?>
                                </a>
                            </h5>
                        </div>
                        <div class="card-footer text-end d-flex justify-content-between align-items-center">
                            <a href="<?= htmlspecialchars($favorite['link']) ?>" 
                               class="btn btn-sm btn-light" 
                               target="_blank">
                                Read more
                            </a>
                            <!-- Remove from Favorites Button -->
                            <form method="POST" style="margin: 0;">
                                <input type="hidden" name="article_id" value="<?= $favorite['article_id'] ?>">
                                <button type="submit" name="remove_favorite" class="btn btn-sm btn-danger">Remove</button>
                            </form>
                        </div>
                    </div>
                </div>
            <?php endforeach; ?>
        <?php endif; ?>
    </div>
</div>

<?php include "../includes/footer.php"; ?>
