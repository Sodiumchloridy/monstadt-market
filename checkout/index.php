<?php 
session_start();
if (!isset($_SESSION['user_id'])) {
    $_SESSION['redirect_after_login'] = $_SERVER['REQUEST_URI'];
    header("Location: ../auth/login.php");
    exit();
}
?>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Checkout</title>
    <link rel="stylesheet" href="https://site-assets.fontawesome.com/releases/v6.6.0/css/all.css" crossorigin="anonymous" referrerpolicy="no-referrer" /> <!-- Fontawesome icons -->
    <link rel="stylesheet" href="checkout.css">

</head>
<body>
    <?php include('../includes/header.php'); ?>

    <div id="checkout-container"></div>
    <div id="checkout-summary"></div>

    <?php include('../includes/footer.php'); ?>

    <?php include('viewCheckoutItem.php'); //Get the data of checkoutItems as object?>

    <script>
        const checkoutItems = <?php echo json_encode($checkoutItems); ?>;
        console.log(checkoutItems);
    </script>

    <script src="viewCheckout.js"></script>
</body>
</html>
