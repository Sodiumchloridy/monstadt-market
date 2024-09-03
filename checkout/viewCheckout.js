document.addEventListener("DOMContentLoaded", function () {
    const checkoutContainer = document.getElementById("checkout-container");
    const checkoutSummary = document.getElementById("checkout-summary");

    const overlay = document.getElementById("payment-overlay");
    const confirmButton = document.getElementById("confirm-payment");
    const cancelButton = document.getElementById("cancel-payment");

    const fireflyStab = document.querySelector('#payment-overlay .confirm-box #firefly-stab');

    if (checkoutItems.length === 0) {
        checkoutContainer.innerHTML = "<p>No items are selected for checkout. <a href='../cart/'>Go to cart</a></p>";
        checkoutSummary.innerHTML = "";
    } else {
        let totalAmount = 0;

        const heading = document.createElement("h2");
        heading.textContent = "Cart Items";
        checkoutContainer.appendChild(heading);

        checkoutItems.forEach(item => {
            totalAmount += Number(item.totalPrice);

            const itemDiv = document.createElement("div");
            itemDiv.classList.add("checkout-item");

            const imgDiv = document.createElement("div");
            imgDiv.classList.add("checkout-item-img");
            const img = document.createElement("img");
            img.src = `../images/${item.prodImgName}`;
            img.alt = item.prodName;
            imgDiv.appendChild(img);

            const detailsDiv = document.createElement("div");
            detailsDiv.classList.add("checkout-item-details");
            const name = document.createElement("h3");
            name.textContent = item.prodName;
            const price = document.createElement("p");
            price.textContent = `Price: RM ${Number(item.prodPrice).toFixed(2)}`;
            const quantity = document.createElement("p");
            quantity.textContent = `Quantity: ${item.quantity}`;
            const totalPrice = document.createElement("p");
            totalPrice.textContent = `Total: RM ${Number(item.totalPrice).toFixed(2)}`;

            detailsDiv.appendChild(name);
            detailsDiv.appendChild(price);
            detailsDiv.appendChild(quantity);
            detailsDiv.appendChild(totalPrice);

            itemDiv.appendChild(imgDiv);
            itemDiv.appendChild(detailsDiv);

            checkoutContainer.appendChild(itemDiv);

            document.getElementById("total-price").textContent = `Total Amount: RM${totalAmount.toFixed(2)}`;
        });

        //Display form to proceed to payment
        document.getElementById("proceed-payment").addEventListener("click", function () {
            overlay.classList.remove("hidden");
        });

        //Submit the form to checkout
        confirmButton.addEventListener("click", function (event) {
            overlay.classList.add("hidden");
            event.preventDefault();
            document.getElementById("payment-form").submit();
        });

        //Animation when cancelling checkout
        cancelButton.addEventListener("click", function () {
            fireflyStab.classList.add("show");
            setTimeout(function () {
                overlay.classList.add("hidden");
                fireflyStab.classList.remove("show");
                fireflyStab.classList.add("hidden");
            }, 1250); 
        });

        //Animation when cancelling checkout
        overlay.addEventListener("click", function(event){
            if (event.target === overlay) {
                fireflyStab.classList.add("show");
                setTimeout(function () {
                    overlay.classList.add("hidden");
                    fireflyStab.classList.remove("show");
                    fireflyStab.classList.add("hidden");
                }, 1250); 
            }
        });
    }
});