<?php
// check if user is logged in
if (!isset($_SESSION['user_id'])) {
    header("Location: ../auth/login.php");
    $_SESSION['redirect_after_login'] = $_SERVER['REQUEST_URI'];
    exit();
}

// database connection
include("../config/config.php");

// query to get cart items
$stmt = mysqli_prepare($conn, "
SELECT p.prod_id, p.prod_name, p.prod_price, p.prod_img_name, c.quantity, p.prod_numAvailable
FROM cart c
JOIN product p ON c.prod_id = p.prod_id
WHERE c.u_id = ?
");

mysqli_stmt_bind_param($stmt, "s", $_SESSION['user_id']);
mysqli_stmt_execute($stmt);
mysqli_stmt_bind_result($stmt, $prodId, $prodName, $prodPrice, $prodImgName, $prodQuantity, $prodMaxAvailable);

$cartItems = [];

while (mysqli_stmt_fetch($stmt)) {
    $cartItems[] = [
        'prodId' => $prodId,
        'prodName' => $prodName,
        'prodPrice' => $prodPrice,
        'prodImgName' => $prodImgName,
        'prodQuantity' => $prodQuantity,
        'prodMaxAvailable' => $prodMaxAvailable
    ];
}
mysqli_stmt_close($stmt);
mysqli_close($conn);
