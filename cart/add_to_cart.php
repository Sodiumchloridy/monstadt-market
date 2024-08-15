<?php

session_start();

//Check if user is logged in
if(!isset($_SESSION['user_id'])) {
    header("Location: ../auth/login.php");
    exit();
}

//Get product id and quantity from post request
$productId = $_POST['product_id'];
$quantity = intval($_POST['quantity']);

//Validate product id and quantity
if($quantity <= 0 || empty($productId)) {
    echo "Invalid product id or quantity";
    exit();
}

//Database connection
include("../config/config.php");

//Check if the product already exist in the cart
$stmt = mysqli_prepare($conn, "SELECT quantity FROM cart WHERE prod_id=? AND u_id=?");
mysqli_stmt_bind_param($stmt, "ss", $productId, $_SESSION['user_id']);
mysqli_stmt_execute($stmt);
mysqli_stmt_store_result($stmt);

//If products already exists in cart, update the quantity
if(mysqli_stmt_num_rows($stmt) > 0) {
    mysqli_stmt_close($stmt);
    $stmt = mysqli_prepare($conn, "UPDATE cart SET quantity= quantity + ? WHERE u_id=? AND prod_id=?");
    mysqli_stmt_bind_param($stmt, "iss", $quantity, $_SESSION['user_id'], $productId);   
} else {
    //If product is not in the cart, insert a new entry
    mysqli_stmt_close($stmt);
    $stmt = mysqli_prepare($conn, "INSERT INTO cart (u_id, prod_id, quantity) VALUES (?, ?, ?)");
    mysqli_stmt_bind_param($stmt, "ssi", $_SESSION['user_id'], $productId, $quantity);
}

//Execute result
if(mysqli_stmt_execute($stmt)) {
    $message = "Product added to cart successfully";
    echo "<script>alert('$message')</script>";
    header("Location: view_cart.php");
    exit();
} else {
    echo "Error: " . mysqli_error($stmt);
}

mysqli_stmt_close($stmt);
mysqli_close($conn);

