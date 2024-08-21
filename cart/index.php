<?php 
session_start();
?>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Cart</title>
    <link rel="stylesheet" href="https://site-assets.fontawesome.com/releases/v6.6.0/css/all.css" crossorigin="anonymous" referrerpolicy="no-referrer" /> <!-- Fontawesome icons -->
    <link rel="stylesheet" href="../styles/header.css">
    <link rel="stylesheet" href="../styles/footer.css">
    <link rel="stylesheet" href="cart.css">
</head>
<body>
    <?php include("../includes/header.php")?>

    <main class="main">
    <section id="cart-container">
        <h1 class="cart-header">Your Cart</h1>
    </section>
    <section id="checkout-container"></section>
    </main>

    <?php include("view_cart.php")?>
    <?php include("../includes/footer.php")?>
    <script>
        const cartItems = <?php echo json_encode($cartItems); ?>;
        console.log(cartItems);
    </script>
    <script src="viewCart.js"></script>
</body>
</html>
