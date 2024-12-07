<?php
include '../config/db.php';

if (isAdmin()) {
    $stmt = $conn->query("SELECT * FROM analytics");
    $data = $stmt->fetchAll(PDO::FETCH_ASSOC);

    $csv = fopen("../uploads/analytics.csv", "w");
    foreach ($data as $row) {
        fputcsv($csv, $row);
    }
    fclose($csv);

    echo "CSV exported to /uploads/analytics.csv";
}
?>
