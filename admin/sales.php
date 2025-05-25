<!DOCTYPE html>
<html lang="en">
<head>
   <meta charset="UTF-8">
   <meta http-equiv="X-UA-Compatible" content="IE=edge">
   <meta name="viewport" content="width=device-width, initial-scale=1.0">
   <title>Admin Panel</title>

   <!-- font awesome cdn link  -->
   <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">

   <!-- custom admin css file link  -->
   <link rel="stylesheet" href="../css/admin_style.css">

</head>
<style>
    html, h1, h2, h3, h4, p, ul, li, table {
    margin: 0;
    padding: 0;
}

body {
    font-family: 'Arial', sans-serif;
    line-height: 1.6;
}

/* Dashboard styles */
.sales {
    margin: 20px;
}

.title {
    font-size: 40px;
    margin-bottom: 10px;
    margin-top: -15px;
}

.report-summary, .completed-orders {
    margin-bottom: 20px;
}

/* Sales Report styles */
.report-summary h3 {
    font-size: 26px;
    margin-bottom: 10px;
    margin-left: 75px;
}
.completed-orders h4 {
    font-size: 26px;
    margin-bottom: 10px;
    margin-left: 75px;
}

.report-summary p {
    margin-bottom: 5px;
    margin-left: 75px;
    font-size: 20px;
}
form {
        margin-bottom: 20px;
        margin-left: 75px;
    }

    label {
        font-size: 20px;
        margin-right: 10px;
    }

    select {
        font-size: 18px;
        padding: 8px;
    }

/* Detailed Sales Data table styles */
table {
    border-color: #000;
    width: 85%;
    border-collapse: collapse;
    margin-top: 10px;
    margin-left: 70px;
}

table, th, td {
    border: 1px solid #ddd;
}

th, td {
    padding: 14px;
    text-align: center;
    font-size: 16px;
}

th {
    background-color: #4834d4;
    color: #fff;
    text-align: center;
    font-size: 16px;
}

/* Responsive styles */
@media only screen and (max-width: 600px) {
    .title {
        font-size: 24px;
    }

    th, td {
        font-size: 16px;
    }
}
</style>
<body>
<?php
include '../components/connect.php';

session_start();
if (!isset($_SESSION['admin_id'])) {
    header('location: login.php');
    exit();
}

$admin_id = $_SESSION['admin_id'];

// Assuming $conn is your database connection
// Replace the column names based on your actual table structure
$startDate = '2024-01-01'; // Replace with your start date
$endDate = '2024-01-31';   // Replace with your end date
$detailedSalesData = getDetailedSalesData($conn, $startDate, $endDate);
$completedOrders = getCompletedOrders($conn);

// Function to get total sales for a given period
function getTotalSales($conn, $startDate, $endDate) {
    $query = "SELECT SUM(total_price) as total_amount
              FROM orders
              WHERE payment_status = 'completed'
                AND placed_on BETWEEN :startDate AND :endDate";
    $stmt = $conn->prepare($query);
    $stmt->bindParam(':startDate', $startDate);
    $stmt->bindParam(':endDate', $endDate);
    $stmt->execute();
    $row = $stmt->fetch(PDO::FETCH_ASSOC);
    return $row['total_amount'];
}

// Get the selected report type from the form
$reportType = isset($_POST['report_type']) ? $_POST['report_type'] : 'daily';

// Get the current date
$currentDate = date('Y-m-d');

// Set the start and end date based on the selected report type
switch ($reportType) {
    case 'daily':
        $startDate = $currentDate;
        $endDate = $currentDate;
        break;
    case 'weekly':
        $startDate = date('Y-m-d', strtotime('-1 week', strtotime($currentDate)));
        $endDate = $currentDate;
        break;
    case 'monthly':
        $startDate = date('Y-m-d', strtotime('-1 month', strtotime($currentDate)));
        $endDate = $currentDate;
        break;
    case 'quarterly':
        $currentQuarter = ceil(date('n') / 3); // Determine the current quarter
        $startMonth = ($currentQuarter - 1) * 3 + 1; // Start month of the quarter
        $startDate = date('Y-m-d', mktime(0, 0, 0, $startMonth, 1, date('Y')));
        $endDate = date('Y-m-d', strtotime('+2 months', strtotime($startDate)));
            break;
    default:
        $startDate = $currentDate;
        $endDate = $currentDate;
}

function getDetailedSalesData($conn, $startDate, $endDate) {
    $query = "SELECT user_id, 
                     SUM(total_products) as total_products, 
                     SUM(total_price) as total_amount
              FROM orders
              WHERE placed_on BETWEEN '$startDate' AND '$endDate'
              GROUP BY user_id";
    $result = $conn->query($query);
    $result = $conn->query($query);
    $data = $result->fetchAll(PDO::FETCH_ASSOC);
    return $data;
}

function getCompletedOrders($conn) {
    $query = "SELECT * FROM orders WHERE payment_status = 'completed'";
    $result = $conn->query($query);
    $data = $result->fetchAll(PDO::FETCH_ASSOC);
    return $data;
}

// Get detailed sales data for the selected period
$detailedSalesData = getDetailedSalesData($conn, $startDate, $endDate);

// Get total sales for the selected period
$totalSales = getTotalSales($conn, $startDate, $endDate);
?>

<?php include '../components/admin_header.php' ?>

<!-- admin dashboard section starts  -->
<section class="dashboard">
    <h1 class="title">Sales</h1>

    <!-- Add a form with a dropdown to select the report type -->
    <form method="post" action="">
        <label for="report_type">Select Report Type:</label>
        <select id="report_type" name="report_type" onchange="this.form.submit()">
            <option value="daily" <?php echo ($reportType === 'daily') ? 'selected' : ''; ?>>Daily</option>
            <option value="weekly" <?php echo ($reportType === 'weekly') ? 'selected' : ''; ?>>Weekly</option>
            <option value="monthly" <?php echo ($reportType === 'monthly') ? 'selected' : ''; ?>>Monthly</option>
            <option value="quarterly" <?php echo ($reportType === 'quarterly') ? 'selected' : ''; ?>>Quarterly</option>
        </select>
    </form>

    <div class="report-summary">
        <h3>Sales Report</h3>
        <p>Report Type: <?php echo ucfirst($reportType); ?></p>
        <p>Period: <?php echo $startDate . ' to ' . $endDate; ?></p>
        <p>Total Sales: ₱<?php echo number_format($totalSales, 2); ?></p>
    </div>

    <div class="completed-orders">
        <h4>Completed Orders</h4>
        <table style="border-color: #000;">
            <tr>
                <th>Order ID</th>
                <th>User ID</th>
                <th>Total Products(Quantity)</th>
                <th>Total Price</th>
                <th>Placed On</th>
            </tr>
            <?php foreach ($completedOrders as $order) : ?>
                <tr>
                    <td><?php echo $order['id']; ?></td>
                    <td><?php echo $order['user_id']; ?></td>
                    <td><?php echo $order['total_products']; ?></td>
                    <td>₱<?php echo number_format($order['total_price'], 2); ?></td>
                    <td><?php echo $order['placed_on']; ?></td>
                </tr>
            <?php endforeach; ?>
        </table>
    </div>

</section>
<script src="js/admin_script.js"></script>
</body>
</html>
