<?php include '../views/partials/header.php'; ?>
<?php include '../analytics/report_analytics.php'; ?>

<div class="container">
    <h2>Reports</h2>
    <a href="../controllers/reports.php" class="btn">Export Analytics Report (CSV)</a>
    <div id="report_data">
        <!-- Report data dynamically loaded -->
    </div>
</div>

<?php include '../views/partials/footer.php'; ?>
