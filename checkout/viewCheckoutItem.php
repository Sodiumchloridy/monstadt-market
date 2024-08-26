<?php
//Get buyParams value
$buyParams = isset($_POST['buyParams']) ? json_decode($_POST['buyParams'], true) : null;

//Return to home page if buyParams is empty
if (empty($buyParams)){
    echo '<script>
    alert("No items are selected.");
    window.location.href = "../";
    </script>';
    exit();
}

// database connection
include("../config/config.php");

$errors = [];
$checkoutItems = [];

foreach ($buyParams as $item) {
    if (!isset($item['productId']) || !isset($item['quantity'])) {
        echo '<script>
        alert("Error: Product Id or quantiy is not set properly.");
        window.location.href = "../";
        </script>';
        exit();
    }

    $prodId = intval($item['productId']);
    $quantity = intval($item['quantity']);

    // Query to validate the product ID and quantity
    $stmt = mysqli_prepare($conn, "
        SELECT prod_id, prod_name, prod_price, prod_numAvailable, prod_img_name
        FROM product
        WHERE prod_id = ?
    ");
    
    mysqli_stmt_bind_param($stmt, "i", $prodId);
    mysqli_stmt_execute($stmt);
    mysqli_stmt_bind_result($stmt, $dbProdId, $prodName, $prodPrice, $prodMaxAvailable, $prodImgName);
    mysqli_stmt_fetch($stmt);

    if (!$dbProdId) {
        echo '<script>
        alert("Error: Invalid product id is passed.");
        window.location.href = "../";
        </script>';
        exit();
    } 
    
    if ($quantity > $prodMaxAvailable) {
        echo "<script>
        alert('Error: Stock quantity may have changed. $prodName only has $prodMaxAvailable units available');
        window.location.href = '../';
        </script>";
        exit();
    }

    $checkoutItems[] = [
        'prodId' => $dbProdId,
        'prodName' => $prodName,
        'prodPrice' => $prodPrice,
        'prodImgName' => $prodImgName,
        'quantity' => $quantity,
        'totalPrice' => $quantity * $prodPrice
    ];

    mysqli_stmt_close($stmt);
}

mysqli_close($conn);