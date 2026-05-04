<?php
session_start();
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
    <title>Shodio - EcomStore</title>
    <style>
        .no-scrollbar {
            -ms-overflow-style: none;

            /* Firefox */
            scrollbar-width: none;
        }

        .Product-cards {
            height: 100%;
        }

        @media screen and (min-width:600px) {
            .product-card {
                border: 2px solid red;
            }
        }
    </style>
</head>

<body class="p-0 m-0 border-0 bg-light">
    <!-- Navbar start -->
    <nav class="navbar navbar-expand-lg bg-white shadow-sm mb-4 sticky-top">
        <div class="container-fluid">
            <a class="navbar-brand fs-1 fw-bold" style="color:#570d48;" href="index.php">Shodio</a>

            <button class="navbar-toggler" type="button" data-bs-toggle="collapse"
                data-bs-target="#navbarSupportedContent">
                <span class="navbar-toggler-icon"></span>
            </button>

            <div class="collapse navbar-collapse" id="navbarSupportedContent">
                <form class="d-flex mx-auto mt-2 mt-lg-0" role="search">
                    <input class="form-control me-2" type="search"
                        placeholder="Try Saree, Kurti or Search by Product Code" style="width:400px; max-width: 100%;">
                    <button class="btn btn-outline-success" type="submit">Search</button>
                </form>

                <div class="d-flex gap-4 fs-4 align-items-center justify-content-center mt-3 mt-lg-0">
                    <a href="#" class="text-dark"><i class="fa-solid fa-user"></i></a>
                    <a href="cart.php" class="text-dark position-relative">
                        <i class="fa-solid fa-cart-shopping"></i>
                        <span class="position-absolute top-0 start-100 translate-middle badge rounded-pill bg-danger"
                            style="font-size: 10px;"><?php echo isset($_SESSION['cart']) ? array_sum(array_column($_SESSION['cart'], 'quantity')) : 0; ?></span>
                    </a>
                </div>
            </div>
        </div>
    </nav>
    <!-- Navbar ended -->


    <!-- Quick Category Menu starts -->
    <div class="container-fluid bg-white py-3 shadow-sm border-bottom">
        <!-- Added 'no-scrollbar' class here -->
        <div class="d-flex flex-nowrap overflow-x-auto gap-4 px-2 text-center no-scrollbar">

            <a href="#" class="text-decoration-none text-dark flex-shrink-0" style="width: 80px;">
                <img src="images/fruit.jpg" class="rounded-circle border p-1"
                    style="width: 70px; height: 70px; object-fit: cover;">
                <p class="small mt-2 mb-0 fw-medium">Saree</p>
            </a>

            <a href="#" class="text-decoration-none text-dark flex-shrink-0" style="width: 80px;">
                <img src="images/fruit1.jpg" class="rounded-circle border p-1"
                    style="width: 70px; height: 70px; object-fit: cover;">
                <p class="small mt-2 mb-0 fw-medium">Kurti</p>
            </a>

            <!-- Repeat for other categories... -->
            <a href="#" class="text-decoration-none text-dark flex-shrink-0" style="width: 80px;">
                <img src="images/fruit2.jpg" class="rounded-circle border p-1"
                    style="width: 70px; height: 70px; object-fit: cover;">
                <p class="small mt-2 mb-0 fw-medium">Suits</p>
            </a>

            <a href="#" class="text-decoration-none text-dark flex-shrink-0" style="width: 80px;">
                <img src="images/fruit3.jpg" class="rounded-circle border p-1"
                    style="width: 70px; height: 70px; object-fit: cover;">
                <p class="small mt-2 mb-0 fw-medium">Kids</p>
            </a>

            <a href="#" class="text-decoration-none text-dark flex-shrink-0" style="width: 80px;">
                <img src="images/fruit3.jpg" class="rounded-circle border p-1"
                    style="width: 70px; height: 70px; object-fit: cover;">
                <p class="small mt-2 mb-0 fw-medium">Offers</p>
            </a>
            <a href="#" class="text-decoration-none text-dark flex-shrink-0" style="width: 80px;">
                <img src="images/fruit3.jpg" class="rounded-circle border p-1"
                    style="width: 70px; height: 70px; object-fit: cover;">
                <p class="small mt-2 mb-0 fw-medium">Offers</p>
            </a>
            <a href="#" class="text-decoration-none text-dark flex-shrink-0" style="width: 80px;">
                <img src="images/fruit3.jpg" class="rounded-circle border p-1"
                    style="width: 70px; height: 70px; object-fit: cover;">
                <p class="small mt-2 mb-0 fw-medium">Offers</p>
            </a>
            <a href="#" class="text-decoration-none text-dark flex-shrink-0" style="width: 80px;">
                <img src="images/fruit3.jpg" class="rounded-circle border p-1"
                    style="width: 70px; height: 70px; object-fit: cover;">
                <p class="small mt-2 mb-0 fw-medium">Offers</p>
            </a>
            <a href="#" class="text-decoration-none text-dark flex-shrink-0" style="width: 80px;">
                <img src="images/fruit3.jpg" class="rounded-circle border p-1"
                    style="width: 70px; height: 70px; object-fit: cover;">
                <p class="small mt-2 mb-0 fw-medium">Offers</p>
            </a>
            <a href="#" class="text-decoration-none text-dark flex-shrink-0" style="width: 80px;">
                <img src="images/fruit3.jpg" class="rounded-circle border p-1"
                    style="width: 70px; height: 70px; object-fit: cover;">
                <p class="small mt-2 mb-0 fw-medium">Offers</p>
            </a>
            <a href="#" class="text-decoration-none text-dark flex-shrink-0" style="width: 80px;">
                <img src="images/fruit3.jpg" class="rounded-circle border p-1"
                    style="width: 70px; height: 70px; object-fit: cover;">
                <p class="small mt-2 mb-0 fw-medium">Offers</p>
            </a>
            <a href="#" class="text-decoration-none text-dark flex-shrink-0" style="width: 80px;">
                <img src="images/fruit3.jpg" class="rounded-circle border p-1"
                    style="width: 70px; height: 70px; object-fit: cover;">
                <p class="small mt-2 mb-0 fw-medium">Offers</p>
            </a>
            <a href="#" class="text-decoration-none text-dark flex-shrink-0" style="width: 80px;">
                <img src="images/fruit3.jpg" class="rounded-circle border p-1"
                    style="width: 70px; height: 70px; object-fit: cover;">
                <p class="small mt-2 mb-0 fw-medium">Offers</p>
            </a>

        </div>
    </div>
    <!-- CART details starts -->
    <?php
    // 1. Quantity Update Logic
    if (isset($_POST['update_qty'])) {
        $id = $_POST['product_id'];
        $new_qty = (int) $_POST['quantity'];
        if ($new_qty > 0) {
            $_SESSION['cart'][$id]['quantity'] = $new_qty;
        }
        header("Location: cart.php"); // Refresh to update totals
        exit();
    }

    // 2. Remove Item Logic
    if (isset($_GET['remove'])) {
        $id = $_GET['remove'];
        unset($_SESSION['cart'][$id]);
        header("Location: cart.php");
        exit();
    }

    $total_bill = 0;
    ?>

    <!-- Cart Table Section -->
    <section class="container my-5">
        <h2 class="fw-bold mb-4" style="color:#570d48;">Your Shopping Cart</h2>

        <?php if (!empty($_SESSION['cart'])): ?>
            <div class="table-responsive shadow-sm rounded bg-white">
                <table class="table table-hover align-middle mb-0">
                    <thead class="text-white" style="background-color: #570d48;">
                        <tr>
                            <th class="p-3">Product</th>
                            <th>Price</th>
                            <th>Quantity</th>
                            <th>Subtotal</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($_SESSION['cart'] as $id => $item):
                            $subtotal = $item['price'] * $item['quantity'];
                            $total_bill += $subtotal;
                            ?>
                            <tr>
                                <td class="p-3 fw-medium"><?php echo $item['name']; ?></td>
                                <td class="text-muted">₹<?php echo number_format($item['price'], 2); ?></td>
                                <td>
                                    <form method="POST" action="" class="d-flex gap-2">
                                        <input type="hidden" name="product_id" value="<?php echo $id; ?>">
                                        <input type="number" name="quantity" class="form-control form-control-sm" value="<?php echo $item['quantity']; ?>" min="1"
                                            style="width: 60px;">
                                        <button type="submit" name="update_qty" class="btn btn-sm btn-outline-primary">Update</button>
                                    </form>
                                </td>
                                <td class="fw-bold text-success">₹<?php echo number_format($subtotal, 2); ?></td>
                                <td>
                                    <a href="cart.php?remove=<?php echo $id; ?>" class="btn btn-sm btn-outline-danger"
                                        onclick="return confirm('Remove item?')"><i class="fa-solid fa-trash"></i></a>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                    </tbody>
                    <tfoot class="table-light">
                        <tr class="fs-5">
                            <td colspan="3" class="text-end fw-bold p-3">Grand Total:</td>
                            <td colspan="2" class="fw-bold text-primary">₹<?php echo number_format($total_bill, 2); ?></td>
                        </tr>
                    </tfoot>
                </table>
            </div>

            <div class="mt-4 d-flex justify-content-between">
                <a href="index.php" class="btn btn-outline-secondary px-4">Continue Shopping</a>
                <a href="checkout.php" class="btn btn-success btn-lg px-5 shadow">Proceed to Checkout</a>
            </div>

        <?php else: ?>
            <div class="text-center py-5 bg-white rounded shadow-sm">
                <i class="fa-solid fa-cart-shopping fs-1 text-muted mb-3"></i>
                <p class="fs-4 text-muted">Your cart is empty.</p>
                <a href="index.php" class="btn btn-primary px-4">Shop Now</a>
            </div>
        <?php endif; ?>
    </section>
    <!-- CART details ended -->


    <!-- 5. Footer -->
    <footer class="bg-white border-top py-4 mt-5">
        <div class="container text-center">
            <h4 class="fw-bold" style="color: var(--brand-color);">Shodio</h4>
            <p class="text-muted small">© 2026 Shodio E-Commerce. All rights reserved.</p>
            <div class="d-flex justify-content-center gap-3 fs-5">
                <i class="fa-brands fa-instagram"></i>
                <i class="fa-brands fa-facebook"></i>
                <i class="fa-brands fa-whatsapp"></i>
            </div>
        </div>
    </footer>
    <!-- footer ended -->


    <!-- Bootstrap JS Bundle -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>