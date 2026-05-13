<?php
session_start();
include("db.php");

$msg = "";

// 1. Pehle product ka purana data fetch karein
if (isset($_GET['id'])) {
    $id = (int)$_GET['id'];
    $res = mysqli_query($conn, "SELECT * FROM products WHERE id = $id");
    $old_data = mysqli_fetch_assoc($res);
} else {
    header("Location: manage_products.php");
    exit;
}

// 2. Update Logic
if (isset($_POST['update_product'])) {
    $name = mysqli_real_escape_string($conn, $_POST['name']);
    $description = mysqli_real_escape_string($conn, $_POST['description']);
    $price = (float)$_POST['price'];
    $category_id = (int)$_POST['category_id'];

    // Image logic
    if (!empty($_FILES['image']['name'])) {
        // Nayi image upload ho rahi hai
        $image_name = $_FILES['image']['name'];
        $new_image_name = "prod_" . time() . "_" . $image_name;
        move_uploaded_file($_FILES['image']['tmp_name'], "../images/" . $new_image_name);
    } else {
        // Purani image hi rehne dein
        $new_image_name = $old_data['image'];
    }

    // Query update karein (vendor_id ko purana hi rehne dein)
    $update_sql = "UPDATE products SET 
                    name = '$name', 
                    description = '$description', 
                    price = '$price', 
                    category_id = '$category_id', 
                    image = '$new_image_name' 
                   WHERE id = $id";

    if (mysqli_query($conn, $update_sql)) {
        header("Location: manage_products.php?msg=updated");
        exit;
    } else {
        $msg = "<div class='alert alert-danger'>Update Failed: " . mysqli_error($conn) . "</div>";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <title>Edit Product</title>
</head>
<body class="bg-light">
<div class="container my-5">
    <div class="card shadow-sm border-0 mx-auto" style="max-width: 700px;">
        <div class="card-header bg-dark text-white">Edit Product #<?= $id; ?></div>
        <div class="card-body p-4">
            <?= $msg; ?>
            <form action="" method="POST" enctype="multipart/form-data">
                <div class="mb-3">
                    <label class="form-label fw-bold">Product Name</label>
                    <input type="text" name="name" class="form-control" value="<?= $old_data['name']; ?>" required>
                </div>

                <div class="row">
                    <div class="col-md-6 mb-3">
                        <label class="form-label fw-bold">Price</label>
                        <input type="number" name="price" class="form-control" value="<?= $old_data['price']; ?>" required>
                    </div>
                    <div class="col-md-6 mb-3">
                        <label class="form-label fw-bold">Category ID</label>
                        <input type="number" name="category_id" class="form-control" value="<?= $old_data['category_id']; ?>">
                    </div>
                </div>

                <div class="mb-3">
                    <label class="form-label fw-bold">Current Image</label><br>
                    <img src="../images/<?= $old_data['image']; ?>" width="100" class="img-thumbnail mb-2">
                    <input type="file" name="image" class="form-control">
                    <small class="text-muted">Nayi image select karein agar badalna chahte hain.</small>
                </div>

                <div class="mb-4">
                    <label class="form-label fw-bold">Description</label>
                    <textarea name="description" class="form-control" rows="4"><?= $old_data['description']; ?></textarea>
                </div>

                <button type="submit" name="update_product" class="btn btn-success w-100">Update Product</button>
                <a href="manage_products.php" class="btn btn-link w-100 text-decoration-none mt-2">Cancel</a>
            </form>
        </div>
    </div>
</div>
</body>
</html>