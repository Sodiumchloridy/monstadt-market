document.addEventListener("DOMContentLoaded", function () {
    const cartContainer = document.getElementById("cart-container");

    if (cartItems.length === 0) {
        cartContainer.innerHTML = "<p align='center'>Your cart is currently empty. <a href='../'>Add items</a></p>";
    } else {
        cartItems.forEach(item => {
            const cartItemDiv = document.createElement("div");
            cartItemDiv.classList.add("cart-item");
            cartItemDiv.dataset.id = item.prodId;

            const cartDetailsDiv = document.createElement("div");
            cartDetailsDiv.classList.add("product-details");

            const checkbox = document.createElement("input");
            checkbox.type = "checkbox";
            checkbox.name = "prod_selected";

            const img = document.createElement("img");
            img.src = `../images/${item.prodImgName}`;
            img.alt = item.prodName;

            const prodName = document.createElement("p");
            prodName.textContent = `${item.prodName}`;

            const prodPrice = document.createElement("p");
            prodPrice.textContent = `$${item.prodPrice}`;

            // form for add to cart
            const addToCartForm = document.createElement("form");
            addToCartForm.action = "add_to_cart.php";
            addToCartForm.method = "post";
            addToCartForm.style.display = "inline";

            //hidden input for storing product id
            const prodIdInput = document.createElement("input");
            prodIdInput.type = "hidden";
            prodIdInput.name = "product_id";
            prodIdInput.value = item.prodId;

            //Div for quantity container
            const qtyContainer = document.createElement("div");
            qtyContainer.classList.add("qty-container");

            //Quantity input field
            const quantityInput = document.createElement("input");
            quantityInput.type = "text";
            quantityInput.name = "quantity";
            quantityInput.inputMode = "numeric";
            quantityInput.pattern = "[0-9]+";
            quantityInput.autocomplete = "off";
            quantityInput.value = item.prodQuantity;
            quantityInput.addEventListener("input", () => validate_number(quantityInput, item));
            quantityInput.addEventListener("change", function () {
                handleFormSubmission(addToCartForm, item, quantityInput);
            });

            //Create the increase quantity button
            const increaseQttButton = document.createElement("button");
            increaseQttButton.classList.add("quantity-button", "increase-quantity");
            increaseQttButton.setAttribute("aria-label", "Increase quantity");

            //Create and append the icon element
            const increaseIcon = document.createElement("i");
            increaseIcon.classList.add("fa-regular", "fa-plus");
            increaseQttButton.appendChild(increaseIcon);
            increaseQttButton.addEventListener('click', function (event) {
                event.preventDefault();
                updateQuantity(1, quantityInput, item);
                handleFormSubmission(addToCartForm, item, quantityInput);
            });

            //Create the decrease quantity button
            const decreaseQttButton = document.createElement("button");
            decreaseQttButton.classList.add("quantity-button", "decrease-quantity");
            decreaseQttButton.setAttribute("aria-label", "Decrease quantity");

            //Create and append the icon element
            const decreaseIcon = document.createElement("i");
            decreaseIcon.classList.add("fa-regular", "fa-minus");
            decreaseQttButton.appendChild(decreaseIcon);
            decreaseQttButton.addEventListener('click', function (event) {
                event.preventDefault();
                updateQuantity(-1, quantityInput, item);
                handleFormSubmission(addToCartForm, item, quantityInput);
            });

            qtyContainer.appendChild(decreaseQttButton);
            qtyContainer.appendChild(quantityInput);
            qtyContainer.appendChild(increaseQttButton);

            addToCartForm.appendChild(prodIdInput);
            addToCartForm.appendChild(qtyContainer);
            addToCartForm.addEventListener('submit', (event) => {
                event.preventDefault();
                handleFormSubmission(addToCartForm, item, quantityInput);
            });

            // form elements for delete from cart
            const deleteForm = document.createElement("form");
            deleteForm.action = 'delete_from_cart.php';
            deleteForm.method = 'post';

            const deleteProdIdInput = document.createElement("input");
            deleteProdIdInput.type = 'hidden';
            deleteProdIdInput.name = 'product_id';
            deleteProdIdInput.value = item.prodId;

            const deleteButton = document.createElement("button");
            deleteButton.type = 'submit';
            deleteButton.classList.add('delete-button');
            deleteButton.innerHTML = '<i class="fa-duotone fa-solid fa-trash"></i>';

            deleteForm.appendChild(deleteProdIdInput);
            deleteForm.appendChild(deleteButton);

            cartDetailsDiv.appendChild(prodName)
            cartDetailsDiv.appendChild(prodPrice);
            cartDetailsDiv.appendChild(addToCartForm);
            cartDetailsDiv.appendChild(deleteForm);

            cartItemDiv.appendChild(checkbox);
            cartItemDiv.appendChild(img);
            cartItemDiv.appendChild(cartDetailsDiv);

            cartContainer.appendChild(cartItemDiv);
        })
    }



    //Prevent text input in number field
    function validate_number(quantityInput, item) {
        const maxAvailable = item.prodMaxAvailable;
        let currentValue = Number(quantityInput.value);

        //Validate input against the pattern
        if (!quantityInput.validity.valid) {
            //Replace invalid character with empty character
            quantityInput.value = quantityInput.value.replace(/[^0-9]/g, '');
        } else if (currentValue > maxAvailable) {
            //If the value exceeds the maximum available, set it to maxAvailable
            quantityInput.value = maxAvailable;
        } else if (currentValue === 0) {
            quantityInput.value = 1;
        }
    };

    function handleFormSubmission(form, item, quantityInput) {
        if (validate_form_submission(quantityInput, item)) {
            const difference = quantityInput.value - item.prodQuantity;
            if (difference !== 0) {
                quantityInput.value = quantityInput.value - item.prodQuantity;
                form.submit();
            }
        }
    }

    //Validate number input
    function validate_form_submission(quantityInput, item) {
        let quantity = Number(quantityInput.value);

        //Set quantity to 1 if it is not a number or is 0
        if (isNaN(quantity) || quantity < 1) {
            quantity = 1;
            quantity.value = 1;
            return false;
        }

        //Display error if quantity > Max available
        if (quantityInput > item.prodMaxAvailable) {
            quantityInput.value = item.prodMaxAvailable;
            return false;
        }
        return true;
    }

    //Increase and decrease function for button
    function updateQuantity(change, quantityInput, item) {
        let currentValue = Number(quantityInput.value);

        //Apply the change (increase or decrease)
        let newValue = currentValue + change;

        //Ensure the new value is within valid bounds
        if (newValue < 1) {
            newValue = 1; //Minimum quantity is 1
        } else if (newValue > item.prodMaxAvailable) {
            newValue = item.prodMaxAvailable; //Maximum quantity should not exceed the available stock
        } else {
            quantityInput.value = newValue;
        }
    }

})
