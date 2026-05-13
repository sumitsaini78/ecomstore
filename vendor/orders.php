<?php
session_start();
include("../admin/db.php");
$vendor_id = $_SESSION['v_id'];

// Join order_items with products to filter by vendor_id
$sql = "SELECT oi.*, p.name as product_name, o.order_date, o.status as order_status 
        FROM order_items oi
        JOIN products p ON oi.product_id = p.id
        JOIN orders o ON oi.order_id = o.id
        WHERE p.vendor_id = $vendor_id
        ORDER BY o.id DESC";
$vendor_orders = mysqli_query($conn, $sql);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <title>Vendor Orders</title>
</head>
<body class="bg-light">
<div class="container my-5">
    <h4 class="mb-4">Recent Sales Orders</h4>
    <div class="card border-0 shadow-sm">
        <div class="card-body p-0">
            <table class="table mb-0">
                <thead class="table-dark">
                    <tr>
                        <th>Order ID</th>
                        <th>Product</th>
                        <th>Qty</th>
                        <th>Earnings</th>
                        <th>Date</th>
                        <th>Status</th>
                    </tr>
                </thead>
                <tbody>
                    <?php while($o = mysqli_fetch_assoc($vendor_orders)): ?>
                    <tr>
                        <td>#<?= $o['order_id']; ?></td>
                        <td><?= $o['product_name']; ?></td>
                        <td><?= $o['quantity']; ?></td>
                        <td class="text-success fw-bold">₹<?= number_format($o['price'] * $o['quantity'], 2); ?></td>
                        <td><?= date('d M Y', strtotime($o['order_date'])); ?></td>
                        <td>
                            <span class="badge bg-info"><?= $o['order_status']; ?></span>
                        </td>
                    </tr>
                    <?php endwhile; ?>
                </tbody>
            </table>
        </div>
    </div>
</div>
</body>
</html>