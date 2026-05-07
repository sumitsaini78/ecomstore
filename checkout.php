<?php
session_start();

// 1. Handle Cart Updates (Plus, Minus, Remove)
if (isset($_POST['update_cart_action'])) {
    $product_id = $_POST['product_id'];
    $action = $_POST['action'];

    if ($action == 'increase') {
        $_SESSION['cart'][$product_id]['quantity'] += 1;
    } elseif ($action == 'decrease') {
        $_SESSION['cart'][$product_id]['quantity'] -= 1;
        if ($_SESSION['cart'][$product_id]['quantity'] <= 0) {
            unset($_SESSION['cart'][$product_id]);
        }
    } elseif ($action == 'remove') {
        unset($_SESSION['cart'][$product_id]);
    }
    
    // Refresh to update totals
    header("Location: checkout.php");
    exit();
}

$cart_items = isset($_SESSION['cart']) ? $_SESSION['cart'] : [];
$total_items = array_sum(array_column($cart_items, 'quantity'));
$subtotal = 0;
?>

<!doctype html>
<html lang="en">

<head>
    <title>Meesho | Checkout</title>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
    
    <style>
        :root { --meesho-pink: #f43397; --bg-light: #f8f9fa; --brand-color: #570d48; }
        body { background-color: var(--bg-light); font-family: sans-serif; }
        .product-card { border: 1px solid #ebebeb; border-radius: 8px; margin-bottom: 12px; background: #fff; padding: 16px; }
        .product-img { width: 80px; height: 100px; object-fit: cover; border-radius: 4px; }
        .qty-btn { border: 1px solid #ddd; background: white; width: 32px; height: 32px; display: flex; align-items: center; justify-content: center; border-radius: 4px; cursor: pointer; }
        .action-link { color: var(--meesho-pink); font-weight: 600; font-size: 14px; border: none; background: none; cursor: pointer; }
        .price-details-card { background: #fff; padding: 20px; border-radius: 8px; border: 1px solid #ebebeb; position: sticky; top: 90px; }
        .btn-continue { background-color: var(--meesho-pink); color: white; width: 100%; padding: 12px; font-weight: 700; border-radius: 4px; border: none; }
    </style>
</head>

<body>

    <nav class="navbar navbar-expand-lg bg-white shadow-sm mb-4 sticky-top">
        <div class="container-fluid">
            <a class="navbar-brand fs-1 fw-bold" style="color:var(--brand-color);" href="index.php">Shodio</a>
            <div class="d-flex gap-4 fs-4 align-items-center">
                <?php if (isset($_SESSION['user_id'])): ?>
                    <span class="fs-6 fw-bold">Hi, <?php echo explode(' ', $_SESSION['user_name'])[0]; ?></span>
                <?php else: ?>
                    <a href="login.php" class="text-dark fs-6 fw-bold text-decoration-none"><i class="fa-solid fa-user"></i> Login</a>
                <?php endif; ?>
                
                <a href="checkout.php" class="text-dark position-relative">
                    <i class="fa-solid fa-cart-shopping"></i>
                    <span class="position-absolute top-0 start-100 translate-middle badge rounded-pill bg-danger" style="font-size: 10px;">
                        <?php echo $total_items; ?>
                    </span>
                </a>
            </div>
        </div>
    </nav>

    <div class="container my-5">
        <div class="row">
            <div class="col-lg-8">
                <h4 class="mb-4">Cart | <span class="text-muted fs-6"><?php echo $total_items; ?> Items</span></h4>

                <?php if (empty($cart_items)): ?>
                    <div class="text-center p-5 bg-white rounded shadow-sm">
                        <h5>Your cart is empty</h5>
                        <a href="index.php" class="btn btn-outline-primary mt-3">Go to Shop</a>
                    </div>
                <?php else: ?>
                    <?php foreach ($cart_items as $id => $item): 
                        $item_total = $item['price'] * $item['quantity'];
                        $subtotal += $item_total;
                    ?>
                        <div class="product-card">
                            <div class="d-flex">
                                <img src="images/fruit.jpg" class="product-img" alt="Product">
                                <div class="ms-3 flex-grow-1">
                                    <div class="fw-bold"><?php echo $item['name']; ?></div>
                                    <div class="text-muted small">Qty: <?php echo $item['quantity']; ?></div>
                                    <div class="fs-5 fw-bold my-2">₹<?php echo number_format($item['price']); ?></div>
                                    
                                    <div class="d-flex align-items-center justify-content-between mt-3">
                                        <form method="POST" class="d-flex align-items-center gap-2">
                                            <input type="hidden" name="product_id" value="<?php echo $id; ?>">
                                            <button type="submit" name="update_cart_action" value="1" class="qty-btn">
                                                <input type="hidden" name="action" value="decrease">-
                                            </button>
                                            <span class="fw-bold"><?php echo $item['quantity']; ?></span>
                                            <button type="submit" name="update_cart_action" value="1" class="qty-btn">
                                                <input type="hidden" name="action" value="increase">+
                                            </button>
                                        </form>

                                        <form method="POST">
                                            <input type="hidden" name="product_id" value="<?php echo $id; ?>">
                                            <input type="hidden" name="action" value="remove">
                                            <button type="submit" name="update_cart_action" class="action-link">REMOVE</button>
                                        </form>
                                    </div>
                                </div>
                            </div>
                        </div>
                    <?php endforeach; ?>
                <?php endif; ?>
            </div>

            <div class="col-lg-4">
                <div class="price-details-card">
                    <h6 class="text-muted mb-4 fw-bold">PRICE DETAILS</h6>
                    <div class="d-flex justify-content-between mb-2">
                        <span>Total Product Price</span>
                        <span>₹<?php echo number_format($subtotal); ?></span>
                    </div>
                    <div class="d-flex justify-content-between mb-2 text-success">
                        <span>Total Discounts</span>
                        <?php $discount = ($subtotal > 0) ? 150 : 0; ?>
                        <span>- ₹<?php echo $discount; ?></span>
                    </div>
                    <div class="d-flex justify-content-between mb-2">
                        <span>Delivery Charges</span>
                        <span class="text-success">FREE</span>
                    </div>
                    <hr>
                    <div class="d-flex justify-content-between fw-bold fs-5 mb-4">
                        <span>Order Total</span>
                        <span>₹<?php echo number_format($subtotal - $discount); ?></span>
                    </div>
 
                    <button class="btn btn-continue">Continue</button>
                </div>
            </div>
        </div>
    </div>

    <footer class="bg-white border-top py-4 mt-5">
        <div class="container text-center">
            <h4 class="fw-bold" style="color: var(--brand-color);">Shodio</h4>
            <p class="text-muted small">© 2026 Shodio E-Commerce.</p>
        </div>
    </footer>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>