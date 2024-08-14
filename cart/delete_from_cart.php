<?php

session_start();

if(!isset($_SESSION['user_id'])) {
    header("Location: ../auth/login.php");
    exit();
}

// get product id from post request
$productId = $_POST['product_id'];

// database connection
include("../config/config.php");

$stmt = mysqli_prepare($conn, "DELETE FROM cart WHERE u_id=? AND prod_id=?");
mysqli_stmt_bind_param($stmt, "ss", $_SESSION['user_id'], $productId);

if(mysqli_stmt_execute($stmt)) {
    $message = "Product removed successfully";
    echo "<script>alert('$message')</script>";
    header("Location: view_cart.php");
} else {
    echo "Error: " . mysqli_error($conn);
}

mysqli_stmt_close($stmt);
mysqli_close($conn);