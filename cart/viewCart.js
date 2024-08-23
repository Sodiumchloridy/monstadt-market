document.addEventListener("DOMContentLoaded", function() {
    const cartContainer = document.getElementById("cart-container");

    if(cartItems.length === 0) {
        cartContainer.innerHTML = "<p>Your cart is empty</p><a href='../'>Add items</a>";
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
            prodName.textContent = `Product: ${item.prodName}`;
            
            const prodPrice = document.createElement("p");
            prodPrice.textContent = `Price: ${item.prodPrice}`;

            const prodQuantity = document.createElement("p");
            prodQuantity.textContent = `Quantity: `;
            prodQuantity.style.display = "inline";
            
            // form elements for add to cart
            const addToCartForm = document.createElement("form");
            addToCartForm.action = "add_to_cart.php";
            addToCartForm.method = "post";
            addToCartForm.style.display = "inline";

            const prodIdInput = document.createElement("input");
            prodIdInput.type = "hidden";
            prodIdInput.name = "product_id";
            prodIdInput.value = item.prodId;
     
            //<input type="text" id="quantity" name="quantity" inputmode="numeric" pattern="[0-9]+" autocomplete="off" value=""></input>
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

            const increaseQttButton = document.createElement("i");
            increaseQttButton.classList.add("fa-regular");
            increaseQttButton.classList.add("fa-plus");
            increaseQttButton.classList.add("increase-quantity");
            increaseQttButton.addEventListener('click', function () {
                updateQuantity(1, quantityInput, item);
                handleFormSubmission(addToCartForm, item, quantityInput);
            });

            const decreaseQttButton = document.createElement("i");
            decreaseQttButton.classList.add("fa-regular");
            decreaseQttButton.classList.add("fa-minus");
            decreaseQttButton.classList.add("decrease-quantity");
            decreaseQttButton.addEventListener('click', function () {
                updateQuantity(-1, quantityInput, item);
                handleFormSubmission(addToCartForm, item, quantityInput);
            });

            addToCartForm.appendChild(prodIdInput);
            addToCartForm.appendChild(decreaseQttButton);
            addToCartForm.appendChild(quantityInput);
            addToCartForm.appendChild(increaseQttButton);
            addToCartForm.addEventListener('submit', (event) => {
                event.preventDefault();
                handleFormSubmission(addToCartForm, item, quantityInput);
            });

            // form elements for delete from cart
            const deleteForm = document.createElement("form");
            deleteForm.action = 'delete_from_cart.php';
            deleteForm.method = 'post';
            //deleteForm.style.display = 'inline';

            const deleteProdIdInput = document.createElement("input");
            deleteProdIdInput.type = 'hidden';
            deleteProdIdInput.name = 'product_id';
            deleteProdIdInput.value = item.prodId;

            const deleteButton = document.createElement("button");
            deleteButton.type = 'submit';
            deleteButton.innerHTML = '<i class="fa-duotone fa-solid fa-trash" style="--fa-primary-color: #ff0000; --fa-secondary-color: #ff0000;"></i>';

            deleteForm.appendChild(deleteProdIdInput);
            deleteForm.appendChild(deleteButton);

            cartDetailsDiv.appendChild(prodName)
            cartDetailsDiv.appendChild(prodPrice);
            cartDetailsDiv.appendChild(prodQuantity);
            cartDetailsDiv.appendChild(addToCartForm);
            cartDetailsDiv.appendChild(deleteForm);

            cartItemDiv.appendChild(checkbox);
            cartItemDiv.appendChild(img);
            cartItemDiv.appendChild(cartDetailsDiv);

            cartContainer.appendChild(cartItemDiv);
        })
    }


    
    //Prevent text input in number field
    function validate_number(quantityInput, item){
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
        const hasError = validate_form_submission(form, quantityInput, item);
        const formData = new FormData(form);

        if (hasError){
            return;
        } else {
            //Send the difference in value
            quantityInput.value = quantityInput.value - item.prodQuantity;
            form.submit();/*
            fetch(form.action, {
                method: 'POST',
                body: formData,
            })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    // Update cart UI or give a success message
                    console.log("Item added to cart successfully:", data.message);
                } else {
                    // Handle any error messages
                    console.error("Error adding item to cart:", data.error);
                }
            })
            .catch(error => console.error('Error:', error));*/
        }
    }

    //Validate number input
    function validate_form_submission(add_cart_form, quantityInput, item){
        add_cart_form.addEventListener('submit', function (event) {
            event.preventDefault();
            let quantity = Number(quantityInput.value);

            //Set quantity to 1 if it is not a number or is 0
            if (isNaN(quantity) || quantity < 1) {
                quantity = 1;
                quantity.value = 1;
                return false;
            }

            //Display error if quantity > Max available
            if (quantityInput > item.prodMaxAvailable) {
                //const errorMessageDiv = document.getElementById('quantity-error');
                //errorMessageDiv.textContent = "Quantity has exceeded the number available.";
                return false;
            }

            return true;
        });
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
            newValue = maxAvailable; //Maximum quantity should not exceed the available stock
        } else {
            //errorMessageDiv.textContent = "";
        }
        //Update the quantity input field
        quantityInput.value = newValue;
    }

})