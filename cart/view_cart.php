<?php 

session_start();

// check if user is logged in
if(!isset($_SESSION['user_id'])) {
    header("Location ../auth/login.php");
    exit();
}

// database connection
include("../config/config.php");

// query to get cart items
$stmt = mysqli_prepare($conn, "
SELECT p.prod_name, p.prod_price, c.quantity
FROM cart c
JOIN products p ON c.prod_id = p.prod_id
WHERE c.u_id = ?
");

mysqli_stmt_bind_param($stmt, "s", $_SESSION['user_id']);
mysqli_stmt_execute($stmt);
mysqli_stmt_bind_result($stmt, $prodName, $prodPrice, $prodQuantity);

// fetch the result and display them
while(mysqli_stmt_fetch($stmt)) {
    echo "Product: " .  htmlspecialchars($prodName) . " | Price: " . htmlspecialchars($prodPrice) . " | Quantity: " . htmlspecialchars($prodQuantity);
}

mysqli_stmt_close($stmt);
mysqli_close($conn);
