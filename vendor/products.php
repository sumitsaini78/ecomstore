<?php
session_start();
include("../admin/db.php");
$vendor_id = $_SESSION['v_id']; // Maa lo vendor login hone ke baad ID session mein hai

// Fetch only this vendor's products
$products = mysqli_query($conn, "SELECT p.*, c.cat_title FROM products p 
                                JOIN categories c ON p.category_id = c.cat_id 
                                WHERE p.vendor_id = $vendor_id ORDER BY p.id DESC");
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <title>Vendor Inventory</title>
</head>
<body class="bg-light">
<div class="container my-5">
    <div class="card shadow-sm border-0">
        <div class="card-header bg-primary text-white d-flex justify-content-between">
            <h5 class="mb-0">My Products</h5>
            <a href="add_product.php" class="btn btn-light btn-sm">+ Add New</a>
        </div>
        <div class="table-responsive">
            <table class="table table-hover align-middle mb-0">
                <thead>
                    <tr>
                        <th>Image</th>
                        <th>Product Name</th>
                        <th>Category</th>
                        <th>Price</th>
                        <th>Action</th>
                    </tr>
                </thead>
                <tbody>
                    <?php while($p = mysqli_fetch_assoc($products)): ?>
                    <tr>
                        <td><img src="../images/<?= $p['image']; ?>" width="50" class="rounded"></td>
                        <td><?= $p['name']; ?></td>
                        <td><span class="badge bg-secondary"><?= $p['cat_title']; ?></span></td>
                        <td class="fw-bold">₹<?= number_format($p['price'], 2); ?></td>
                        <td>
                            <a href="edit_product.php?id=<?= $p['id']; ?>" class="btn btn-sm btn-outline-primary">Edit</a>
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