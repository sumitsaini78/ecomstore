<?php
session_start();
include('includes/db.php');

// Agar user logged in nahi hai toh login page pe bhejo
if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit();
}

$user_id = $_SESSION['user_id'];
$cart_total = 1499; // Ye value aapke cart.php se ya session se aayegi

if (isset($_POST['place_order'])) {
    $address = mysqli_real_escape_string($conn, $_POST['address']);
    
    // 1. Insert into 'orders' table
    $order_query = "INSERT INTO orders (user_id, total_amount, shipping_address) VALUES ('$user_id', '$cart_total', '$address')";
    
    if (mysqli_query($conn, $order_query)) {
        $order_id = mysqli_insert_id($conn); // Naya order ID mil gaya

        // 2. Insert into 'order_items' (Loop chalega jitne items cart mein hain)
        // For example, dummy data:
        mysqli_query($conn, "INSERT INTO order_items (order_id, product_id, quantity, price) VALUES ('$order_id', '1', '1', '1499')");

        // 3. Cart khali karein aur confirmation dikhayein
        echo "<script>alert('Order Placed Successfully! Order ID: #$order_id'); window.location='profile.php';</script>";
    }
}
?>

<!doctype html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <title>Checkout - Shodio</title>
</head>
<body class="bg-light">

<div class="container my-5">
    <div class="row">
        <!-- Billing Details Form -->
        <div class="col-md-7">
            <div class="card shadow-sm border-0 p-4">
                <h4 class="mb-4 fw-bold" style="color:#570d48;">Shipping Details</h4>
                <form method="POST">
                    <div class="mb-3">
                        <label class="form-label">Full Name</label>
                        <input type="text" class="form-control" placeholder="John Doe" required>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Phone Number</label>
                        <input type="number" class="form-control" placeholder="9876543210" required>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Full Address</label>
                        <textarea name="address" class="form-control" rows="3" placeholder="House No, Street, City, Pincode" required></textarea>
                    </div>
                    
                    <h5 class="mt-4 mb-3 fw-bold">Payment Method</h5>
                    <div class="form-check border p-3 rounded mb-2">
                        <input class="form-check-input ms-1" type="radio" name="payment" checked>
                        <label class="form-check-label ms-2">Cash on Delivery (COD)</label>
                    </div>

                    <button type="submit" name="place_order" class="btn btn-lg text-white w-100 mt-3" style="background-color:#570d48;">Place Order</button>
                </form>
            </div>
        </div>

        <!-- Order Summary -->
        <div class="col-md-5 mt-4 mt-md-0">
            <div class="card shadow-sm border-0 p-4">
                <h4 class="mb-4 fw-bold">Order Summary</h4>
                <div class="d-flex justify-content-between mb-2">
                    <span>Subtotal</span>
                    <span>₹1,499.00</span>
                </div>
                <div class="d-flex justify-content-between mb-2">
                    <span>Shipping</span>
                    <span class="text-success">FREE</span>
                </div>
                <hr>
                <div class="d-flex justify-content-between fw-bold fs-5">
                    <span>Total</span>
                    <span style="color:#570d48;">₹1,499.00</span>
                </div>
            </div>
        </div>
    </div>
</div>

</body>
</html>