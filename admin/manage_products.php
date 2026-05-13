<?php
session_start();
include("db.php");

// 1. Delete Product Logic
if (isset($_GET['delete'])) {
    $id = (int)$_GET['delete'];
    // Pehle product ka naam ya image fetch kar sakte ho agar folder se file bhi delete karni ho
    $delete_query = "DELETE FROM products WHERE id = $id";
    if (mysqli_query($conn, $delete_query)) {
        header("Location: manage_products.php?msg=deleted");
        exit;
    }
}

// 2. Fetch all products
$product_res = mysqli_query($conn, "SELECT * FROM products ORDER BY id DESC");
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Manage Products - Admin Panel</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
    <style>
        .product-img { width: 50px; height: 50px; object-fit: cover; border-radius: 5px; }
        .table middle { vertical-align: middle; }
    </style>
</head>
<body class="bg-light">

<div class="container my-5">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h3 class="fw-bold">Manage Products</h3>
        <a href="add_product.php" class="btn btn-primary">
            <i class="fa-solid fa-plus me-1"></i> Add New Product
        </a>
    </div>

    <!-- Feedback Message -->
    <?php if(isset($_GET['msg']) && $_GET['msg'] == 'deleted'): ?>
        <div class="alert alert-danger alert-dismissible fade show" role="alert">
            Product deleted successfully!
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
    <?php endif; ?>

    <div class="card border-0 shadow-sm">
        <div class="card-body p-0">
            <div class="table-responsive">
                <table class="table table-hover mb-0 align-middle">
                    <thead class="table-dark">
                        <tr>
                            <th class="ps-3">ID</th>
                            <th>Image</th>
                            <th>Product Name</th>
                            <th>Category</th>
                            <th>Price</th>
                            <th class="text-center">Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php if(mysqli_num_rows($product_res) > 0): ?>
                            <?php while($row = mysqli_fetch_assoc($product_res)): ?>
                            <tr>
                                <td class="ps-3 fw-bold">#<?= $row['id']; ?></td>
                                <td>
                                    <img src="images/<?= $row['image']; ?>" class="product-img border" alt="img">
                                </td>
                                <td>
                                    <div class="fw-bold text-dark"><?= $row['name']; ?></div>
                                    <small class="text-muted"><?= substr($row['description'], 0, 50); ?>. ..</small>
                                </td>
                                <td><span class="badge bg-info text-dark"><?= $row['id']; ?></span></td>
                                <td class="fw-bold text-success">₹<?= number_format($row['price'], 2); ?></td>
                                <td class="text-center">
                                    <div class="btn-group">
                                        <a href="edit_product.php?id=<?= $row['id']; ?>" class="btn btn-sm btn-outline-primary" title="Edit">
                                            <i class="fa-solid fa-pen-to-square"></i>
                                        </a>
                                        <a href="manage_products.php?delete=<?= $row['id']; ?>" 
                                           class="btn btn-sm btn-outline-danger" 
                                           onclick="return confirm('Are you sure you want to delete this product?')" 
                                           title="Delete">
                                            <i class="fa-solid fa-trash"></i>
                                        </a>
                                    </div>
                                </td>
                            </tr>
                            <?php endwhile; ?>
                        <?php else: ?>
                            <tr>
                                <td colspan="6" class="text-center py-5 text-muted">No products found in database.</td>
                            </tr>
                        <?php endif; ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <div class="mt-4">
        <a href="index.php" class="btn btn-secondary btn-sm">
            <i class="fa-solid fa-arrow-left me-1"></i> Back to Dashboard
        </a>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>