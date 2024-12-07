<?php
$data = file_get_contents("https://api.example.com/news");
$parsedData = json_decode($data, true);

// Display parsed data on the webpage
foreach ($parsedData as $item) {
    echo "<h3>" . htmlspecialchars($item['title']) . "</h3>";
    echo "<p>" . htmlspecialchars($item['summary']) . "</p>";
}
?>
