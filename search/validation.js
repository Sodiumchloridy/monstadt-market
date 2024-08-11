document.addEventListener('DOMContentLoaded', function() {
    const filter_form = document.getElementById('filter-form');
    let minInput = document.getElementById('min');
    let maxInput = document.getElementById('max');

    //To clear error message of price input
    function clearErrorMessage() {
        price_error.textContent = '';
    }

    //Clear error message when user input min price or max price
    minInput.addEventListener('input', clearErrorMessage);
    maxInput.addEventListener('input', clearErrorMessage);

    //Validate price range
    function validatePriceRange() {
        clearErrorMessage();
        let minValue = parseFloat(minInput.value);
        let maxValue = parseFloat(maxInput.value);

        if (!isNaN(minValue) && !isNaN(maxValue) && minValue > maxValue) {
            price_error.textContent = 'Please input a valid price range.';
            return false;
        }
        return true;
    }

    //Prevent the values from being submitted if the value of min price and max price is empty
    function check_min_max_value(){
        if (!minInput.value) {
            minInput.name = '';
        }

        if (!maxInput.value) {
            maxInput.name = '';  
        }
    }
    filter_form.addEventListener('submit', function() {
        check_min_max_value();
    });


    //Allow filters in category to be applied when any checkboxes are changed
    let category_filter = document.getElementsByName("category[]");
    category_filter.forEach((category) => {
        category.addEventListener('change', function(){
        check_min_max_value();

        if (!validatePriceRange()){
            minInput.name = '';
            maxInput.name = '';
        }

        filter_form.submit();
        })
    })

    //Validation for price range
    //Check if min price is more than maximum price
    let price_filter_button = document.getElementById('price-filter-button');
    let price_error = document.getElementById('price-filter-error'); 
    price_filter_button.addEventListener('click', function(event){
        if(!validatePriceRange()){
            event.preventDefault();
        }
    });
});