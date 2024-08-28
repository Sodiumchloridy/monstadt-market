<?php
session_start();

// Ensure the user is logged in
if (!isset($_SESSION['user_id'])) {
    header("Location: ../auth/login.php");
    exit();
}

// Retrieve user ID
$user_id = $_SESSION['user_id'];

include('viewCheckoutItem.php');

include("../config/config.php");

// Begin transaction
mysqli_begin_transaction($conn);

try {
    // Insert order into Orders table
    $shippingAddressQuery = "SELECT u_address FROM Users WHERE u_id = ?";
    $stmt = mysqli_prepare($conn, $shippingAddressQuery);
    mysqli_stmt_bind_param($stmt, "i", $user_id);
    mysqli_stmt_execute($stmt);
    mysqli_stmt_bind_result($stmt, $shippingAddress);
    mysqli_stmt_fetch($stmt);
    mysqli_stmt_close($stmt);

    $totalAmount = array_sum(array_column($checkoutItems, 'totalPrice'));

    $insertOrderQuery = "
        INSERT INTO Orders (u_id, total_amount, shipping_address, payment_method)
        VALUES (?, ?, ?, 'Credit Card')";
    $stmt = mysqli_prepare($conn, $insertOrderQuery);
    mysqli_stmt_bind_param($stmt, "ids", $user_id, $totalAmount, $shippingAddress);
    mysqli_stmt_execute($stmt);
    $orderId = mysqli_insert_id($conn); // Get the inserted order ID
    mysqli_stmt_close($stmt);

    // Insert items into OrderItems table and update Product table
    foreach ($checkoutItems as $item) {
        $prodId = $item['prodId'];
        $quantity = $item['quantity'];
        $priceAtPurchase = $item['prodPrice'];

        // Insert into OrderItems
        $insertOrderItemsQuery = "
            INSERT INTO OrderItems (order_id, prod_id, quantity, price_at_purchase)
            VALUES (?, ?, ?, ?)";
        $stmt = mysqli_prepare($conn, $insertOrderItemsQuery);
        mysqli_stmt_bind_param($stmt, "iiid", $orderId, $prodId, $quantity, $priceAtPurchase);
        mysqli_stmt_execute($stmt);
        mysqli_stmt_close($stmt);

        // Update Product table
        $updateProductQuery = "
            UPDATE Product
            SET prod_numSold = prod_numSold + ?, prod_numAvailable = prod_numAvailable - ?
            WHERE prod_id = ?";
        $stmt = mysqli_prepare($conn, $updateProductQuery);
        mysqli_stmt_bind_param($stmt, "iii", $quantity, $quantity, $prodId);
        mysqli_stmt_execute($stmt);
        mysqli_stmt_close($stmt);
    }

    // Remove items from Cart
    foreach ($checkoutItems as $item) {
        $prodId = $item['prodId'];

        $deleteCartItemQuery = "
            DELETE FROM Cart WHERE u_id = ? AND prod_id = ?";
        $stmt = mysqli_prepare($conn, $deleteCartItemQuery);
        mysqli_stmt_bind_param($stmt, "ii", $userId, $prodId);
        mysqli_stmt_execute($stmt);
        mysqli_stmt_close($stmt);
    }

    // Commit transaction
    mysqli_commit($conn);

    echo '<script>
    alert("Payment successful! Thank you for your purchase.");
    window.location.href = "../";
    </script>';

} catch (Exception $e) {
    mysqli_rollback($conn);
    echo '<script>
    alert("An error occurred during the checkout process. Please try again.");
    window.location.href = "../";
    </script>';
}

// Close connection
mysqli_close($conn);
?>

<html>
    <head>
        <title>Checkout</title>
    </head>
    <body>
        <h1> Checkout </h1>
    </body>
</html>
