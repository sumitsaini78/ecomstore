<?php
session_start();
include("db.php");

// Maan lo login ke baad vendor ki ID session mein hai
if (!isset($_SESSION['v_id'])) {
    header("Location: login.php");
    exit;
}

$v_id = $_SESSION['v_id'];

// 1. Total Products Count for this vendor
$res_p = mysqli_query($conn, "SELECT COUNT(id) as total_p FROM products WHERE vendor_id = $v_id");
$total_products = mysqli_fetch_assoc($res_p)['total_p'];

// 2. Total Earnings (Sum of price * qty from order_items for this vendor's products)
// 2. Total Earnings (Sum of p.price * oi.quantity for this vendor's products)
$res_e = mysqli_query($conn, "SELECT SUM(p.price * product_qty) as total_earn 
                              FROM order_items oi 
                              JOIN products p ON oi.product_id = p.id 
                              WHERE p.vendor_id = $v_id");

$fetch_e = mysqli_fetch_assoc($res_e);
$total_earnings = $fetch_e['total_earn'] ?? 0;  

// 3. Pending Orders Count
$res_o = mysqli_query($conn, "SELECT COUNT(DISTINCT oi.order_id) as pending_o 
                              FROM order_items oi 
                              JOIN products p ON oi.product_id = p.id 
                              JOIN orders o ON oi.order_id = o.id 
                              WHERE p.vendor_id = $v_id AND o.status = 'Pending'");
$pending_orders = mysqli_fetch_assoc($res_o)['pending_o'];
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Vendor Dashboard</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
    <style>
        .card-stats { transition: 0.3s; border: none; }
        .card-stats:hover { transform: translateY(-5px); }
    </style>
</head>
<body class="bg-light">

<nav class="navbar navbar-expand-lg navbar-dark bg-dark shadow-sm">
    <div class="container">
        <a class="navbar-brand fw-bold" href="#">Vendor Panel</a>
        <div class="ms-auto text-white">
            Welcome, <span class="text-info"><?= $_SESSION['v_name'] ?? 'Vendor'; ?></span>
            <a href="logout.php" class="btn btn-outline-danger btn-sm ms-3">Logout</a>
        </div>
    </div>
</nav>

<div class="container my-5">
    <div class="row g-4 mb-5">
        <div class="col-md-4">
            <div class="card card-stats shadow-sm bg-white p-3 border-start border-success border-5">
                <div class="card-body">
                    <div class="d-flex justify-content-between">
                        <div>
                            <h6 class="text-muted">Total Earnings</h6>
                            <h3>₹<?= number_format($total_earnings, 2); ?></h3>
                        </div>
                        <i class="fa-solid fa-indian-rupee-sign fa-2x text-success"></i>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-md-4">
            <div class="card card-stats shadow-sm bg-white p-3 border-start border-primary border-5">
                <div class="card-body">
                    <div class="d-flex justify-content-between">
                        <div>
                            <h6 class="text-muted">My Products</h6>
                            <h3><?= $total_products; ?></h3>
                        </div>
                        <i class="fa-solid fa-box fa-2x text-primary"></i>
                    </div>
                    <a href="products.php" class="small text-decoration-none">Manage Inventory →</a>
                </div>
            </div>
        </div>

        <div class="col-md-4">
            <div class="card card-stats shadow-sm bg-white p-3 border-start border-warning border-5">
                <div class="card-body">
                    <div class="d-flex justify-content-between">
                        <div>
                            <h6 class="text-muted">Pending Orders</h6>
                            <h3><?= $pending_orders; ?></h3>
                        </div>
                        <i class="fa-solid fa-clock fa-2x text-warning"></i>
                    </div>
                    <a href="orders.php" class="small text-decoration-none">View Orders →</a>
                </div>
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-md-12">
            <div class="card border-0 shadow-sm">
                <div class="card-header bg-white fw-bold py-3">Quick Actions</div>
                <div class="card-body d-flex gap-3">
                    <a href="add_product.php" class="btn btn-outline-primary"><i class="fa fa-plus"></i> Add New Product</a>
                    <a href="profile.php" class="btn btn-outline-secondary"><i class="fa fa-user-edit"></i> Edit Shop Profile</a>
                    <a href="reports.php" class="btn btn-outline-info"><i class="fa fa-chart-bar"></i> Sales Report</a>
                </div>
            </div>
        </div>
    </div>
</div>

</body>
</html>