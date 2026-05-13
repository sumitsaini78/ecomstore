<?php
session_start();
include("../admin/db.php");

$error = "";

if (isset($_POST['login_vendor'])) {
    $email = mysqli_real_escape_string($conn, $_POST['email']);
    $phone = mysqli_real_escape_string($conn, $_POST['phone']); // Login via Phone as password for now

    $query = "SELECT * FROM vendors WHERE v_email = '$email' AND v_phone = '$phone' LIMIT 1";
    $result = mysqli_query($conn, $query);

    if (mysqli_num_rows($result) == 1) {
        $vendor_data = mysqli_fetch_assoc($result);
        
        // Session mein data store karna
        $_SESSION['v_id'] = $vendor_data['v_id'];
        $_SESSION['v_name'] = $vendor_data['v_name'];
        $_SESSION['v_store'] = $vendor_data['v_store'];

        header("Location: index.php");
        exit;
    } else {
        $error = "Invalid Email or Phone Number!";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <title>Vendor Login - EcomStore</title>
    <style>
        body { background: #f4f7f6; height: 100vh; display: flex; align-items: center; }
        .login-card { border: none; border-radius: 15px; box-shadow: 0 10px 25px rgba(0,0,0,0.1); }
    </style>
</head>
<body>

<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-4">
            <div class="card login-card p-4">
                <div class="text-center mb-4">
                    <h3 class="fw-bold text-primary">Vendor Login</h3>
                    <p class="text-muted small">Manage your shop & products</p>
                </div>

                <?php if($error): ?>
                    <div class="alert alert-danger small py-2"><?= $error; ?></div>
                <?php endif; ?>

                <form action="" method="POST">
                    <div class="mb-3">
                        <label class="form-label small fw-bold">Email Address</label>
                        <input type="email" name="email" class="form-control" placeholder="name@example.com" required>
                    </div>
                    <div class="mb-3">
                        <label class="form-label small fw-bold">Phone Number (Password)</label>
                        <input type="password" name="phone" class="form-control" placeholder="Enter your registered phone" required>
                    </div>
                    <button type="submit" name="login_vendor" class="btn btn-primary w-100 py-2 fw-bold">Login to Dashboard</button>
                </form>

                <div class="text-center mt-4">
                    <a href="../index.php" class="text-decoration-none small text-muted">← Back to Website</a>
                </div>
            </div>
        </div>
    </div>
</div>

</body>
</html>