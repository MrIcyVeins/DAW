<?php
$stmt = $conn->query("SELECT page, COUNT(*) as visits FROM analytics GROUP BY page");
echo "<ul>";
while ($row = $stmt->fetch()) {
    echo "<li>Page: " . htmlspecialchars($row['page']) . " - Visits: " . $row['visits'] . "</li>";
}
echo "</ul>";
?>
