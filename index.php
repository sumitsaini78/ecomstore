<?php
// Database connection
$conn = new mysqli("localhost", "root", "", "categories");

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Fetch all categories
$query = "SELECT * FROM categories ORDER BY id DESC";
$result = $conn->query($query);
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
            <a class="navbar-brand fs-1 fw-bold" style="color:#570d48;" href="#">Shodio</a>

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
                    <a href="#" class="text-dark position-relative">
                        <i class="fa-solid fa-cart-shopping"></i>
                        <span class="position-absolute top-0 start-100 translate-middle badge rounded-pill bg-danger"
                            style="font-size: 10px;">0</span>
                    </a>
                </div>
            </div>
        </div>
    </nav>
    <!-- Navbar ended -->

    <!-- offer banner Section start -->
    <div class="container my-3">
        <div class="row justify-content-center">
            <!-- Laptop par width 75% (col-lg-9), Mobile par 100% -->
            <div class="col-12 col-lg-9">

                <div id="ecomHeroCarousel" class="carousel slide shadow-sm rounded-3 overflow-hidden"
                    data-bs-ride="carousel">
                    <div class="carousel-inner">

                        <div class="carousel-item active">
                            <!-- Yahan 'banner-img' class use ki hai jo CSS se control ho rahi hai -->
                            <img src="images/offer.jpg" class="d-block w-100 banner-img" alt="Offer 1">
                        </div>

                        <div class="carousel-item">
                            <img src="images/offer2.jpg" class="d-block w-100 banner-img" alt="Offer 2">
                        </div>

                    </div>

                </div>
            </div>
        </div>
    </div>
    <!-- offer banner Section ended -->

    <!-- Quick Category Menu starts -->
     <!-- Quick Category Menu starts -->
<div class="container-fluid bg-white py-3 shadow-sm border-bottom">
    <div class="d-flex flex-nowrap overflow-x-auto gap-4 px-2 text-center no-scrollbar">

        <?php
        if ($result->num_rows > 0) {
            while($row = $result->fetch_assoc()) {
                ?>
                <a href="category.php?id=<?php echo $row['id']; ?>" class="text-decoration-none text-dark flex-shrink-0" style="width: 80px;">
                    <!-- Using a placeholder image since we only stored names in the table -->
                    <img src="https://placehold.co/100x100?text=<?php echo $row['category_name']; ?>" 
                         class="rounded-circle border p-1"
                         style="width: 70px; height: 70px; object-fit: cover;">
                    <p class="small mt-2 mb-0 fw-medium"><?php echo $row['category_name']; ?></p>
                </a>
                <?php
            }
        } else {
            echo "<p class='text-muted small'>No categories found.</p>";
        }
        ?>

    </div>
</div>
<!-- Quick Category Menu ended -->
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
    <!-- product cards starts -->
    <div class="container my-5">
        <div class="d-flex justify-content-between align-items-end mb-4">
            <div>
                <h2 class="fw-bold mb-0" style="color: var(--brand-color);">Featured Products</h2>
                <p class="text-muted mb-0">Handpicked for you</p>
            </div>
            <a href="#" class="btn btn-sm btn-outline-secondary">View All</a>
        </div>

        <div class="row row-cols-2  row-cols-md-3 row-cols-lg-4 g-2">
            <!-- Product Item 1 -->
            <div class="col     ">
                <div class="card h-100 border-0 shadow-sm product-card">
                    <img src="images/fruit.jpg" class="card-img-top p-2 rounded-4" alt="Product">
                    <div class="card-body">
                        <h5 class="card-title fs-6">Designer Festive Saree</h5>
                        <p class="card-text fw-bold text-success">₹1,499</p>
                        <div class="d-flex gap-1">
                            <a href="#" class="btn btn-sm btn-outline-success w-50">Add to Cart</a>
                            <button type="button" class="btn btn-sm btn-outline-danger w-50"><i
                                    class="fa-regular fa-heart"></i></button>
                        </div>
                    </div>
                </div>
            </div>
            <!-- Product Item 2 -->
            <div class="col">
                <div class="card h-100 border-0 shadow-sm product-card">
                    <img src="images/fruit1.jpg" class="card-img-top p-2 rounded-4" alt="Product">
                    <div class="card-body">
                        <h5 class="card-title fs-6">Designer Festive Saree</h5>
                        <p class="card-text fw-bold text-success">₹1,499</p>
                        <div class="d-flex gap-1">
                            <a href="#" class="btn btn-sm btn-outline-success w-50">Add to Cart</a>
                            <button type="button" class="btn btn-sm btn-outline-danger w-50"><i
                                    class="fa-regular fa-heart"></i></button>
                        </div>
                    </div>
                </div>
            </div>
            <!-- Product Item 3 -->
            <div class="col">
                <div class="card h-100 border-0 shadow-sm product-card">
                    <img src="images/fruit.jpg" class="card-img-top p-2 rounded-4" alt="Product">
                    <div class="card-body">
                        <h5 class="card-title fs-6">Designer Festive Saree</h5>
                        <p class="card-text fw-bold text-success">₹1,499</p>
                        <div class="d-flex gap-1">
                            <a href="#" class="btn btn-sm btn-outline-success w-50">Add to Cart</a>
                            <button type="button" class="btn btn-sm btn-outline-danger w-50"><i
                                    class="fa-regular fa-heart"></i></button>
                        </div>
                    </div>
                </div>
            </div>
            <!-- Product Item 4 -->
            <div class="col">
                <div class="card h-100 border-0 shadow-sm product-card">
                    <img src="images/fruit3.jpg" class="card-img-top p-2 rounded-4" alt="Product">
                    <div class="card-body">
                        <h5 class="card-title fs-6">Designer Festive Saree</h5>
                        <p class="card-text fw-bold text-success">₹1,499</p>
                        <div class="d-flex gap-1">
                            <a href="#" class="btn btn-sm btn-outline-success w-50">Add to Cart</a>
                            <button type="button" class="btn btn-sm btn-outline-danger w-50"><i
                                    class="fa-regular fa-heart"></i></button>
                        </div>
                    </div>
                </div>
            </div>
            <!-- Product Item 5 -->
            <div class="col">
                <div class="card h-100 border-0 shadow-sm product-card">
                    <img src="images/fruit4.jpg" class="card-img-top p-2 rounded-4" alt="Product">
                    <div class="card-body">
                        <h5 class="card-title fs-6">Designer Festive Saree</h5>
                        <p class="card-text fw-bold text-success">₹1,499</p>
                        <div class="d-flex gap-1">
                            <a href="#" class="btn btn-sm btn-outline-success w-50">Add to Cart</a>
                            <button type="button" class="btn btn-sm btn-outline-danger w-50"><i
                                    class="fa-regular fa-heart"></i></button>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Product Item 6 -->
            <div class="col">
                <div class="card h-100 border-0 shadow-sm product-card">
                    <img src="images/fruit3.jpg" class="card-img-top p-2 rounded-4" alt="Product">
                    <div class="card-body">
                        <h5 class="card-title fs-6">Designer Festive Saree</h5>
                        <p class="card-text fw-bold text-success">₹1,499</p>
                        <div class="d-flex gap-1">
                            <a href="#" class="btn btn-sm btn-outline-success w-50">Add to Cart</a>
                            <button type="button" class="btn btn-sm btn-outline-danger w-50"><i
                                    class="fa-regular fa-heart"></i></button>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Product Item 8 -->
            <div class="col">
                <div class="card h-100 border-0 shadow-sm product-card">
                    <img src="images/fruit3.jpg" class="card-img-top p-2 rounded-4" alt="Product">
                    <div class="card-body">
                        <h5 class="card-title fs-6">Designer Festive Saree</h5>
                        <p class="card-text fw-bold text-success">₹1,499</p>
                        <div class="d-flex gap-1">
                            <a href="#" class="btn btn-sm btn-outline-success w-50">Add to Cart</a>
                            <button type="button" class="btn btn-sm btn-outline-danger w-50"><i
                                    class="fa-regular fa-heart"></i></button>
                        </div>
                    </div>
                </div>
            </div>

        </div>
    </div>
    <!-- product cards ended -->


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