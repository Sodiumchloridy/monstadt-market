document.addEventListener("DOMContentLoaded", function () {
    const addressRadioButtons = document.querySelectorAll("#payment-address input[type='radio']");
    const customAddressInput = document.getElementById('address-input');
    const hiddenAddressInput = document.querySelector('input[name="address"]');

    //Set default address
    setPaymentAddress();
    //Update address based on selection
    addressRadioButtons.forEach(function (button){
        button.addEventListener("change", () => setPaymentAddress());
    });

    function setPaymentAddress(){
        const selectedAddress = document.querySelector('#payment-address input[type="radio"]:checked');
        if (selectedAddress.value === "default-address"){
            customAddressInput.setAttribute("disabled", true);
            hiddenAddressInput.value = "";
        } else if (selectedAddress.value === "custom-address") {
            hiddenAddressInput.value = customAddressInput.value;
            customAddressInput.removeAttribute("disabled");
        }
    }
    
    //Update address when address is filled in
    customAddressInput.addEventListener("input", () => updateAddressOnInput());

    function updateAddressOnInput(){
        if (document.querySelector("#custom-address").checked){
            hiddenAddressInput.value = customAddressInput.value;
        }
    }

})




