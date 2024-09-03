<?php
session_start();
if (!isset($_SESSION['user_id'])) {
    $_SESSION['redirect_after_login'] = $_SERVER['REQUEST_URI'];
    header("Location: ../auth/login.php");
    exit();
}

$item = $_GET['id'] ?? null;
$item or die('<h1 align="center">Please select an item.</h1>');

// Fetch content
include('../config/config.php');
$stmt = mysqli_prepare($conn, "SELECT * FROM `product` WHERE `prod_id` = ?");
mysqli_stmt_bind_param($stmt, "s", $item);
mysqli_stmt_execute($stmt);
$result = mysqli_stmt_get_result($stmt);
?>


<!DOCTYPE html>
<html>

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title> Mondstadt Market </title>
    <link rel="stylesheet" href="https://site-assets.fontawesome.com/releases/v6.6.0/css/all.css" crossorigin="anonymous" referrerpolicy="no-referrer" /> <!-- Fontawesome icons -->
    <link rel="stylesheet" href="../styles/product.css">
    <link rel="stylesheet" href="../styles/styles.css">
    <link rel="stylesheet" href="../styles/color.css">
    <script defer src="validate_number.js"></script>
</head>

<body>
    <?php
    // Header
    include('../includes/header.php');
    if (mysqli_num_rows($result) > 0) {
        echo '<div class="product-container">';

        $row = mysqli_fetch_assoc($result);
        $prod_name = htmlspecialchars($row["prod_name"]);
        echo "<section class='product-col-image'>";
        echo "<img src='../images/" . $row['prod_img_name'] . "' alt='" . $row['prod_name'] . "'>";
        echo "<h1 align='center' data-content='$prod_name'>" . $row['prod_name'] . "</h1>";
        echo "</section>";

        echo "<section class='product-col-details'>";
        echo "<h1 data-content='$prod_name'>" . $row['prod_name'] . "</h1>";
        echo "<p align='justify'>" . $row['prod_desc'] . "</p>";
        echo "<div class='details-grid'>";
        echo "<p>Price: " . $row['prod_price'] . "</p>";
        echo "<p>Region: " . $row['prod_region'] . "</p>";
        echo "<p>Available: " . $row['prod_numAvailable'] . "</p>";
        echo "<p>Sold: " . $row['prod_numSold'] . "</p>";
        echo "</div>";
    ?>
        <!-- action="../monstadt-market/cart/add_to_cart.php" -->
        <form id="add-to-cart-form" action="../cart/add_to_cart.php" method="post">
            <!--Quantity -->
            <span class="qty-container">
                <label for="quantity">Quantity</label>

                <button type="button" class="quantity-button" id="decrease-quantity" aria-label="Decrease quantity">
                    <i class="fa-regular fa-minus"></i>
                </button>

                <input type="text" id="quantity" name="quantity" inputmode="numeric" pattern="[0-9]+" autocomplete="off" value="1">

                <button type="button" class="quantity-button" id="increase-quantity" aria-label="Increase quantity">
                    <i class="fa-regular fa-plus"></i>
                </button>
            </span>
            <div class="error" id="quantity-error"></div>

            <!-- Product id -->
            <input type="hidden" name="product_id" value="<?php echo htmlspecialchars($row['prod_id']) ?>">
            <!-- Max Available -->
            <input type="hidden" id="maxAvailable" value="<?php echo $row['prod_numAvailable']; ?>">

            <input type="submit" value="Add to cart">
        </form>

    <?php

        echo "</section>";
        echo '</div>';
    }

    //Footer
    include('../includes/footer.php');
    ?>
</body>

</html>
