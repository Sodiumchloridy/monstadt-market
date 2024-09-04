document.addEventListener("DOMContentLoaded", function () {
    const checkoutContainer = document.getElementById("checkout-container");
    const checkoutSummary = document.getElementById("checkout-summary");

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
            const imgBackground = document.createElement("div");
            imgBackground.classList.add("img-background");
            imgBackground.innerText = "CAUTION HOT! 注意！";
            imgBackground.setAttribute("data-content", "CAUTION HOT! 注意！");
            imgDiv.appendChild(imgBackground);


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

            document.getElementById("total-price").textContent = `Amount: RM${totalAmount.toFixed(2)}`;
        });
    }
});
