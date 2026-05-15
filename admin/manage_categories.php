<?php
session_start();
include("db.php");

// 1. Add Category Logic
if (isset($_POST['add_cat'])) {
    $title = mysqli_real_escape_string($conn, $_POST['cat_title']);
    
    // Check if a file was actually uploaded without errors
    if (!empty($title) && isset($_FILES['cat_img']) && $_FILES['cat_img']['error'] == 0) {
        
        $file = $_FILES['cat_img'];
        $fileName = $file['name'];
        $fileTmpName = $file['tmp_name'];
        
        // 1. Get the file extension safely (e.g., png, jpg)
        $fileExt = strtolower(pathinfo($fileName, PATHINFO_EXTENSION));
        $allowedExtensions = ['jpg', 'jpeg', 'png', 'webp'];
        
        if (in_array($fileExt, $allowedExtensions)) {
            
            // 2. Generate a unique name so files don't overwrite each other
            $uniqueImageName = uniqid('cat_', true) . "." . $fileExt;
            
            // 3. Define your upload directory path
            $uploadDirectory = "../cat_images/" . $uniqueImageName;
            
            // 4. Move the file from temp storage to your images folder
            if (move_uploaded_file($fileTmpName, $uploadDirectory)) {
                
                // 5. Insert into database (Fixed SQL quotes and variable usage)
                $insert = "INSERT INTO categories (cat_title, cat_img) VALUES ('$title', '$uniqueImageName')";
                
                if (mysqli_query($conn, $insert)) {
                    header("Location: manage_categories.php?msg=added");
                    exit;
                } else {
                    echo "Database Error: " . mysqli_error($conn);
                }
                
            } else {
                echo "Failed to move uploaded file. Check folder permissions.";
            }
        } else {
            echo "Invalid file type. Allowed types: JPG, JPEG, PNG, WEBP.";
        }
    } else {
        echo "Please provide a title and select a valid image.";
    }
}
// 2. Delete Category Logic
if (isset($_GET['delete'])) {
    $id = (int) $_GET['delete'];
    mysqli_query($conn, "DELETE FROM categories WHERE category_id = $id");
    header("Location: manage_categories.php?msg=deleted");
    exit;
}

// 3. Fetch Categories
$categories = mysqli_query($conn, "SELECT * FROM categories ORDER BY category_id DESC");
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
    <title>Manage Categories</title>
</head>

<body class="bg-light">

    <div class="container my-5">
        <div class="row">
            <div class="col-md-4">
                <div class="card border-0 shadow-sm mb-4">
                    <div class="card-header bg-primary text-white fw-bold">Add New Category</div>
                    <div class="card-body">
                        <form action="" method="POST" enctype="multipart/form-data">
                            <div class="mb-3">
                                <label class="form-label">Category Title</label>
                                <input type="file" name="cat_img" class="form-control" placeholder="e.g. Saree, Kurti"
                                    required>
                                <input type="text" name="cat_title" class="form-control" placeholder="e.g. Saree, Kurti"
                                    required>
                            </div>
                            <button type="submit" name="add_cat" class="btn btn-primary w-100">Add Category</button>
                        </form>
                    </div>
                </div>
                <a href="index.php" class="btn btn-secondary btn-sm w-100">Back to Dashboard</a>
            </div>

            <div class="col-md-8">
                <?php if (isset($_GET['msg'])): ?>
                    <div class="alert alert-success alert-dismissible fade show">
                        Action completed successfully!
                        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                    </div>
                <?php endif; ?>

                <div class="card border-0 shadow-sm">
                    <div class="card-body p-0">
                        <table class="table table-hover mb-0">
                            <thead class="table-dark">
                                <tr>
                                    <th class="ps-3">ID</th>
                                    <th>Category Name</th>
                                    <th class="text-center">Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php if (mysqli_num_rows($categories) > 0): ?>
                                    <?php while ($row = mysqli_fetch_assoc($categories)): ?>
                                        <tr>
                                            <td class="ps-3"><?= $row['category_id']; ?></td>
                                            <td class="fw-bold"><?= $row['cat_title']; ?></td>
                                            <td class="text-center">
                                                <a href="manage_categories.php?delete=<?php echo $row['category_id']; ?>"
                                                    class="btn btn-sm btn-outline-danger"
                                                    onclick="return confirm('Kya aap sach mein is category ko delete karna chahte hain?')">
                                                    <i class="fa-solid fa-trash"></i>
                                                </a>
                                            </td>
                                        </tr>
                                    <?php endwhile; ?>
                                <?php else: ?>
                                    <tr>
                                        <td colspan="3" class="text-center py-4">No categories found.</td>
                                    </tr>
                                <?php endif; ?>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>