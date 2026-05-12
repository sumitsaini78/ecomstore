<?php
session_start();
include ('admin/db.php'); // Your database connection file

if (isset($_POST['add_to_wishlist'])) {
    // Check if user is logged in
    if (!isset($_SESSION['user_id'])) {
        header("Location: login.php?msg=Please login first");
        exit();
    }

    $user_id = $_SESSION['user_id'];
    $product_id = $_POST['product_id']; 
    $product_title = $_POST['product_name'];

    // Check if item is already in wishlist to avoid duplicates
    $check = mysqli_query($conn, "SELECT product_id FROM wishlist WHERE user_id = '$user_id' AND product_id = '$product_id'");
    
    if (mysqli_num_rows($check) == 0) {
        // Insert using prepared statement
        $stmt = $conn->prepare("INSERT INTO wishlist (user_id, product_id, product_title) VALUES (?, ?, ?)");
        $stmt->bind_param("iis", $user_id, $product_id, $product_title);
        
        if ($stmt->execute()) {
            echo "<script>alert('favrtd');</script>";
        } else {
            echo "Error adding to wishlist.";
        }
        $stmt->close();
    } else {
        echo "Item already in your wishlist.";
    }
}
?>
