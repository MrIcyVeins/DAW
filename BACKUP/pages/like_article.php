<?php
session_start();
require_once "../database/db_connect.php";

// Include header and navbar
include "../includes/header.php";
include "../includes/navbar.php";

// RSS Feed URL
$feedUrl = "https://feeds.bbci.co.uk/news/world/rss.xml";
$rssContent = @simplexml_load_file($feedUrl);

// Articles array
$articles = [];
if ($rssContent && isset($rssContent->channel->item)) {
    foreach ($rssContent->channel->item as $item) {
        $title       = (string) $item->title;
        $link        = (string) $item->link;
        $description = strip_tags((string) $item->description);
        $pubDate     = (string) $item->pubDate;

        // Generate a unique ID for each article
        $articleId = md5($title);

        $articles[] = [
            'id'          => $articleId,
            'title'       => $title,
            'link'        => $link,
            'description' => $description,
            'pubDate'     => $pubDate
        ];
    }
}

// Sort articles by date (newest first)
usort($articles, function ($a, $b) {
    return strtotime($b['pubDate']) - strtotime($a['pubDate']);
});

// Pagination
$articlesPerPage = 6;
$totalArticles   = count($articles);
$totalPages      = ceil($totalArticles / $articlesPerPage);
$page            = isset($_GET['page']) ? (int) $_GET['page'] : 1;
if ($page < 1) {
    $page = 1;
} elseif ($page > $totalPages) {
    $page = $totalPages;
}
$startIndex      = ($page - 1) * $articlesPerPage;
$displayArticles = array_slice($articles, $startIndex, $articlesPerPage);

// Helper Functions
function hasLiked($conn, $userId, $articleId) {
    $stmt = $conn->prepare("SELECT 1 FROM likes WHERE user_id = ? AND article_id = ?");
    $stmt->bind_param("is", $userId, $articleId);
    $stmt->execute();
    return $stmt->get_result()->num_rows > 0;
}

function getLikeCount($conn, $articleId) {
    $stmt = $conn->prepare("SELECT COUNT(*) as like_count FROM likes WHERE article_id = ?");
    $stmt->bind_param("s", $articleId);
    $stmt->execute();
    $result = $stmt->get_result()->fetch_assoc();
    return $result['like_count'] ?? 0;
}
?>
<div class="container mt-5">
    <h2 class="mb-4 text-center" style="font-family: 'Times New Roman', serif;">World News &amp; Politics</h2>
    <p class="text-center" style="font-style: italic;">Get the latest updates from around the globe.</p>

    <div class="row row-cols-1 row-cols-md-2 g-4">
        <?php if (empty($displayArticles)): ?>
            <div class="col">
                <div class="alert alert-warning">No articles found on this page.</div>
            </div>
        <?php else: ?>
            <?php foreach ($displayArticles as $article): ?>
                <div class="col">
                    <div class="card h-100 shadow-sm p-3" style="font-family: 'Georgia', serif;">
                        <div class="card-body">
                            <h5 class="card-title" style="font-weight: bold;">
                                <?= htmlspecialchars($article['title']) ?>
                            </h5>
                            <h6 class="card-subtitle mb-2 text-muted">
                                <?= date('F j, Y, g:i a', strtotime($article['pubDate'])) ?>
                            </h6>
                            <p class="card-text">
                                <?= htmlspecialchars($article['description']) ?>
                            </p>
                        </div>
                        <div class="card-footer text-end d-flex justify-content-between">
                            <form method="post" action="like_article.php">
                                <input type="hidden" name="article_id" value="<?= $article['id'] ?>">
                                <button type="submit" class="btn btn-sm btn-light like-btn" style="color: #555;">
                                    <?php if (isset($_SESSION['user_id']) && hasLiked($conn, $_SESSION['user_id'], $article['id'])): ?>
                                        ❤️ Liked
                                    <?php else: ?>
                                        🤍 Like
                                    <?php endif; ?>
                                </button>
                            </form>
                            <span class="text-muted small">
                                <?= getLikeCount($conn, $article['id']) ?> Likes
                            </span>
                            <a href="<?= htmlspecialchars($article['link']) ?>" 
                               class="btn btn-sm btn-light" 
                               target="_blank">
                                Read more
                            </a>
                        </div>
                    </div>
                </div>
            <?php endforeach; ?>
        <?php endif; ?>
    </div>
</div>
