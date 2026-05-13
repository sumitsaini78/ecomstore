<?php
session_start();
include("../admin/db.php");

if (!isset($_SESSION['v_id'])) {
    header("Location: login.php");
    exit;
}

$v_id = $_SESSION['v_id'];
$msg = "";

// 1. Fetch Current Vendor Data
$vendor_res = mysqli_query($conn, "SELECT * FROM vendors WHERE v_id = $v_id");
$v_data = mysqli_fetch_assoc($vendor_res);

// 2. Update Logic
if (isset($_POST['update_profile'])) {
    $name = mysqli_real_escape_string($conn, $_POST['v_name']); // Naya field add kiya
    $email = mysqli_real_escape_string($conn, $_POST['v_email']);
    $phone = mysqli_real_escape_string($conn, $_POST['v_phone']);
    $old_img = $_POST['old_img'];
    
    // Image Upload Handling
    if ($_FILES['v_img']['name'] != "") {
        $image = time() . "_" . $_FILES['v_img']['name'];
        $temp_name = $_FILES['v_img']['tmp_name'];
        move_uploaded_file($temp_name, "../images/$image");
        
        if ($old_img != "" && file_exists("../images/$old_img")) {
            unlink("../images/$old_img");
        }
    } else {
        $image = $old_img;
    }

    // SQL Query mein v_name add kar diya
    $update_sql = "UPDATE vendors SET v_name='$name', v_email='$email', v_phone='$phone', v_img='$image' WHERE v_id=$v_id";
    
    if (mysqli_query($conn, $update_sql)) {
        // Update Session name also (Taki dashboard par naya naam turant dikhe)
        $_SESSION['v_name'] = $name;
        
        $msg = "<div class='alert alert-success border-0 shadow-sm'>Profile updated successfully!</div>";
        header("Refresh: 1; url=profile.php");
    } else {
        $msg = "<div class='alert alert-danger'>Error: " . mysqli_error($conn) . "</div>";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
    <title>Edit Profile - <?= $v_data['v_name']; ?></title>
</head>
<body class="bg-light">

<nav class="navbar navbar-dark bg-dark mb-4 shadow">
    <div class="container">
        <a class="navbar-brand fw-bold" href="index.php"><i class="fa fa-arrow-left"></i> Dashboard</a>
    </div>
</nav>

<div class="container mb-5">
    <div class="row justify-content-center">
        <div class="col-md-6">
            <div class="card shadow border-0">
                <div class="card-header bg-white py-3 border-bottom">
                    <h5 class="mb-0 fw-bold text-primary"><i class="fa fa-id-card"></i> Manage Shop Profile</h5>
                </div>
                <div class="card-body p-4">
                    <?= $msg; ?>
                    <form action="" method="POST" enctype="multipart/form-data">
                        
                        <div class="text-center mb-4">
                            <img src="../images/<?= $v_data['v_img'] ? $v_data['v_img'] : 'default-vendor.png'; ?>" 
                                 class="rounded-circle border p-1 shadow-sm" 
                                 width="110" height="110" style="object-fit: cover;">
                            <input type="hidden" name="old_img" value="<?= $v_data['v_img']; ?>">
                        </div>

                        <div class="mb-3">
                            <label class="form-label small fw-bold">Vendor/Owner Name</label>
                            <input type="text" name="v_name" class="form-control" value="<?= $v_data['v_name']; ?>" required>
                        </div>

                        <div class="mb-3">
                            <label class="form-label small fw-bold">Business Email</label>
                            <input type="email" name="v_email" class="form-control" value="<?= $v_data['v_data' ?? $v_data['v_email']]; ?>" required>
                        </div>

                        <div class="mb-3">
                            <label class="form-label small fw-bold">Phone Number</label>
                            <input type="text" name="v_phone" class="form-control" value="<?= $v_data['v_phone']; ?>" required>
                        </div>

                        <div class="mb-4">
                            <label class="form-label small fw-bold">Profile Logo</label>
                            <input type="file" name="v_img" class="form-control">
                        </div>

                        <button type="submit" name="update_profile" class="btn btn-primary w-100 py-2 fw-bold">
                            Save Changes
                        </button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

</body>
</html>