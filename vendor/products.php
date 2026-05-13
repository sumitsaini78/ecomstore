<?php
session_start();
include("../admin/db.php");

// Session check
if (!isset($_SESSION['v_id'])) {
    header("Location: login.php");
    exit;
}

$v_id = $_SESSION['v_id'];

// FINAL FIXED QUERY: category_id use kiya hai dono side
$sql = "SELECT p.*, c.cat_title 
        FROM products p 
        JOIN categories c ON p.category_id = c.category_id 
        WHERE p.vendor_id = '$v_id' 
        ORDER BY p.id DESC";

$products = mysqli_query($conn, $sql);

if (!$products) {
    die("Query Failed: " . mysqli_error($conn));
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
    <title>My Products - Vendor Panel</title>
</head>
<body class="bg-light">

<nav class="navbar navbar-dark bg-dark mb-4 shadow">
    <div class="container">
        <a class="navbar-brand fw-bold" href="index.php">
            <i class="fa fa-arrow-left"></i> Vendor Dashboard
        </a>
    </div>
</nav>

<div class="container">
    <div class="card shadow-sm border-0">
        <div class="card-header bg-primary text-white d-flex justify-content-between align-items-center py-3">
            <h5 class="mb-0"><i class="fa fa-boxes"></i> My Product Inventory</h5>
            <a href="add_product.php" class="btn btn-light btn-sm fw-bold">+ Add Product</a>
        </div>
        <div class="table-responsive">
            <table class="table table-hover align-middle mb-0">
                <thead class="table-light">
                    <tr>
                        <th class="ps-3">Image</th>
                        <th>Product Name</th>
                        <th>Category</th>
                        <th>Price</th>
                        <th class="text-center">Action</th>
                    </tr>
                </thead>
                <tbody>
                    <?php if(mysqli_num_rows($products) > 0): ?>
                        <?php while($p = mysqli_fetch_assoc($products)): ?>
                        <tr>
                            <td class="ps-3">
                                <img src="../images/<?= $p['image']; ?>" width="55" height="55" class="rounded border" style="object-fit:cover;">
                            </td>
                            <td class="fw-bold text-dark"><?= $p['name']; ?></td>
                            <td>
                                <span class="badge bg-info text-dark"><?= $p['cat_title']; ?></span>
                            </td>
                            <td class="text-success fw-bold">₹<?= number_format($p['price'], 2); ?></td>
                            <td class="text-center">
                                <div class="btn-group">
                                    <a href="edit_product.php?id=<?= $p['id']; ?>" class="btn btn-sm btn-outline-primary"><i class="fa fa-edit"></i></a>
                                    <a href="delete_product.php?id=<?= $p['id']; ?>" class="btn btn-sm btn-outline-danger" onclick="return confirm('Confirm Delete?')"><i class="fa fa-trash"></i></a>
                                </div>
                            </td>
                        </tr>
                        <?php endwhile; ?>
                    <?php else: ?>
                        <tr>
                            <td colspan="5" class="text-center py-5 text-muted">
                                <i class="fa fa-folder-open fa-3x mb-3 d-block text-light"></i>
                                No products found. Click "Add Product" to start selling.
                            </td>
                        </tr>
                    <?php endif; ?>
                </tbody>
            </table>
        </div>
    </div>
</div>

</body>
</html>