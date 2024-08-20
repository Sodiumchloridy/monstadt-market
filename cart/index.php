<?php session_start();

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

    <h1>Your cart</h1>
    <section id="cart-container">
        <?php include("view_cart.php")?>
    </section>
    

    <?php include("../includes/footer.php")?>

</body>
</html>
