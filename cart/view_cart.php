<?php 
// check if user is logged in
if(!isset($_SESSION['user_id'])) {
    header("Location: ../auth/login.php");
    exit();
}

// database connection
include("../config/config.php");

// query to get cart items
$stmt = mysqli_prepare($conn, "
SELECT p.prod_id, p.prod_name, p.prod_price, p.prod_img_name, c.quantity
FROM cart c
JOIN product p ON c.prod_id = p.prod_id
WHERE c.u_id = ?
");

mysqli_stmt_bind_param($stmt, "s", $_SESSION['user_id']);
mysqli_stmt_execute($stmt);
mysqli_stmt_bind_result($stmt, $prodId, $prodName, $prodPrice, $prodImgName, $prodQuantity);
mysqli_stmt_store_result($stmt);

// fetch the result and display them
if(mysqli_stmt_num_rows($stmt) === 0) {
    echo "<p>Your cart is empty</p>";
    echo "<a href='../'>Add item to cart</a>";
} else {
    while(mysqli_stmt_fetch($stmt)) {
        echo "<div class='cart-item'>";
        echo "<img src='../images/" . htmlspecialchars($prodImgName) . "'/>";
        echo "<p>Product: " . htmlspecialchars($prodName) . "</p>";
        echo "<p>Price: $" . htmlspecialchars($prodPrice) . "</p>";
        echo "<p>Quantity: " . htmlspecialchars($prodQuantity) . "</p>";
        echo "<form action='add_to_cart.php' method='post' style='display:inline;'>
        <input type='hidden' name='product_id' value='" . htmlspecialchars($prodId) . "' />
        <input type='number' name='quantity' min='1' value='1' />
        <button type='submit'>
        <i class='fa-solid fa-cart-plus' style='color: #63E6BE;'></i>
        </button>
        </form>";
        echo "<form action='delete_from_cart.php' method='post' style='display:inline;'>
                <input type='hidden' name='product_id' value='" . htmlspecialchars($prodId) . "' />
                <button type='submit'>
                <i class='fa-duotone fa-solid fa-trash' style='--fa-primary-color: #ff0000; --fa-secondary-color: #ff0000;'></i>
                </button>
              </form>";
        echo "</div><br>";
    }
}


mysqli_stmt_close($stmt);
mysqli_close($conn);
?>

