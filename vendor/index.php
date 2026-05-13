<?php
session_start();

// FIX 1: Path sahi kiya (Step back from vendor folder, then into admin)
include("../admin/db.php");

// Maan lo login ke baad vendor ki ID session mein hai
if (!isset($_SESSION['v_id'])) {
    header("Location: login.php");
    exit;
}

$v_id = $_SESSION['v_id'];

// 1. Total Products Count for this vendor
$res_p = mysqli_query($conn, "SELECT COUNT(id) as total_p FROM products WHERE vendor_id = $v_id");
$total_products = mysqli_fetch_assoc($res_p)['total_p'];

// FIX 2: Query ko clean kiya aur product_qty column use kiya
$res_e = mysqli_query($conn, "SELECT SUM(p.price * oi.product_qty) as total_earn 
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
        .card-stats {
            transition: 0.3s;
            border: none;
        }

        .card-stats:hover {
            transform: translateY(-5px);
        }
    </style>
</head>

<body class="bg-light">

<nav class="navbar navbar-expand-lg navbar-dark bg-dark shadow-sm py-3">
    <div class="container">
        <div class="d-flex align-items-center">
            <img src="../images/<?= $_SESSION['v_img'] ?? 'default-vendor.png'; ?>" 
                 alt="Store Logo" 
                 class="rounded-circle border border-2 border-info me-2" 
                 width="45" height="45" 
                 style="object-fit: cover;">
            <div>
                <span class="text-white fw-bold d-block" style="line-height: 1.2;">
                    <?= $_SESSION['v_name']; ?>
                </span>
                <small class="text-info" style="font-size: 11px;">Vendor Dashboard</small>
            </div>
        </div>
        
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#vendorNav">
            <span class="navbar-toggler-icon"></span>
        </button>

        <div class="collapse navbar-collapse" id="vendorNav">
            <ul class="navbar-nav ms-auto align-items-center">
                <li class="nav-item">
                    <a class="nav-link" href="index.php"><i class="fa fa-home"></i> Home</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="products.php"><i class="fa fa-box"></i> Products</a>
                </li>
                <li class="nav-item ms-lg-3">
                    <a href="logout.php" class="btn btn-outline-danger btn-sm px-3">
                        <i class="fa fa-sign-out-alt"></i> Logout
                    </a>
                </li>
            </ul>
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
                        <a href="add_product.php" class="btn btn-outline-primary"><i class="fa fa-plus"></i> Add New
                            Product</a>
                        <a href="profile.php" class="btn btn-outline-secondary"><i class="fa fa-user-edit"></i> Edit
                            Shop Profile</a>
                        <a href="reports.php" class="btn btn-outline-info"><i class="fa fa-chart-bar"></i> Sales
                            Report</a>
                    </div>
                </div>
            </div>
        </div>
    </div>

</body>

</html>