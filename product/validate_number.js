document.addEventListener('DOMContentLoaded', function () {
    const maxAvailable = Number(document.getElementById('maxAvailable').value);
    const quantityInputField = document.getElementById('quantity');
    const errorMessageDiv = document.getElementById('quantity-error');
    const increaseQuantityButton = document.getElementById('increase-quantity');
    const decreaseQuantityButton = document.getElementById('decrease-quantity');

    //Prevent text input in number field
    quantityInputField.addEventListener("input", function () {
        let currentValue = Number(quantityInputField.value);

        //Clear any error message
        errorMessageDiv.textContent = "";

        //Validate input against the pattern
        if (!quantityInputField.validity.valid) {
            //Replace invalid character with empty character
            quantityInputField.value = quantityInputField.value.replace(/[^0-9]/g, '');
        } else if (currentValue > maxAvailable) {
            //If the value exceeds the maximum available, set it to maxAvailable
            quantityInputField.value = maxAvailable;
        }
    });

    //Validate number input
    const cart_form = document.getElementById("add-to-cart-form");
    cart_form.addEventListener('submit', function (event) {
        event.preventDefault();

        let quantityInput = Number(quantityInputField.value);

        //Set quantity to 1 if it is not a number or is 0
        if (isNaN(quantityInput) || quantityInput < 1) {
            quantityInput = 1;
            quantityInputField.value = 1;
        }

        //Display error if quantity > Max available
        if (quantityInput > maxAvailable) {
            const errorMessageDiv = document.getElementById('quantity-error');
            errorMessageDiv.textContent = "Quantity has exceeded the number available.";
            return;
        }

        errorMessageDiv.textContent = "";

        //Submit form if no error
        cart_form.submit();
    });

    //Increase and decrease function for button
    function updateQuantity(change) {
        let currentValue = Number(quantityInputField.value);

        //Apply the change (increase or decrease)
        let newValue = currentValue + change;

        //Ensure the new value is within valid bounds
        if (newValue < 1) {
            newValue = 1; //Minimum quantity is 1
        } else if (newValue > maxAvailable) {
            newValue = maxAvailable; //Maximum quantity should not exceed the available stock
        } else {
            errorMessageDiv.textContent = "";
        }

        //Update the quantity input field
        quantityInputField.value = newValue;
    }

    //Add event listeners to the plus and minus icons
    increaseQuantityButton.addEventListener('click', function () {
        updateQuantity(1);
    });
    decreaseQuantityButton.addEventListener('click', function () {
        updateQuantity(-1);
    });
});
