<?php
session_start();
include("db.php");

// 1. Add Coupon Logic
if (isset($_POST['add_coupon'])) {
    $code = strtoupper(mysqli_real_escape_string($conn, $_POST['coupon_code']));
    $type = $_POST['discount_type'];
    $value = (float)$_POST['discount_value'];
    $min_val = (float)$_POST['min_cart_value'];
    $expiry = $_POST['expiry_date'];

    $insert = "INSERT INTO coupons (coupon_code, discount_type, discount_value, min_cart_value, expiry_date) 
               VALUES ('$code', '$type', '$value', '$min_val', '$expiry')";
    
    if(mysqli_query($conn, $insert)) {
        header("Location: coupons.php?msg=added");
        exit;
    }
}

// 2. Delete Coupon Logic
if (isset($_GET['delete'])) {
    $id = (int)$_GET['delete'];
    mysqli_query($conn, "DELETE FROM coupons WHERE id = $id");
    header("Location: coupons.php?msg=deleted");
    exit;
}

// 3. Fetch Coupons
$coupons = mysqli_query($conn, "SELECT * FROM coupons ORDER BY id DESC");
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
    <title>Manage Coupons</title>
</head>
<body class="bg-light">

<div class="container my-5">
    <div class="row">
        <div class="col-md-4">
            <div class="card border-0 shadow-sm mb-4">
                <div class="card-header bg-dark text-white fw-bold">Create New Coupon</div>
                <div class="card-body">
                    <form action="" method="POST">
                        <div class="mb-2">
                            <label class="small fw-bold">Coupon Code</label>
                            <input type="text" name="coupon_code" class="form-control" placeholder="E.g. SAVE20" required>
                        </div>
                        <div class="mb-2">
                            <label class="small fw-bold">Type</label>
                            <select name="discount_type" class="form-select">
                                <option value="percentage">Percentage (%)</option>
                                <option value="fixed">Fixed Amount (₹)</option>
                            </select>
                        </div>
                        <div class="mb-2">
                            <label class="small fw-bold">Discount Value</label>
                            <input type="number" name="discount_value" class="form-control" required>
                        </div>
                        <div class="mb-2">
                            <label class="small fw-bold">Min Cart Value</label>
                            <input type="number" name="min_cart_value" class="form-control" value="0">
                        </div>
                        <div class="mb-3">
                            <label class="small fw-bold">Expiry Date</label>
                            <input type="date" name="expiry_date" class="form-control" required>
                        </div>
                        <button type="submit" name="add_coupon" class="btn btn-dark w-100">Create Coupon</button>
                    </form>
                </div>
            </div>
            <a href="index.php" class="btn btn-secondary btn-sm w-100">Back to Dashboard</a>
        </div>

        <div class="col-md-8">
            <div class="card border-0 shadow-sm">
                <div class="card-header bg-white fw-bold">Active Coupons</div>
                <div class="card-body p-0">
                    <table class="table table-hover mb-0">
                        <thead class="table-light">
                            <tr>
                                <th>Code</th>
                                <th>Discount</th>
                                <th>Min. Order</th>
                                <th>Expires</th>
                                <th class="text-center">Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php while($row = mysqli_fetch_assoc($coupons)): ?>
                            <tr>
                                <td class="fw-bold text-primary"><?= $row['coupon_code']; ?></td>
                                <td><?= ($row['discount_type'] == 'percentage') ? $row['discount_value'].'%' : '₹'.$row['discount_value']; ?></td>
                                <td>₹<?= $row['min_cart_value']; ?></td>
                                <td>
                                    <?php 
                                        $today = date('Y-m-d');
                                        $color = ($row['expiry_date'] < $today) ? 'text-danger' : 'text-dark';
                                    ?>
                                    <span class="<?= $color; ?>"><?= date('d M, Y', strtotime($row['expiry_date'])); ?></span>
                                </td>
                                <td class="text-center">
                                    <a href="coupons.php?delete=<?= $row['id']; ?>" class="btn btn-sm btn-outline-danger" onclick="return confirm('Delete coupon?')">
                                        <i class="fa-solid fa-trash"></i>
                                    </a>
                                </td>
                            </tr>
                            <?php endwhile; ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>

</body>
</html>