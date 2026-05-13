<?php
include("db.php"); // Database connection

// Database se counts fetch karein (Statistics)
$count_products = mysqli_num_rows(mysqli_query($conn, "SELECT id FROM products"));
$count_orders = mysqli_num_rows(mysqli_query($conn, "SELECT id FROM orders"));
$count_users = mysqli_num_rows(mysqli_query($conn, "SELECT id FROM users"));
$count_categories = mysqli_num_rows(mysqli_query($conn, "SELECT category_id FROM categories"));
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
    <style>
        .dash-card { transition: 0.3s; border: none; border-radius: 15px; }
        .dash-card:hover { transform: translateY(-5px); box-shadow: 0 10px 20px rgba(0,0,0,0.1); }
        .icon-box { font-size: 2.5rem; opacity: 0.3; position: absolute; right: 15px; bottom: 10px; }
    </style>
</head>
<body class="bg-light">

<div class="container my-5">
    <h3 class="fw-bold mb-4 text-center">Admin Dashboard</h3>
    
    <div class="row g-4">
        <!-- Products Card -->
        <div class="col-md-3">
            <div class="card dash-card bg-primary text-white p-3 h-100">
                <div class="card-body">
                    <h6 class="text-uppercase small">Total Products</h6>
                    <h2 class="fw-bold"><?= $count_products; ?></h2>
                    <a href="manage_products.php" class="text-white text-decoration-none small stretched-link">View Details <i class="fa-solid fa-arrow-right"></i></a>
                </div>
                <i class="fa-solid fa-box-open icon-box"></i>
            </div>
        </div>

        <!-- Orders Card -->
        <div class="col-md-3">
            <div class="card dash-card bg-success text-white p-3 h-100">
                <div class="card-body">
                    <h6 class="text-uppercase small">Active Orders</h6>
                    <h2 class="fw-bold"><?= $count_orders; ?></h2>
                    <a href="orders.php" class="text-white text-decoration-none small stretched-link">Track Orders <i class="fa-solid fa-arrow-right"></i></a>
                </div>
                <i class="fa-solid fa-cart-shopping icon-box"></i>
            </div>
        </div>

        <!-- Categories Card -->
        <div class="col-md-3">
            <div class="card dash-card bg-warning text-dark p-3 h-100">
                <div class="card-body">
                    <h6 class="text-uppercase small">Categories</h6>
                    <h2 class="fw-bold"><?= $count_categories; ?></h2>
                    <a href="manage_categories.php" class="text-dark text-decoration-none small stretched-link">Manage <i class="fa-solid fa-arrow-right"></i></a>
                </div>
                <i class="fa-solid fa-list icon-box"></i>
            </div>
        </div>

        <!-- Users/Vendors Card -->
        <div class="col-md-3">
            <div class="card dash-card bg-info text-white p-3 h-100">
                <div class="card-body">
                    <h6 class="text-uppercase small">Total Users</h6>
                    <h2 class="fw-bold"><?= $count_users; ?></h2>
                    <a href="manage_users.php" class="text-white text-decoration-none small stretched-link">See List <i class="fa-solid fa-arrow-right"></i></a>
                </div>
                <i class="fa-solid fa-users icon-box"></i>
            </div>
        </div>
        <div class="col-md-3">
            <div class="card dash-card bg-info text-white p-3 h-100">
                <div class="card-body">
                    <h6 class="text-uppercase small">Vendors / Sellers</h6>
                
                    <h5 class="card-title">Vendors</h5>
                    <a href="vendors.php" class="btn btn-primary btn-sm">Manage Vendors</a>
                </div>
                <i class="fa-solid fa-users icon-box"></i>
            </div>
        </div>
        
    </div>
    <!--  -->
    

    <!-- Quick Action Buttons -->
    <div class="mt-5 p-4 bg-white rounded shadow-sm">
        <h5 class="mb-3 fw-bold">Quick Actions</h5>
        <div class="d-flex flex-wrap gap-2">
            <a href="add_product.php" class="btn btn-outline-primary"><i class="fa-solid fa-plus me-1"></i> Add Product</a>
            <a href="coupons.php" class="btn btn-outline-secondary"><i class="fa-solid fa-ticket me-1"></i> Coupons</a>
            <a href="reports.php" class="btn btn-outline-dark"><i class="fa-solid fa-chart-line me-1"></i> Sales Report</a>
            <a href="settings.php" class="btn btn-outline-danger"><i class="fa-solid fa-gear me-1"></i> Settings</a>
        </div>
    </div>
</div>

</body>
</html>