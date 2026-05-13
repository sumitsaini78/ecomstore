<?php
// ... baki ka code (image fetch wagera)

if (isset($_GET['delete'])) {
    $id = (int)$_GET['delete'];

    // 1. Pehle Wishlist se hatayein taaki constraint khatam ho jaye
    mysqli_query($conn, "DELETE FROM wishlist WHERE product_id = $id");

    // 2. Ab Product delete karein
    $delete_query = "DELETE FROM products WHERE id = $id";
    
    if (mysqli_query($conn, $delete_query)) {
        header("Location: manage_products.php?msg=deleted");
        exit;
    }
}
?>