<!doctype html>
<html lang="en" data-bs-theme="light">

<head>
    <title>Title</title>
    <!-- Required meta tags -->
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />

    <!-- Bootstrap CSS v5.3.8 -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-sRIl4kxILFvY47J16cr9ZwB07vP4J8+LH7qKQnuqkuIAvNWLzeN8tE5YBujZqJLB" crossorigin="anonymous" />
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">

</head>

<body>
    <!-- nav starts -->
    <nav class="navbar navbar-expand-lg bg-white shadow-sm mb-4 sticky-top">
        <div class="container-fluid">
            <a class="navbar-brand fs-1 fw-bold" style="color: var(--brand-color);" href="index.php">Shodio</a>

            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navContent">
                <span class="navbar-toggler-icon"></span>
            </button>

            <div class="collapse navbar-collapse" id="navContent">
                <form class="d-flex mx-auto mt-2 mt-lg-0" role="search">
                    <input class="form-control me-2" type="search" placeholder="Search for Sarees, Kurtis..."
                        style="width:350px;">
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
    <!-- nav ends -->
    <div class="container-fluid w-50 border border-warning p-3 border rounded-4">
      
      <div class="container mt-5">
    <form method="post" action="">
        <div class="form-group">
            <h6 class="fw-bold">Fill the Form Below: </h6>
            <div class="mb-3">
                <label class="form-label">Email address</label>
                <input type="email" class="form-control" name="email" placeholder="name@example.com" required>
            </div>
            <div class="mb-3">
                <label class="form-label">Phone Number</label>
                <input type="number" class="form-control" name="number" placeholder="Phone number" required>
            </div>
            <div class="mb-3">
                <label class="form-label">Your Query</label>
                <textarea class="form-control" name="query" rows="3" required></textarea>
            </div>
        </div>
        <!-- Button ko name dena zaroori hai PHP check ke liye -->
        <button type="submit" name="submit_query" class="btn btn-primary">Submit</button>
    </form>

    <?php
    if (isset($_POST["submit_query"])) {
        // Database connection include karein
        include("admin/db.php");

        // Data sanitize karein (Security ke liye)
        $user_email = mysqli_real_escape_string($conn, $_POST["email"]);
        $user_number = mysqli_real_escape_string($conn, $_POST["number"]);
        $user_query = mysqli_real_escape_string($conn, $_POST["query"]);

        // Database mein save karein
        $sql = "INSERT INTO users_query (user_email, user_number, user_query) VALUES ('$user_email', '$user_number', '$user_query')";

        if (mysqli_query($conn, $sql)) {
            echo "<div class='alert alert-success mt-3'>Thank you! Your query has been submitted.</div>";
        } else {
            echo "<div class='alert alert-danger mt-3'>Error: " . mysqli_error($conn) . "</div>";
        }
    }
    ?>
</div>
    </div>
    <!-- Footer -->
    <footer class="bg-white border-top py-5 mt-5">
        <div class="container text-center">
            <h3 class="fw-bold mb-3" style="color: var(--brand-color);">Shodio</h3>
            <div class="d-flex justify-content-center gap-4 fs-4 mb-4">
                <a href="#" class="text-dark"><i class="fa-brands fa-instagram"></i></a>
                <a href="#" class="text-dark"><i class="fa-brands fa-facebook"></i></a>
                <a href="#" class="text-dark"><i class="fa-brands fa-whatsapp"></i></a>
            </div>
            <p class="text-secondary x-small">© 2026 Shodio E-Commerce. All rights reserved.</p>
        </div>
    </footer>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-FKyoEForCGlyvwx9Hj09JcYn3nv7wiPVlz7YYwJrWVcXK/BmnVDxM+D2scQbITxI"
        crossorigin="anonymous"></script>
</body>

</html>