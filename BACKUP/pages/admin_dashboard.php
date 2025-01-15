<?php

ob_start(); // Start output buffering
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

session_start();
require_once "../database/db_connect.php";
require_once '../jpgraph-4.4.2/src/jpgraph.php';
require_once '../jpgraph-4.4.2/src/jpgraph_pie.php';
require_once '../jpgraph-4.4.2/src/jpgraph_pie3d.php';
require_once '../jpgraph-4.4.2/src/jpgraph_bar.php';
require_once '../jpgraph-4.4.2/src/jpgraph_line.php';

// Check if the user is logged in and is an admin
if (!isset($_SESSION['email']) || !isset($_SESSION['is_admin']) || $_SESSION['is_admin'] != 1) {
    header("Location: ../pages/login");
    exit();
}

include "../includes/header.php";
include "../includes/navbar.php";

// Function to render chart as base64 string
function renderChartToBase64($chartType)
{
    global $conn;

    ob_start(); // Start output buffering for capturing the image

    switch ($chartType) {
        case 'device_pie':
            $query = "SELECT device_type, COUNT(*) as count 
                      FROM analytics 
                      WHERE device_type IS NOT NULL 
                      GROUP BY device_type";
            $result = $conn->query($query);

            if (!$result) {
                error_log("Database query failed: " . $conn->error);
                return '';
            }

            $deviceTypes = [];
            $deviceCounts = [];

            while ($row = $result->fetch_assoc()) {
                $deviceTypes[] = $row['device_type'];
                $deviceCounts[] = $row['count'];
            }

            $pieGraph = new PieGraph(450, 350);
            $pieGraph->SetShadow();

            $piePlot = new PiePlot3D($deviceCounts);
            $piePlot->SetLegends($deviceTypes);
            $piePlot->SetCenter(0.5, 0.5);
            $pieGraph->legend->SetColumns(2);
            $pieGraph->legend->SetFont(FF_FONT1, FS_NORMAL, 10);
            $pieGraph->legend->SetPos(0.5, 0.85, 'center', 'top');
            $pieGraph->Add($piePlot);
            $pieGraph->Stroke(_IMG_HANDLER); // Render image to memory
            break;

        case 'browser_bar':
            $query = "SELECT browser, COUNT(*) as count 
                      FROM analytics 
                      WHERE browser IS NOT NULL 
                      GROUP BY browser";
            $result = $conn->query($query);

            if (!$result) {
                error_log("Database query failed: " . $conn->error);
                return '';
            }

            $browsers = [];
            $browserCounts = [];

            while ($row = $result->fetch_assoc()) {
                $browsers[] = $row['browser'];
                $browserCounts[] = $row['count'];
            }

            $barGraph = new Graph(450, 350);
            $barGraph->SetScale("textlin");
            $barGraph->SetMargin(80, 30, 40, 50);
            $barGraph->xaxis->SetTickLabels($browsers);
            $barGraph->xaxis->title->Set("Browser");
            $barGraph->yaxis->title->Set("Number of Visits");
            $barGraph->yaxis->SetLabelMargin(25);

            $barPlot = new BarPlot($browserCounts);
            $barGraph->Add($barPlot);
            $barGraph->Stroke(_IMG_HANDLER); // Render image to memory
            break;

        case 'visit_line':
            $query = "SELECT DATE(visit_time) as visit_date, COUNT(*) as count 
                      FROM analytics 
                      GROUP BY DATE(visit_time)";
            $result = $conn->query($query);

            if (!$result) {
                error_log("Database query failed: " . $conn->error);
                return '';
            }

            $visitDates = [];
            $visitCounts = [];

            while ($row = $result->fetch_assoc()) {
                $visitDates[] = $row['visit_date'];
                $visitCounts[] = $row['count'];
            }

            $lineGraph = new Graph(450, 350);
            $lineGraph->SetScale("intlin");
            $lineGraph->SetMargin(80, 30, 40, 50);
            $lineGraph->xaxis->SetTickLabels($visitDates);
            $lineGraph->xaxis->title->Set("Date");
            $lineGraph->yaxis->title->Set("Number of Visits");
            $lineGraph->yaxis->SetLabelMargin(25);

            $linePlot = new LinePlot($visitCounts);
            $lineGraph->Add($linePlot);
            $lineGraph->Stroke(_IMG_HANDLER); // Render image to memory
            break;

        default:
            error_log("Invalid chart type requested.");
            return '';
    }

    // Get the image as a base64 string
    $img = ob_get_contents();
    ob_end_clean();
    return 'data:image/png;base64,' . base64_encode($img);
}

?>

<div class="container mt-5">
    <h2 class="text-center mb-4" style="font-family: 'Times New Roman', serif;">Admin Dashboard</h2>
    <div class="row">
        <!-- Device Type Pie Chart -->
        <div class="col-md-6">
            <div class="card shadow-sm">
                <div class="card-body text-center">
                    <h4>Device Type Distribution</h4>
                    <img src="<?php echo renderChartToBase64('device_pie'); ?>" alt="Device Type Pie Chart" class="img-fluid">
                </div>
            </div>
        </div>
        <!-- Browser Bar Chart -->
        <div class="col-md-6">
            <div class="card shadow-sm">
                <div class="card-body text-center">
                    <h4>Browser Usage Distribution</h4>
                    <img src="<?php echo renderChartToBase64('browser_bar'); ?>" alt="Browser Bar Chart" class="img-fluid">
                </div>
            </div>
        </div>
    </div>

    <div class="row mt-4">
        <!-- Visits Over Time Line Chart -->
        <div class="col-md-12">
            <div class="card shadow-sm">
                <div class="card-body text-center">
                    <h4>Visits Over Time</h4>
                    <img src="<?php echo renderChartToBase64('visit_line'); ?>" alt="Visits Over Time Line Chart" class="img-fluid">
                </div>
            </div>
        </div>
    </div>
</div>

<?php include "../includes/footer.php"; ?>
