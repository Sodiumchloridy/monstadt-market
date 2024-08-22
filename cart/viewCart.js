document.addEventListener("DOMContentLoaded", function() {
    const cartContainer = document.getElementById("cart-container");

    if(cartItems.length === 0) {
        cartContainer.innerHTML = "<p>Your cart is empty</p><a href='../'>Add items</a>";
    } else {
        cartItems.forEach(item => {
            const cartItemDiv = document.createElement("div");
            cartItemDiv.classList.add("cart-item");

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

            const increaseQttButton = document.createElement("i");
            increaseQttButton.classList.add("fa-regular");
            increaseQttButton.classList.add("fa-minus");
            increaseQttButton.classList.add("increase-quantity");

            //<input type="text" id="quantity" name="quantity" inputmode="numeric" pattern="[0-9]+" autocomplete="off" value=""></input>
            const quantityInput = document.createElement("input");
            quantityInput.type = "text";
            quantityInput.name = "quantity";
            quantityInput.inputMode = "numeric";
            quantityInput.pattern = "[0-9]+";
            quantityInput.autocomplete = "off";
            quantityInput.value = item.prodQuantity;

            const decreaseQttButton = document.createElement("i");
            decreaseQttButton.classList.add("fa-regular");
            decreaseQttButton.classList.add("fa-plus");
            decreaseQttButton.classList.add("decrease-quantity");

            const addButton = document.createElement("button");
            addButton.type = "submit";
            addButton.innerHTML = '<i class="fa-solid fa-cart-plus" style="color: #63E6BE;"></i>';

            addToCartForm.appendChild(prodIdInput);
            addToCartForm.appendChild(increaseQttButton);
            addToCartForm.appendChild(quantityInput);
            addToCartForm.appendChild(decreaseQttButton);
            addToCartForm.appendChild(addButton);

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
})