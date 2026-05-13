<?php
session_start();
include("../admin/db.php");

// 1. Total Revenue (Sirf 'Completed' orders ka total)
$res_revenue = mysqli_query($conn, "SELECT SUM(total_amount) as total FROM orders WHERE status = 'Completed'");
$row_revenue = mysqli_fetch_assoc($res_revenue);
$total_revenue = $row_revenue['total'] ?? 0;

// 2. Total Orders count
$res_orders = mysqli_query($conn, "SELECT COUNT(id) as total_orders FROM orders");
$row_orders = mysqli_fetch_assoc($res_orders);
$total_orders = $row_orders['total_orders'] ?? 0;

// 3. Today's Sales
$today = date('Y-m-d');
$res_today = mysqli_query($conn, "SELECT SUM(total_amount) as today_total FROM orders WHERE DATE(order_date) = '$today' AND status = 'Completed'");
$row_today = mysqli_fetch_assoc($res_today);
$today_sales = $row_today['today_total'] ?? 0;

// 4. Monthly Sales Data (For a simple list)
$monthly_sql = "SELECT MONTHNAME(order_date) as month, SUM(total_amount) as amount 
                FROM orders 
                WHERE status = 'Completed' 
                GROUP BY MONTH(order_date) 
                ORDER BY MONTH(order_date) DESC";
$monthly_res = mysqli_query($conn, $monthly_sql);
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
    <title>Sales Reports - Admin</title>
</head>

<body class="bg-light">

    <div class="container my-5">
        <div class="d-flex justify-content-between align-items-center mb-4">
            <h2><i class="fa-solid fa-chart-line text-primary"></i> Sales & Revenue Reports</h2>
            <a href="index.php" class="btn btn-secondary btn-sm">Back to Dashboard</a>
        </div>

        <div class="row g-3 mb-5">
            <div class="col-md-4">
                <div class="card border-0 shadow-sm bg-primary text-white p-3">
                    <div class="card-body">
                        <h5>Total Revenue</h5>
                        <h3>₹<?= number_format($total_revenue, 2); ?></h3>
                        <small>From all completed orders</small>
                    </div>
                </div>
            </div>
            <div class="col-md-4">
                <div class="card border-0 shadow-sm bg-success text-white p-3">
                    <div class="card-body">
                        <h5>Today's Sales</h5>
                        <h3>₹<?= number_format($today_sales, 2); ?></h3>
                        <small><?= date('d M, Y'); ?></small>
                    </div>
                </div>
            </div>
            <div class="col-md-4">
                <div class="card border-0 shadow-sm bg-dark text-white p-3">
                    <div class="card-body">
                        <h5>Total Orders</h5>
                        <h3><?= $total_orders; ?></h3>
                        <small>Lifetime orders placed</small>
                    </div>
                </div>
            </div>
        </div>

        <div class="card border-0 shadow-sm">
            <div class="card-header bg-white fw-bold">Monthly Revenue Breakdown</div>
            <div class="card-body p-0">
                <table class="table table-hover mb-0">
                    <thead class="table-light">
                        <tr>
                            <th class="ps-3">Month</th>
                            <th>Total Revenue</th>
                            <th>Status</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php while ($m = mysqli_fetch_assoc($monthly_res)): ?>
                            <tr>
                                <td class="ps-3 fw-bold"><?= $m['month']; ?></td>
                                <td>₹<?= number_format($m['amount'], 2); ?></td>
                                <td><span class="badge bg-success">Settled</span></td>
                            </tr>
                        <?php endwhile; ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>

</body>

</html>