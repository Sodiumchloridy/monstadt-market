<?php

session_start();

//Check if user is logged in
if(!isset($_SESSION['user_id'])) {
    header("Location: ../auth/login.php");
    exit();
}

if(!isset($_POST['product_id']) || !isset($_POST['quantity'])) {
    header("Location: ../");
    exit();
}

//Get product id and quantity from post request
$productId = $_POST['product_id'];
$quantity = intval($_POST['quantity']);

//Validate product id and quantity
if($quantity == 0) {
    echo "Invalid product id or quantity";
    exit();
}

//Database connection
include("../config/config.php");

//Server side validation for total quantity
//Get quantity of products available
$stmt = mysqli_prepare($conn, "SELECT prod_numAvailable FROM Product WHERE prod_id = ?");
mysqli_stmt_bind_param($stmt, "s", $productId);
mysqli_stmt_execute($stmt);
mysqli_stmt_bind_result($stmt, $availableQuantity);
mysqli_stmt_fetch($stmt);
mysqli_stmt_close($stmt);

//Check if the product already exists in the cart and fetch the current cart quantity
$stmt = mysqli_prepare($conn, "SELECT quantity FROM cart WHERE prod_id = ? AND u_id = ?");
mysqli_stmt_bind_param($stmt, "ss", $productId, $_SESSION['user_id']);
mysqli_stmt_execute($stmt);
mysqli_stmt_bind_result($stmt, $currentCartQuantity);
$productInCart = mysqli_stmt_fetch($stmt); 
mysqli_stmt_close($stmt);

//Calculate total quantity
$totalQuantity = $productInCart ? $currentCartQuantity + $quantity : $quantity;

// Ensure the new cart quantity is within valid limits
if ($totalQuantity < 0) {
    echo "<script>
        alert('You cannot have a negative quantity in your cart.');
        window.history.back();
    </script>";
    exit();
}

//Check if total quantity is more than available products
if ($totalQuantity > $availableQuantity) {
    echo "<script>
        alert('Total quantity exceeded. Only $availableQuantity units are available.');
        window.history.back();
    </script>";
    exit();
}

//If product is not in the cart, insert a new entry
//If products already exists in cart, update the quantity
$stmt = mysqli_prepare($conn, "
    INSERT INTO cart (u_id, prod_id, quantity)
    VALUES (?, ?, ?)
    ON DUPLICATE KEY UPDATE quantity = quantity + ?
");

mysqli_stmt_bind_param($stmt, "ssii", $_SESSION['user_id'], $productId, $quantity, $quantity);

//Execute result
if(mysqli_stmt_execute($stmt)) {
    $message = "Product added to cart successfully";
    echo "<script>alert('$message')</script>";
    header("Location: index.php");
    exit();
} else {
    echo "Error: " . mysqli_error($conn);
}

mysqli_stmt_close($stmt);

mysqli_close($conn);

