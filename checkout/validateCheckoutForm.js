document.addEventListener("DOMContentLoaded", function () {
    //For payment address
    const addressRadioButtons = document.querySelectorAll("#payment-address input[type='radio']");
    const paymentMethodInputs = document.querySelectorAll('input[name="payment-method"]');
    const customAddressInput = document.getElementById('address-input');
    const hiddenAddressInput = document.querySelector('input[name="address"]');
    const hiddenPaymentMethodInput = document.querySelector('input[name="paymentMethod"]');
    const confirmButton = document.getElementById("confirm-payment");
    const proceedButton = document.getElementById("proceed-payment");
    const addressErrorDiv = document.getElementById("address-error");
    const paymentErrorDiv = document.getElementById("payment-error");

    //Update address based on selection
    addressRadioButtons.forEach(function (button){
        button.addEventListener("change", () => setPaymentAddress());
    });
    function setPaymentAddress(){
        const selectedAddress = document.querySelector('#payment-address input[type="radio"]:checked');
        if (selectedAddress.value === "default-address"){
            addressErrorDiv.innerHTML = "";
            customAddressInput.setAttribute("disabled", true);
            hiddenAddressInput.value = "";
        } else if (selectedAddress.value === "custom-address") {
            addressErrorDiv.innerHTML = "";
            hiddenAddressInput.value = customAddressInput.value;
            customAddressInput.removeAttribute("disabled");
        }
    }

    //Update payment method value
    function setPaymentMethod(){
        const selectedPaymentMethod = document.querySelector('input[name="payment-method"]:checked');
        hiddenPaymentMethodInput.value = selectedPaymentMethod.value;
    }
    
    //Remove error message of payment method
    paymentMethodInputs.forEach((paymentInput) =>{
        paymentInput.addEventListener("click", ()=>{
            setPaymentMethod();
            paymentErrorDiv.textContent ="";
        })
    });

    //Update address when address is filled in
    customAddressInput.addEventListener("input", () => updateAddressOnInput());
    function updateAddressOnInput(){
        if (document.querySelector("#custom-address").checked){
            addressErrorDiv.innerHTML = "";
            hiddenAddressInput.value = customAddressInput.value;
        }
    }

    //Ensure that address is filled in if default address is not selected
    function validateAddressField(){
        const selectedAddress = document.querySelector('#payment-address input[type="radio"]:checked');
        if (selectedAddress.value === "default-address"){
            return true;
        } else if (selectedAddress.value === "custom-address") {
            if (customAddressInput.value.trim() === ''){
                addressErrorDiv.innerHTML = "Please enter your address.";
                return false;
            } else {
                return true;
            }
        } else {
            return false;
        }
    }

    //Ensure payment method is selected
    function validatePaymentMethod() {
        const selectedPaymentMethod = document.querySelector('input[name="payment-method"]:checked');
        if (!selectedPaymentMethod) {
            paymentErrorDiv.innerHTML = "Please select a payment method.";
            return false;
        }
        paymentErrorDiv.innerHTML = "";
        return true;
    }

    //Submit the form to checkout
    confirmButton.addEventListener("click", function (event) {
        overlay.classList.add("hidden");
        event.preventDefault();
        //Validate if address field is empty
        if (validateAddressField() && validatePaymentMethod()) {
            document.getElementById("payment-form").submit();
        }
    });

    //For confirmation form
    const overlay = document.getElementById("payment-overlay");
    const cancelButton = document.getElementById("cancel-payment");
    const fireflyStab = document.querySelector('#payment-overlay .confirm-box #firefly-stab');

    //Display form to proceed to payment
    proceedButton.addEventListener("click", function () {
        if (validateAddressField() && validatePaymentMethod()){
            overlay.classList.remove("hidden");
        }
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

})




