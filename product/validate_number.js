window.onload = function() {
    const numericInputs = document.querySelectorAll("[inputmode='numeric']");

    numericInputs.forEach((input) => {
        input.addEventListener("input", function(e) {
            //Save the current value in case the new value is invalid
            const previousValue = input.value;

            //Validate input against the pattern
            if (!input.validity.valid) {
                //Revert to the previous value if invalid input is detected
                input.value = previousValue.slice(0, -1);
            }
        });
    });
}
