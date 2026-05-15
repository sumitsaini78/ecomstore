<?php
session_start();
include("admin/db.php");

// 1. Handle Add/Update Cart Logic
if (isset($_POST['update_cart'])) {
    $product_id = $_POST['product_id'];
    $action = $_POST['action'];

    if (!isset($_SESSION['cart'])) {
        $_SESSION['cart'] = [];
    }

    if ($action == 'add' || $action == 'increase') {
        if (isset($_SESSION['cart'][$product_id])) {
            $_SESSION['cart'][$product_id]['quantity'] += 1;
        } else {
            $product_name = $_POST['product_name'];
            $product_price = $_POST['product_price'];
            $_SESSION['cart'][$product_id] = [
                'name' => $product_name,
                'price' => (float) $product_price,
                'quantity' => 1
            ];
        }
    } elseif ($action == 'decrease') {
        if (isset($_SESSION['cart'][$product_id])) {
            $_SESSION['cart'][$product_id]['quantity'] -= 1;
            if ($_SESSION['cart'][$product_id]['quantity'] <= 0) {
                unset($_SESSION['cart'][$product_id]);
            }
        }
    }
    header("Location: " . $_SERVER['PHP_SELF']);
    exit;
}

// 2. Fetch Products (Using a unique variable name: $product_result)
$product_result = mysqli_query($conn, "SELECT id, name, description, price, image FROM products");
if (!$product_result) {
    die("Query Failed: " . mysqli_error($conn));
}
?>

<!doctype html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
    <title>Shodio - EcomStore</title>
    <style>
        :root {
            --brand-color: #570d48;
        }

        .no-scrollbar::-webkit-scrollbar {
            display: none;
        }

        .no-scrollbar {
            -ms-overflow-style: none;
            scrollbar-width: none;
        }

        .product-card {
            transition: transform 0.2s;
            border-radius: 15px !important;
            overflow: hidden;
        }

        .product-card:hover {
            transform: translateY(-5px);
            box-shadow: 0 10px 20px rgba(0, 0, 0, 0.1) !important;
        }

        .banner-img {
            height: 350px;
            object-fit: cover;
        }

        @media (max-width: 768px) {
            .banner-img {
                height: 160px;
            }
        }
    </style>
</head>

<body class="bg-light">
    <!-- Navbar -->
    <nav class="navbar navbar-expand-lg bg-white shadow-sm mb-4 sticky-top">
        <div class="container-fluid">
            <a class="navbar-brand fs-1 fw-bold" style="color: var(--brand-color);" href="index.php">Shodio</a>

            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navContent">
                <span class="navbar-toggler-icon"></span>
            </button>

            <div class="collapse navbar-collapse" id="navContent">
                <form class="d-flex mx-auto mt-2 mt-lg-0" action="search.php" method="GET" role="search">
                    <!-- 'name' attribute dena bahut zaroori hai -->
                    <input class="form-control me-2" type="search" name="q"
                        placeholder="Try Saree, Kurti or Search by Product Code" style="width:400px; max-width: 100%;"
                        required>
                    <button class="btn btn-outline-success" type="submit">Search</button>
                </form>

                <div class="d-flex gap-4 fs-4 align-items-center justify-content-center mt-3 mt-lg-0">
                    <!-- USER LOGIN LOGIC -->
                    <?php
                    if (isset($_SESSION['user_id'])):
                        $u_id = $_SESSION['user_id'];
                        // Unique variable name for user query
                        $user_res = mysqli_query($conn, "SELECT name FROM users WHERE id = '$u_id'");
                        $user_data = mysqli_fetch_assoc($user_res);
                        ?>
                        <div class="dropdown">
                            <a href="#" class="text-dark dropdown-toggle text-decoration-none d-flex align-items-center"
                                data-bs-toggle="dropdown">
                                <i class="fa-solid fa-circle-user text-success me-1"></i>
                                <span class="fs-6 fw-bold"><?= explode(' ', $user_data['name'])[0]; ?></span>
                            </a>
                            <ul class="dropdown-menu dropdown-menu-end shadow border-0">
                                <li><a class="dropdown-item" href="profile.php"><i
                                            class="fa-solid fa-user me-2"></i>Profile</a></li>
                                <li><a class="dropdown-item" href="orders.php"><i
                                            class="fa-solid fa-box me-2"></i>Orders</a></li>
                                <li>
                                    <hr class="dropdown-divider">
                                </li>
                                <li><a class="dropdown-item text-danger" href="logout.php"><i
                                            class="fa-solid fa-right-from-bracket me-2"></i>Logout</a></li>
                            </ul>
                        </div>
                    <?php else: ?>
                        <a href="login.php" class="text-dark" title="Login"><i class="fa-solid fa-user"></i></a>
                    <?php endif; ?>

                    <!-- CART ICON -->
                    <a href="cart.php" class="text-dark position-relative">
                        <i class="fa-solid fa-cart-shopping"></i>
                        <span class="position-absolute top-0 start-100 translate-middle badge rounded-pill bg-danger"
                            style="font-size: 10px;">
                            <?= isset($_SESSION['cart']) ? array_sum(array_column($_SESSION['cart'], 'quantity')) : 0; ?>
                        </span>
                    </a>
                    <a href="contact-us.php"><i class="fa-solid fa-headset"></i></a>
                </div>
            </div>
        </div>
    </nav>

    <!-- Categories Menu -->
    <div class="container-fluid bg-white py-3 shadow-sm border-bottom mb-4">
        <div class="d-flex flex-nowrap overflow-x-auto gap-4 px-2 text-center no-scrollbar">
            <?php
            $query = "SELECT * FROM categories";
            $result = mysqli_query($conn, $query);

            // Check if there are results in the database
            if (mysqli_num_rows($result) > 0) {
                while ($row = mysqli_fetch_assoc($result)) {
                    ?>
                    <a href="category.php?id=<?= $row['category_id']; ?>" class="text-decoration-none text-dark flex-shrink-0"
                        style="width: 80px;">
                        <img src="cat_images/<?= $row['cat_img']; ?>" class="rounded-circle border p-1"
                            style="width: 60px; height: 60px; object-fit: cover;" alt="<?= $row['cat_title']; ?>">
                        <p class="small mt-2 mb-0 fw-medium"><?= $row['cat_title']; ?></p>
                    </a>
                    <?php
                }
            } else {
                // FALLBACK: If database is empty, show your hardcoded list
                $categories = ['Saree', 'Kurti', 'Suits', 'Kids', 'Western', 'Jewelry', 'Sale', 'New'];
                foreach ($categories as $cat): ?>
                    <a href="#" class="text-decoration-none text-dark flex-shrink-0" style="width: 80px;">
                        <img src="images/fruit.jpg" class="rounded-circle border p-1"
                            style="width: 60px; height: 60px; object-fit: cover;">
                        <p class="small mt-2 mb-0 fw-medium"><?= $cat; ?></p>
                    </a>
                <?php endforeach;
            } ?>
        </div>
    </div>

    <!-- Main Products Section -->
    <div class="container my-5">
        <div class="d-flex justify-content-between align-items-center mb-4">
            <h2 class="fw-bold mb-0" style="color: var(--brand-color);">Featured Products</h2>
            <a href="all_products.php" class="btn btn-sm btn-outline-dark rounded-pill px-3">View All</a>
        </div>

        <div class="row row-cols-2 row-cols-md-3 row-cols-lg-4 g-3">
            <?php while ($row = mysqli_fetch_assoc($product_result)):
                $id = $row['id'];
                ?>
                <div class="col">
                    <div class="card h-100 border-0 shadow-sm product-card">
                        <a href="product.php?id=<?= $id; ?>" class="text-decoration-none text-dark">
                            <img src="images/<?= $row['image']; ?>" class="card-img-top p-2"
                                style="height: 200px; object-fit: contain;" alt="<?= $row['name']; ?>">
                            <div class="px-3 py-2">
                                <h6 class="text-truncate mb-1"><?= $row['name']; ?></h6>
                                <p class="fw-bold text-success mb-2">₹<?= number_format($row['price'], 2); ?></p>
                            </div>
                        </a>

                        <div class="card-body pt-0 mt-auto">
                            <div class="d-flex align-items-center gap-1">
                                <!-- CART LOGIC -->
                                <div class="flex-grow-1">
                                    <?php if (isset($_SESSION['cart'][$id])): ?>
                                        <div class="btn-group btn-group-sm w-100 border rounded-pill overflow-hidden">
                                            <form method="POST" class="m-0">
                                                <input type="hidden" name="product_id" value="<?= $id; ?>">
                                                <input type="hidden" name="action" value="decrease">
                                                <button type="submit" name="update_cart"
                                                    class="btn btn-light border-0">-</button>
                                            </form>
                                            <button type="button" class="btn btn-white disabled fw-bold border-0 flex-grow-1">
                                                <?= $_SESSION['cart'][$id]['quantity']; ?>
                                            </button>
                                            <form method="POST" class="m-0">
                                                <input type="hidden" name="product_id" value="<?= $id; ?>">
                                                <input type="hidden" name="action" value="increase">
                                                <button type="submit" name="update_cart"
                                                    class="btn btn-light border-0">+</button>
                                            </form>
                                        </div>
                                    <?php else: ?>
                                        <form method="POST" class="m-0">
                                            <input type="hidden" name="product_id" value="<?= $id; ?>">
                                            <input type="hidden" name="product_name" value="<?= $row['name']; ?>">
                                            <input type="hidden" name="product_price" value="<?= $row['price']; ?>">
                                            <input type="hidden" name="action" value="add">
                                            <button type="submit" name="update_cart"
                                                class="btn btn-sm btn-outline-success w-100 rounded-pill">Add to Cart</button>
                                        </form>
                                    <?php endif; ?>
                                </div>

                                <!-- WISHLIST TOGGLE -->
                                <form method="POST" action="wishlist_action.php" class="m-0">
                                    <input type="hidden" name="product_id" value="<?= $id; ?>">
                                    <input type="hidden" name="product_title" value="<?=
                                        $product_name; ?>">
                        
                                    <button type="submit" name="add_to_wishlist"
                                        class="btn btn-sm btn-outline-danger border-0 rounded-circle">
                                        <?php
                                        $u_id = $_SESSION['user_id'] ?? 0;
                                        $heart = "fa-regular";
                                        if ($u_id > 0) {
                                            $check = mysqli_query($conn, "SELECT id FROM wishlist WHERE user_id = '$u_id' AND product_id = '$id'");
                                            if (mysqli_num_rows($check) > 0)
                                                $heart = "fa-solid";
                                        }
                                        ?>
                                        <i class="<?= $heart; ?> fa-heart fs-5"></i>
                                    </button id="catin">
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            <?php endwhile; ?>
        </div>
    </div>
    <main>



    </main>
    <!-- Footer -->
    <footer class="bg-white border-top py-5 mt-5">
        <div class="container text-center">
            <div class="d-flex justify-content-center gap-4 fs-4 mb-4">
                <a href="#" class="text-dark"><i class="fa-brands fa-instagram"></i></a>
                <a href="#" class="text-dark"><i class="fa-brands fa-facebook"></i></a>
                <a href="#" class="text-dark"><i class="fa-brands fa-whatsapp"></i></a>
            </div>

            <h3 class="fw-bold mb-3" style="color: var(--brand-color);">Shodio</h3>

            <p class="text-secondary x-small">© 2026 Shodio E-Commerce. All rights reserved.</p>
        </div>
    </footer>
<!-- <script>
document.getElementById("#catin").addEventListener(click,function alert($product_name) 
{
alert($product_name);    
})
</script> -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>