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
                            style="font-size: 10px;">0</span>
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
    <!-- product details starts -->
<div class="container my-5">
    <div class="row g-4 bg-white p-3 rounded shadow-sm">
        
        <!-- Left Side: Image Gallery (Bootstrap Carousel) -->
        <div class="col-md-5">
            <div id="productCarousel" class="carousel slide main-img-container" data-bs-ride="carousel">
                <div class="carousel-inner">
                    <div class="carousel-item active">
                        <img src="images/fruit.jpg" class="d-block w-100" alt="img1">
                    </div>
                    <div class="carousel-item">
                        <img src="images/fruit2.jpg" class="d-block w-100" alt="img2">
                    </div>
                </div>
                <!-- Carousel Controls -->
                <button class="carousel-control-prev" type="button" data-bs-target="#productCarousel" data-bs-slide="prev">
                    <span class="carousel-control-prev-icon bg-dark rounded-circle" aria-hidden="true"></span>
                </button>
                <button class="carousel-control-next" type="button" data-bs-target="#productCarousel" data-bs-slide="next">
                    <span class="carousel-control-next-icon bg-dark rounded-circle" aria-hidden="true"></span>
                </button>
            </div>
            
            <!-- Buy/Cart Buttons -->
            <div class="d-flex gap-2 mt-3">
                <button class="btn btn-outline-dark btn-lg flex-fill fw-bold">Add to Cart</button>
                <button class="btn btn-meesho btn-lg flex-fill fw-bold">Buy Now</button>
            </div>
        </div>

        <!-- Right Side: Product Details -->
        <div class="col-md-7">
            <h4 class="text-secondary fw-normal">Varni Fashion</h4>
            <h1 class="h3 fw-bold">Trendy Graceful Women Kurtis</h1>
            
            <div class="d-flex align-items-center gap-2 my-2">
                <h2 class="fw-bold mb-0">₹350</h2>
                <span class="text-muted text-decoration-line-through">₹700</span>
                <span class="text-success fw-bold">50% Off</span>
            </div>
            <p class="badge bg-success">4.2 ★</p>
            <p class="text-muted small">Free Delivery</p>

            <hr>

            <!-- Size Selector using Bootstrap Button Group -->
            <div class="mb-4">
                <h6 class="fw-bold mb-3">Select Size</h6>
                <div class="btn-group" role="group" aria-label="Size selection">
                    <input type="radio" class="btn-check" name="size" id="s" checked>
                    <label class="btn btn-outline-secondary px-4 py-2" for="s">S</label>

                    <input type="radio" class="btn-check" name="size" id="m">
                    <label class="btn btn-outline-secondary px-4 py-2" for="m">M</label>

                    <input type="radio" class="btn-check" name="size" id="l">
                    <label class="btn btn-outline-secondary px-4 py-2" for="l">L</label>

                    <input type="radio" class="btn-check" name="size" id="xl">
                    <label class="btn btn-outline-secondary px-4 py-2" for="xl">XL</label>
                </div>
            </div>

            <!-- Color Selector -->
            <div class="mb-4">
                <h6 class="fw-bold mb-3">Select Color</h6>
                <div class="d-flex">
                    <div class="color-option" style="background-color: pink; border-color: #f43397;"></div>
                    <div class="color-option" style="background-color: black;"></div>
                    <div class="color-option" style="background-color: blue;"></div>
                </div>
            </div>

            <!-- Product Description -->
            <div class="mt-4">
                <h6 class="fw-bold">Product Details</h6>
                <p class="text-muted small">
                    Name: Trendy Graceful Women Kurtis<br>
                    Fabric: Cotton<br>
                    Sleeve Length: Three-Quarter Sleeves<br>
                    Pattern: Printed
                </p>
            </div>
        </div>

    </div>
</div>

    <!-- product details ended -->


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