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
    <link rel="stylesheet" href="../styles/error.css">
    <script src="validateCheckoutForm.js" defer></script>
</head>
<body>
    <?php include('../includes/header.php'); ?>

    <!-- Cart Items For Checkout-->
    <div id="checkout-container"></div>

    <?php include('viewCheckoutItem.php'); //Get the data of checkoutItems as object?>
    <script>
        const checkoutItems = <?php echo json_encode($checkoutItems); ?>;
        console.log(checkoutItems);
    </script>
    <script src="viewCheckout.js"></script>

    <!-- Checkout information-->
    <div id="checkout-summary">
        <h2> Checkout </h2>
        <!--Address selection-->
        <div id="payment-address">
            <h3>Your shipping address: </h3>
            <?php 
                include("../config/config.php");

                $shippingAddressQuery = "SELECT u_address FROM Users WHERE u_id = ?";
                $stmt = mysqli_prepare($conn, $shippingAddressQuery);
                mysqli_stmt_bind_param($stmt, "i", $_SESSION['user_id']);
                if (!mysqli_stmt_execute($stmt)) {
                    throw new Exception("Failed to get shipping address: " . mysqli_stmt_error($stmt));
                }
                mysqli_stmt_bind_result($stmt, $shippingAddress);
                mysqli_stmt_fetch($stmt);
                mysqli_stmt_close($stmt);

                echo '<input type="radio" name="address-choice" id="default-address" value="default-address" checked>'; 
                echo '<label for="default-address"> Default address: ' . $shippingAddress . '</label><br>';

                mysqli_close($conn);
            ?>

            <input type="radio" name="address-choice" id="custom-address" value="custom-address">
            <label for="custom-address">Enter your address: </label>
            <input type="text" id="address-input" name="custom-address" disabled>
            <div class="error" id="address-error"></div>
        
            <a href="../profile/">Not your default address? Change here</a>
        </div>

        <!--Payment method selection-->
        <div id="payment-method">
            <h3>Select payment method: </h3>
            <div id="payment-image">
                <div class="payment-item">
                    <input type="radio" name="payment-method" id="payment-method-amex" value="American Express">
                    <label for="payment-method-amex">
                        <img src="https://support.legacy.worldline-solutions.com/dA/30d9d35ca4/fileAsset/dls-logo-bluebox-solid%20amex.svg" alt="AmericanExpress">
                    </label>
                </div>
                <div class="payment-item">
                    <input type="radio" name="payment-method" id="payment-method-mastercard" value="Mastercard">
                    <label for="payment-method-mastercard">
                    <img src="https://support.legacy.worldline-solutions.com/dA/46bd3a6578/fileAsset/mastercard.svg" alt="Mastercard">
                    </label>
                </div>
                <div class="payment-item">
                    <input type="radio" name="payment-method" id="payment-method-jcb" value="JCB">
                    <label for="payment-method-jcb">
                        <img src="https://support.legacy.worldline-solutions.com/dA/da58d8df3b/fileAsset/jcb.svg" alt="JCB">
                    </label>
                </div>
                <div class="payment-item">
                    <input type="radio" name="payment-method" id="payment-method-visa" value="Visa">
                    <label for="payment-method-visa">
                    <img src="https://support.legacy.worldline-solutions.com/dA/48befa62b1/fileAsset/Visa_Brandmark_Blue_RGB%202.svg" alt="Visa">
                    </label>
                </div>
                <div class="error" id="payment-error"></div>
            </div>
        </div>

        <!--Total Price display-->
        <div id="price-display">
            <h3>Total Price</h3>
            <p id="total-price"></p>
        </div>

        <button id="proceed-payment">Proceed to Payment</button>
    </div>

    <!--Checkout confirmation-->
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
                    <input type="hidden" name="address" value="">
                    <input type="hidden" name="paymentMethod" value="">
                    <input type="hidden" name="buyParams" value="<?php echo htmlspecialchars($_POST['buyParams']); ?>">
                    <button type="submit" id="confirm-payment">Confirm Payment</button>
                </form>
                <button id="cancel-payment">Cancel</button>
            </div>
        </div>
    </div>

    <?php include('../includes/footer.php'); ?>

</body>
</html>
