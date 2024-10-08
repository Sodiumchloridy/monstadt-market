document.addEventListener("DOMContentLoaded", function() {
    const checkoutForm = document.getElementById("checkout-form");
    const buyParamsInput = document.querySelector('input[name="buyParams"]');
    const checkboxes = document.querySelectorAll('input[type="checkbox"]');
    const totalpricefield = document.getElementById("total-price");

    //Load params
    function generateBuyParams() {
        let params = [];
        checkboxes.forEach(checkbox => {
            if (checkbox.checked) {
                //Get product id
                const prodId = checkbox.parentElement.dataset.id;

                //Find the corresponding product in cartItems using prodId
                const cartItem = cartItems.find(item => item.prodId == prodId);
                console.log(cartItem);
                if (cartItem) {
                    const p_quantity = parseInt(cartItem.prodQuantity);
                    params.push({
                        productId: prodId,
                        quantity: p_quantity
                    });
                } else {
                    console.error(`Product with ID ${prodId} not found in cartItems.`);
                }
            }
        });
        return JSON.stringify(params);
    }

    function updateBuyParams() {
        if (buyParamsInput) {
            buyParamsInput.value = generateBuyParams();
        }
        console.log(buyParamsInput.value);
    }

    function updatePrice() {
        let totalPrice = 0;
        checkboxes.forEach(checkbox => {
            if (checkbox.checked) {
                //Get product id
                const prodId = checkbox.parentElement.dataset.id;

                // Find the corresponding product in cartItems using prodId
                const cartItem = cartItems.find(item => item.prodId == prodId);

                if (cartItem) {
                    const price = parseFloat(cartItem.prodPrice);
                    const quantity = parseInt(cartItem.prodQuantity); 
                    totalPrice += price * quantity;
                } else {
                    console.error(`Product with ID ${prodId} not found in cartItems.`);
                }
            }
        });
        totalpricefield.textContent = totalPrice.toFixed(2);
    }

    //For price adjustment
    checkboxes.forEach((checkbox) => {
        checkbox.addEventListener("change", function(){
            console.log("checkbox changes");
            updateBuyParams();
            updatePrice();
        })
    })

    checkoutForm.addEventListener('submit', function(event){
        updateBuyParams();
        updatePrice();
        event.preventDefault();

        // Prevent form submission if buyParams is empty
        if (!buyParamsInput.value || buyParamsInput.value === "[]") {
            alert("Please select at least one item to proceed with checkout.");
            event.preventDefault();
        } else {
            checkoutForm.submit();
        }
    })
})