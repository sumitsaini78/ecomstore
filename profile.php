<!-- - profile.php → User profile, orders, wishlist -->
<?php include("admin/db.php"); ?>
<?php
session_start();

?>
<!doctype html>
<html lang="en" data-bs-theme="light">

<head>
    <title>Title</title>
    <!-- Required meta tags -->
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">

    <!-- Bootstrap CSS v5.3.8 -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-sRIl4kxILFvY47J16cr9ZwB07vP4J8+LH7qKQnuqkuIAvNWLzeN8tE5YBujZqJLB" crossorigin="anonymous" />
</head>

<body>
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
                    <div class="d-flex gap-4 fs-4 align-items-center justify-content-center mt-3 mt-lg-0">
                        <?php if (isset($_SESSION['user_id'])): ?>
                            <div class="dropdown">
                                <a class="text-dark text-decoration-none dropdown-toggle fs-6 fw-bold" href="#"
                                    role="button" data-bs-toggle="dropdown">
                                    <i class="fa-solid fa-circle-user me-1"></i>
                                    Hi,
                                    <?php echo explode(' ', $_SESSION['user_name'])[0]; ?>
                                </a>
                                <ul class="dropdown-menu shadow-sm">
                                    <li><a class="dropdown-item" href="profile.php"><i class="fa-solid fa-id-card me-2"></i>
                                            My Profile</a></li>
                                    <li>
                                        <hr class="dropdown-divider">
                                    </li>
                                    <li><a class="dropdown-item text-danger" href="logout.php"><i
                                                class="fa-solid fa-right-from-bracket me-2"></i> Logout</a></li>
                                </ul>
                            </div>
                        <?php else: ?>
                            <a href="login.php" class="text-dark text-decoration-none fs-6 fw-bold">
                                <i class="fa-solid fa-user"></i> Login
                            </a>
                        <?php endif; ?>

                        <a href="checkout.php" class="text-dark position-relative">
                            <i class="fa-solid fa-cart-shopping"></i>
                            <span
                                class="position-absolute top-0 start-100 translate-middle badge rounded-pill bg-danger"
                                style="font-size: 10px;">
                                <?php echo isset($_SESSION['cart']) ? array_sum(array_column($_SESSION['cart'], 'quantity')) : 0; ?>
                            </span>
                        </a>
                    </div>

                </div>
            </div>
        </div>
    </nav>
    <!-- Navbar ended -->
    <main>
        <div class="card m-auto" style="width: 80%">
            <div class="col align-self-center">
                <i class="fa-solid fa-circle-user fa-2x mt-3"></i>

            </div>

            <div class="card-body">
                <h5 class="card-title">
                    <?php
                    $result = mysqli_query($conn, "SELECT name FROM users ");
                    $row = mysqli_fetch_assoc($result);
                    if ($row) {
                        $username = $row['name'];
                        echo $username;
                    } else {
                        echo "user not found";
                    }

                    ?>
                </h5>
                <p class="card-text">Some quick example text to build on the card title and make up the bulk of the
                    card’s content.</p>
            </div>
            <div class="card-body">
                <div class="row border ">
                    <div class="col text-center">
                        <h2>orders</h2>
                        <div class="col">
                            <?php
                            // Maan lete hain user login hai aur uski ID session mein hai
                            $user_id = $_SESSION['user_id'];

                            // SQL JOIN: orders aur order_items ko aapas mein joda gaya hai
                            $query = "SELECT oi.product_name, oi.product_price, o.order_date 
          FROM order_items oi
          JOIN orders o ON oi.order_id = o.id 
          WHERE o.user_id = '$user_id' 
          ORDER BY o.order_date DESC";

                            $result = mysqli_query($conn, $query);

                            if (mysqli_num_rows($result) > 0) {
                                echo "<h5>Aapke Orders:</h5>";
                                echo "<ul class='list-group'>";

                                while ($row = mysqli_fetch_assoc($result)) {
                                    echo "<li class='list-group-item d-flex justify-content-between align-items-center'>";
                                    echo $row['product_name']; // Product ka naam
                                    echo "<span class='badge bg-success rounded-pill'>₹" . number_format($row['product_price']) . "</span>"; // Amount
                                    echo "</li>";
                                }

                                echo "</ul>";
                            } else {
                                echo "Aapne abhi tak koi order nahi kiya hai.";
                            }
                            ?>
                        </div>
                    </div>
                    <div class="col text-center">
                        <h2>wishlist</h2>
                        <div class="col">
                            <?php
                            $query = "select product_title from wishlist";
                            $result = mysqli_query($conn, $query);
                            $row = mysqli_fetch_assoc($result);
print_r($row);
                            foreach ($row as $pt) {
                                echo $pt ;
                            }
                            // Output: Red Green Blue 
                            


                            ?>

                        </div>
                    </div>
                </div>
            </div>
        </div>



    </main>
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
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-FKyoEForCGlyvwx9Hj09JcYn3nv7wiPVlz7YYwJrWVcXK/BmnVDxM+D2scQbITxI"
        crossorigin="anonymous"></script>

</body>

</html>