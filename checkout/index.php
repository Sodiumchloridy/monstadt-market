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

    <div id="payment-overlay" class="overlay hidden">
        <div class="confirm-box">
            <h2>Confirm Payment</h2>
            <div class="image-container">
                <img src="../default_images/firefly_heart.png" alt="firefly heart">
                <img id="firefly-stab" src="../default_images/firefly_stab.png" class="hidden" alt="firefly stab">
            </div>
            <p>Are you sure you want to proceed to payment?</p>
            <div class="confirm-actions">
                <form id="payment-form" method="post" action="checkout.php">
                    <input type="hidden" name="confirm_payment" value="Confirm Payment">
                    <input type="hidden" name="buyParams" value="<?php echo json_encode($checkoutItems); ?>">
                    <button type="submit" id="confirm-payment">Confirm Payment</button>
                </form>
                <button id="cancel-payment">Cancel</button>
            </div>
        </div>
    </div>

</body>
</html>
