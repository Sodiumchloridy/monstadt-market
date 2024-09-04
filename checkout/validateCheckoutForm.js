document.addEventListener("DOMContentLoaded", function () {
    const addressRadioButtons = document.querySelectorAll("#payment-address input[type='radio']");
    const paymentMethodInputs = document.querySelectorAll('input[name="payment-method"]');

    const customAddressUnitInput = document.getElementById('unit-input');
    const customAddressStreetInput = document.getElementById('street-input');
    const customAddressPostcodeInput = document.getElementById('postcode-input');
    const customAddressStateSelect = document.getElementById('stateSelect');
    const hiddenAddressInput = document.querySelector('input[name="address"]');

    const hiddenPaymentMethodInput = document.querySelector('input[name="paymentMethod"]');
    const confirmButton = document.getElementById("confirm-payment");
    const proceedButton = document.getElementById("proceed-payment");
    const paymentErrorDiv = document.getElementById("payment-error");

    //Address input
    //Update address based on selection
    addressRadioButtons.forEach(function (button){
        button.addEventListener("change", () => setAddressSource());
    });
    function setAddressSource(){
        const selectedAddress = document.querySelector('#payment-address input[type="radio"]:checked');
        if (selectedAddress.value === "default-address"){
            disableAddressField();
            hiddenAddressInput.value = "";
        } else if (selectedAddress.value === "custom-address") {
            enableAddressField();
            setAddressValue();
        }
    }

    //Disable address field
    function disableAddressField(){
        customAddressUnitInput.setAttribute("disabled", true);
        customAddressStreetInput.setAttribute("disabled", true);
        customAddressPostcodeInput.setAttribute("disabled", true);
        customAddressStateSelect.setAttribute("disabled", true);
    }

    //Enable address field
    function enableAddressField(){
        customAddressUnitInput.removeAttribute('disabled');
        customAddressStreetInput.removeAttribute('disabled');
        customAddressPostcodeInput.removeAttribute('disabled');
        customAddressStateSelect.removeAttribute('disabled');
    }

    //Update address value
    function setAddressValue(){
        const unit = customAddressUnitInput.value.trim();
        const street = customAddressStreetInput.value.trim();
        const postcode = customAddressPostcodeInput.value.trim();
        const state = customAddressStateSelect.value;

        hiddenAddressInput.value = `${unit} ${street} ${postcode} ${state}`;
    }
    
    //Payment method input
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

    //Address validation
    //Update address when address is filled in and clear error message
    customAddressUnitInput.addEventListener("input", () => {
        updateAddressOnInput();
        const unit = customAddressUnitInput.value.trim();
        if (!validateUnit(unit)) {
            document.getElementById("unit-error").innerHTML = "Please enter a valid unit.";
            isvalid = false;
        } else {
            document.getElementById("unit-error").innerHTML = "";
        }
    });
    customAddressStreetInput.addEventListener("input", () => {
        updateAddressOnInput();
        const street = customAddressStreetInput.value.trim();
        if (!validateStreet(street)) {
            document.getElementById("street-error").innerHTML = "Please enter a valid street address.";
            isvalid = false;
        } else {
            document.getElementById("street-error").innerHTML = "";
        }
    });
    customAddressPostcodeInput.addEventListener("input", () => {
        updateAddressOnInput();
        const postcode = customAddressPostcodeInput.value.trim();
        if (!validatePostcode(postcode)) {
            document.getElementById("postcode-error").innerHTML = "Please enter a valid postcode.";
            isvalid = false;
        } else {
            document.getElementById("postcode-error").innerHTML = "";
        }
    });
    customAddressStateSelect.addEventListener("change", () => {
        updateAddressOnInput();
        const state = customAddressStateSelect.value;
        if (state === "") {
            document.getElementById("state-error").innerHTML = "Please select a state.";
            isvalid = false;
        } else {
            document.getElementById("state-error").innerHTML = "";
        }
    });
    function updateAddressOnInput(){
        if (document.querySelector("#custom-address").checked){
            setAddressValue();
        }
    }

    //Ensure that address is filled in if default address is not selected
    function validateAddressField(){
        const selectedAddress = document.querySelector('#payment-address input[type="radio"]:checked');
        if (selectedAddress.value === "default-address"){
            return true;
        } else if (selectedAddress.value === "custom-address") {
            //Validate all address field
            const unit = customAddressUnitInput.value.trim();
            const street = customAddressStreetInput.value.trim();
            const postcode = customAddressPostcodeInput.value.trim();
            const state = customAddressStateSelect.value;
            
            let isvalid = true;

            if (!validateUnit(unit)) {
                document.getElementById("unit-error").innerHTML = "Please enter a valid unit.";
                isvalid = false;
            } else {
                document.getElementById("unit-error").innerHTML = "";
            }

            if (!validateStreet(street)) {
                document.getElementById("street-error").innerHTML = "Please enter a valid street address.";
                isvalid = false;
            } else {
                document.getElementById("street-error").innerHTML = "";
            }

            if (!validatePostcode(postcode)) {
                document.getElementById("postcode-error").innerHTML = "Please enter a valid postcode.";
                isvalid = false;
            } else {
                document.getElementById("postcode-error").innerHTML = "";
            }

            if (state === "") {
                document.getElementById("state-error").innerHTML = "Please select a state.";
                isvalid = false;
            } else {
                document.getElementById("state-error").innerHTML = "";
            }

            return isvalid;

        } else {
            return false;
        }
    }

    //Payment method validation
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

    //Validate form before submission
    //Submit the form to checkout
    confirmButton.addEventListener("click", function (event) {
        overlay.classList.add("hidden");
        event.preventDefault();
        //Validate if address field is empty
        let isValidAddress = validateAddressField();
        let isValidPayment = validatePaymentMethod();
        if (isValidAddress && isValidPayment) {
            document.getElementById("payment-form").submit();
        }
    });

    //For confirmation form
    const overlay = document.getElementById("payment-overlay");
    const cancelButton = document.getElementById("cancel-payment");
    const fireflyStab = document.querySelector('#payment-overlay .confirm-box #firefly-stab');

    //Validate form again before showing confirmation
    //Display form to proceed to payment
    proceedButton.addEventListener("click", function () {
        let isValidAddress = validateAddressField();
        let isValidPayment = validatePaymentMethod();
        if (isValidAddress && isValidPayment) {
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

function validatePostcode(postcode) {
    // Malaysian postcodes are 5 digits
    const postcodeRegex = /^\d{5}$/;
    return postcodeRegex.test(postcode);
}

function validateUnit(unit) {
    // Assuming unit format is like "A-1-2" or "1-2-3" or just "123"
    const pattern = /^([A-Za-z0-9]-?)+$/;
    return pattern.test(unit);
}

function validateStreet(street) {
    // Basic validation: non-empty string with letters, numbers, spaces, and common punctuation
    const pattern = /^[A-Za-z0-9\s\.,'-]+$/;
    return pattern.test(street) && street.length >= 5;
}

function validatePostcode(postcode) {
    // Malaysian postcodes are 5 digits
    const pattern = /^\d{5}$/;
    return pattern.test(postcode);
}