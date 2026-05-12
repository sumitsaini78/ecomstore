<?php
session_start();
include("admin/db.php");

// 1. Get the search query from URL
$query = "";
if (isset($_GET['q'])) {
    $query = mysqli_real_escape_string($conn, $_GET['q']);
}

// 2. Fetch matching products
// Hum 'name' aur 'description' dono mein search kar rahe hain
$sql = "SELECT * FROM products WHERE name LIKE '%$query%' OR description LIKE '%$query%'";
$search_result = mysqli_query($conn, $sql);

if (!$search_result) {
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
    <title>Search Results for "<?php echo htmlspecialchars($query); ?>" - Shodio</title>
</head>

<body class="bg-light">

    <!-- Aap yahan apna Navbar include kar sakte hain -->
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
    </nav>
    <main>



    <?php
// session_start();
include("admin/db.php");

// 1. Inputs collect karein
$search_q = $_GET['q'] ?? '';
$cat_filter = $_GET['category'] ?? '';
$price_filter = $_GET['max_price'] ?? 5000;
$sort_filter = $_GET['sort'] ?? 'newest';

// 2. Base SQL Query (1=1 trick)
$sql = "SELECT * FROM products WHERE 1=1";

// 3. Agar search keyword hai
if (!empty($search_q)) {
    $search_q = mysqli_real_escape_string($conn, $search_q);
    $sql .= " AND (name LIKE '%$search_q%' OR description LIKE '%$search_q%')";
}

// 4. Agar category filter selected hai
if (!empty($cat_filter)) {
    $cat_filter = mysqli_real_escape_string($conn, $cat_filter);
    $sql .= " AND category = '$cat_filter'";
}

// 5. Price filter
$sql .= " AND price <= " . (int)$price_filter;

// 6. Sorting logic
if ($sort_filter == 'low') {
    $sql .= " ORDER BY price ASC";
} elseif ($sort_filter == 'high') {
    $sql .= " ORDER BY price DESC";
} else {
    $sql .= " ORDER BY id DESC"; // Newest
}

$result = mysqli_query($conn, $sql);
?>
<div class="container mt-4">
    <div class="row">
        <!-- Sidebar Filters -->
        <div class="col-md-3">
            <div class="card border-0 shadow-sm p-3 sticky-top" style="top: 90px;">
                <h5 class="fw-bold mb-3">Refine Search</h5>
                
                <form action="search.php" method="GET">
                    <!-- CRITICAL: Search query ko preserve rakhein -->
                    <input type="hidden" name="q" value="<?= htmlspecialchars($search_q); ?>">

                    <!-- Category Filter -->
                    <div class="mb-3">
                        <label class="fw-bold small">Category</label>
                        <select name="category" class="form-select form-select-sm" onchange="this.form.submit()">
                            <option value="">All Categories</option>
                            <option value="Saree" <?= $cat_filter == 'Saree' ? 'selected' : ''; ?>>Saree</option>
                            <option value="Kurti" <?= $cat_filter == 'Kurti' ? 'selected' : ''; ?>>Kurti</option>
                        </select>
                    </div>

                    <!-- Price Filter -->
                    <div class="mb-3">
                        <label class="fw-bold small">Max Price: ₹<span id="p_val"><?= $price_filter; ?></span></label>
                        <input type="range" name="max_price" class="form-range" min="100" max="5000" step="100" 
                               value="<?= $price_filter; ?>" oninput="document.getElementById('p_val').innerText = this.value">
                    </div>

                    <!-- Sort Filter -->
                    <div class="mb-3">
                        <label class="fw-bold small">Sort By</label>
                        <select name="sort" class="form-select form-select-sm" onchange="this.form.submit()">
                            <option value="newest" <?= $sort_filter == 'newest' ? 'selected' : ''; ?>>Newest First</option>
                            <option value="low" <?= $sort_filter == 'low' ? 'selected' : ''; ?>>Price: Low to High</option>
                            <option value="high" <?= $sort_filter == 'high' ? 'selected' : ''; ?>>Price: High to Low</option>
                        </select>
                    </div>

                    <button type="submit" class="btn btn-primary btn-sm w-100">Apply Filters</button>
                    <a href="search.php?q=<?= $search_q; ?>" class="btn btn-link btn-sm w-100 text-decoration-none">Reset</a>
                </form>
            </div>
        </div>

        <!-- Results Grid -->
        <div class="col-md-9">
            <p class="text-muted small">Showing results for "<?= htmlspecialchars($search_q); ?>"</p>
            <div class="row row-cols-2 row-cols-lg-3 g-3">
                <?php if(mysqli_num_rows($result) > 0): ?>
                    <?php while($row = mysqli_fetch_assoc($result)): ?>
                        <div class="col">
                            <!-- Product Card UI (Same as index.php) -->
                            <div class="card h-100 border-0 shadow-sm">
                                <img src="images/<?= $row['image']; ?>" class="card-img-top p-2" style="height:150px; object-fit:contain;">
                                <div class="card-body p-2">
                                    <h6 class="text-truncate small"><?= $row['name']; ?></h6>
                                    <p class="fw-bold text-success mb-1">₹<?= $row['price']; ?></p>
                                    <a href="product.php?id=<?= $row['id']; ?>" class="btn btn-sm btn-outline-dark w-100">View</a>
                                </div>
                            </div>
                        </div>
                    <?php endwhile; ?>
                <?php else: ?>
                    <div class="col-12 text-center py-5">
                        <p>No products found matching your criteria.</p>
                    </div>
                <?php endif; ?>
            </div>
        </div>
    </div>
</div>
    </main>
    </div>
    </div> <!-- Footer -->
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

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>