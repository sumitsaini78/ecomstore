<?php
session_start();
include("../admin/db.php");

$msg = "";

if (isset($_POST['add_product'])) {
    // 1. Data collect aur sanitize karein
    $name = mysqli_real_escape_string($conn, $_POST['name']);
    $description = mysqli_real_escape_string($conn, $_POST['description']);
    $price = (float) $_POST['price'];
    $category = mysqli_real_escape_string($conn, $_POST['category']);

    // 2. Image Upload Logic
    $image_name = $_FILES['image']['name'];
    $temp_name = $_FILES['image']['tmp_name'];
    $image_ext = pathinfo($image_name, PATHINFO_EXTENSION);

    // Unique name banayein taaki images overwrite na hon
    $new_image_name = "prod_" . time() . "." . $image_ext;
    $upload_path = "images/" . $new_image_name;

    // Allowed types check (Optional but recommended)
    $allowed_types = ['jpg', 'jpeg', 'png', 'webp'];

    if (in_array(strtolower($image_ext), $allowed_types)) {
        if (move_uploaded_file($temp_name, $upload_path)) {
            // 3. Database mein insert karein
            $sql = "INSERT INTO products (name, description, price, category_id, image) 
                    VALUES ('$name', '$description', '$price', '$category', '$new_image_name')";

            if (mysqli_query($conn, $sql)) {
                $msg = "<div class='alert alert-success'>Product added successfully!</div>";
            } else {
                $msg = "<div class='alert alert-danger'>Database Error: " . mysqli_error($conn) . "</div>";
            }
        } else {
            $msg = "<div class='alert alert-danger'>Failed to upload image. Check folder permissions.</div>";
        }
    } else {
        $msg = "<div class='alert alert-warning'>Invalid file type. Only JPG, PNG, WEBP allowed.</div>";
    }
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Add Product - Admin Panel</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
</head>

<body class="bg-light">

    <div class="container my-5">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card shadow-sm border-0">
                    <div class="card-header bg-primary text-white">
                        <h5 class="mb-0">Add New Product</h5>
                    </div>
                    <div class="card-body p-4">
                        <?= $msg; ?>

                        <!-- enctype="multipart/form-data" lagana compulsory hai image ke liye -->
                        <form action="" method="POST" enctype="multipart/form-data">
                            <div class="row">
                                <div class="col-md-12 mb-3">
                                    <label class="form-label fw-bold">Product Name</label>
                                    <input type="text" name="name" class="form-control" placeholder="Enter product name"
                                        required>
                                </div>

                                <div class="col-md-6 mb-3">
                                    <label class="form-label fw-bold">Category</label>
                                    <select name="category" class="form-select" required>
                                        <option value="None">Select</option>
                                        <?php // add_product.php ke dropdown mein:
                                        $cat_list = mysqli_query($conn, "SELECT * FROM categories");
                                        while ($c = mysqli_fetch_assoc($cat_list)) {
                                            echo "<option value='" . $c['category_id'] . "'>" . $c['cat_title'] . "</option>";
                                        } ?>
                                    </select>
                                </div>

                                <div class="col-md-6 mb-3">
                                    <label class="form-label fw-bold">Price (₹)</label>
                                    <input type="number" step="0.01" name="price" class="form-control"
                                        placeholder="0.00" required>
                                </div>

                                <div class="col-md-12 mb-3">
                                    <label class="form-label fw-bold">Product Image</label>
                                    <input type="file" name="image" class="form-control" accept="image/*" required>
                                    <small class="text-muted">Recommended size: 800x800px</small>
                                </div>

                                <div class="col-md-12 mb-4">
                                    <label class="form-label fw-bold">Description</label>
                                    <textarea name="description" class="form-control" rows="4"
                                        placeholder="Enter product details..." required></textarea>
                                </div>
                            </div>

                            <div class="d-flex gap-2">
                                <button type="submit" name="add_product" class="btn btn-primary px-4">Save
                                    Product</button>
                                <a href="manage_products.php" class="btn btn-outline-secondary">Cancel</a>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>

</body>

</html>