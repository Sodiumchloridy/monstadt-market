const numericInputs = document.querySelectorAll("[inputmode='numeric']");

numericInputs.forEach((input) =>{
    validateInput(input);
})

function validateInput(el){
    el.addEventListener("beforeInput", function(e){
        let beforeValue = el.value;
        e.target.addEventListener("input", function(){
            if (el.validity.patternMismatch){
                el.value = beforeValue;
            }
        }, {once : true}
    );
    });

}