<?php 
session_start();
if (!isset($_SESSION['user_id'])) {
    header("Location: ../auth/login.php");
    exit();
}
?>

<!DOCTYPE html>
<html>

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title> Mondstadt Market </title>
    <base href="../">
    <link rel="stylesheet" href="https://site-assets.fontawesome.com/releases/v6.6.0/css/all.css" crossorigin="anonymous" referrerpolicy="no-referrer" /> <!-- Fontawesome icons -->
    <link rel="stylesheet" href="styles/styles.css">
    <link rel="stylesheet" href="styles/header.css">
    <link rel="stylesheet" href="styles/footer.css">
    <link rel="stylesheet" href="styles/product.css">
</head>

<body>
    <?php
    $item = $_GET['id'] ?? null;

    // Header
    include('../includes/header.php');

    $item or die('<h1 align="center">Please select an item.</h1>');

    // Fetch content
    include('../config/config.php');
    $stmt = mysqli_prepare($conn, "SELECT * FROM `product` WHERE `prod_id` = ?");
    mysqli_stmt_bind_param($stmt, "s", $item);
    mysqli_stmt_execute($stmt);
    $result = mysqli_stmt_get_result($stmt);


    if (mysqli_num_rows($result) > 0) {
        echo '<div class="product-container">';
            echo '<div class="product-card">';

            $row = mysqli_fetch_assoc($result);
            echo "<section class='product-col-image'>";
                echo "<img src='images/" . $row['prod_img_name'] . "' alt='" . $row['prod_name'] . "'>";
            echo "</section>";

            echo "<section class='product-col-details'>";
                echo "<h1 align='center'>" . $row['prod_name'] . "</h1>";
                echo "<p align='center'>Description: " . $row['prod_desc'] . "</p>";
                echo "<p align='center'>Price: " . $row['prod_price'] . "</p>";
                echo "<p align='center'>Region: " . $row['prod_region'] . "</p>";
                echo "<p align='center'>Available: " . $row['prod_numAvailable'] . "</p>";
                echo "<p align='center'>Sold: " . $row['prod_numSold'] . "</p>";
            ?>
            <!-- action="../monstadt-market/cart/add_to_cart.php" -->
            <form id="add-to-cart-form" action="../monstadt-market/cart/add_to_cart.php" method="post">
                <!--Quantity -->
                <label for="quantity">Quantity: </label>
                <i class="fa-regular fa-minus" id="decrease-quantity"></i> 
                <input type="text" id="quantity" name="quantity" inputmode="numeric" pattern="[0-9]+" autocomplete="off" value="1">
                <i class="fa-regular fa-plus" id="increase-quantity"></i>
                <div class="error" id="quantity-error"></div>

                <!-- Product id -->
                <input type="hidden" name="product_id" value="<?php echo htmlspecialchars($row['prod_id'])?>">
                <!-- Max Available -->
                <input type="hidden" id="maxAvailable" value="<?php echo $row['prod_numAvailable']; ?>">

                <input type="submit" value="Add to cart">
            </form>

            <?php
            echo "</section>";

            echo '</div>';
        echo '</div>';
    }

    //Footer
    include('../includes/footer.php');
    ?>
    <script src="product/validate_number.js"></script>
</body>

</html>
