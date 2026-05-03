<?php
// Database Connection (Isko aap alag config file mein bhi rakh sakte hain)
$conn = new mysqli("localhost", "root", "", "categories");

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

$message = "";

// Agar form submit hua hai
if (isset($_POST['add_category'])) {
    $cat_name = $_POST['category_name'];

    if (!empty($cat_name)) {
        $sql = "INSERT INTO categories (category_name) VALUES ('$cat_name')";
        if ($conn->query($sql) === TRUE) {
            $message = "<div class='alert alert-success'>Category added successfully!</div>";
        } else {
            $message = "<div class='alert alert-danger'>Error: " . $conn->error . "</div>";
        }
    } else {
        $message = "<div class='alert alert-warning'>Please enter a category name.</div>";
    }
}
?>

<!doctype html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <title>Add Category - Shodio</title>
</head>
<body class="bg-light">

    <div class="container mt-5">
        <div class="row justify-content-center">
            <div class="col-md-6">
                <div class="card shadow-sm border-0">
                    <div class="card-header bg-white py-3">
                        <h4 class="mb-0 fw-bold" style="color:#570d48;">Add New Category</h4>
                    </div>
                    <div class="card-body p-4">
                        
                        <?php echo $message; ?>

                        <form action="" method="POST">
                            <div class="mb-3">
                                <label class="form-label fw-medium">Category Name</label>
                                <input type="text" name="category_name" class="form-control" placeholder="e.g. Saree, Kurti, Lehenga" required>
                            </div>
                            <div class="d-grid">
                                <button type="submit" name="add_category" class="btn text-white" style="background-color:#570d48;">Save Category</button>
                            </div>
                        </form>
                    </div>
                    <div class="card-footer bg-white text-center py-3">
                        <a href="index.php" class="text-decoration-none text-muted small">← Back to Store</a>
                    </div>
                </div>
            </div>
        </div>
    </div>

</body>
</html>