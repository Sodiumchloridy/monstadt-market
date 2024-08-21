document.addEventListener("DOMContentLoaded", function() {
    const checkoutForm = document.getElementById("checkout-form");
    const buyParamsInput = document.querySelector('input[name="buyParams"]');
    const checkboxes = document.querySelectorAll('input[type="checkbox"]');
    const itemList = document.getElementsByClassName("cart-item");

    console.log(cartItems);

    //Load params
    function generateBuyParams() {
        let params = [];
        checkboxes.forEach(checkbox => {
            if (checkbox.checked) {
                const cartItemDiv = checkbox.closest('.cart-item');
                const prodId = cartItemDiv.querySelector('input[name="product_id"]').value;
                const quantity = cartItemDiv.querySelector('input[name="quantity"]').value;
                params.push({
                    productId: prodId,
                    quantity: quantity
                });
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

    //For price adjustment
    checkboxes.forEach((checkbox) => {
        checkbox.addEventListener("change", function(){
            console.log("checkbox changed");
            updateBuyParams();
        })
    })

    //TODO
    checkoutForm.addEventListener('submit', function(event){
        event.preventDefault();
    })
})