<?php
session_start();
include("admin/db.php");

if (isset($_POST['add_to_wishlist'])) {
    $product_id = $_POST['product_id'];
    $product_title = $_POST['product_name'];
    $user_id = $_SESSION['user_id'] ?? 0;

    if ($user_id == 0) {
        // Agar user login nahi hai toh login page pe bhejo
        header("Location: login.php");
        exit;
    }

    // 1. Pehle check karo ki kya product pehle se wishlist mein hai
    $check_query = "SELECT * FROM wishlist WHERE user_id = '$user_id' AND product_id = '$product_id'";
    $result = mysqli_query($conn, $check_query);

    if (mysqli_num_rows($result) > 0) {
        // 2. Agar pehle se hai, toh DELETE (Remove) kar do
        $delete_query = "DELETE FROM wishlist WHERE user_id = '$user_id' AND product_id = '$product_id'";
        mysqli_query($conn, $delete_query);
    } else {
        // 3. Agar nahi hai, toh INSERT (Add) kar do
        $insert_query = "INSERT INTO wishlist (user_id, product_id,product_title) VALUES ('$user_id', '$product_id','$product_title')";
        mysqli_query($conn, $insert_query);
    }

    // 4. Wapas index.php par bhej do bina koi message dikhaye
    header("Location: index.php");
    exit;
}
?>