document.addEventListener("DOMContentLoaded", function(){

    fetch("getUserData.php?")
    .then(response => response.json())
    .then(data => {
        document.getElementById("username").textContent = data.name;
        document.getElementById("email").textContent = data.email;
        document.getElementById("phone").textContent = data.phone;
        const {unit, street, postcode, state} = parseAddress(data.address);
        document.getElementById("unit").textContent = unit;
        document.getElementById("street").textContent = street;
        document.getElementById("postcode").textContent = postcode;
        document.getElementById("state").textContent = state;
        document.getElementById("reg").textContent = data.regDate;
        document.getElementById("profilePicture").src = `data: ${data.profilePicType};base64,${data.profilePicBase64}`;
        document.getElementById("profilePicture").alt = "Image is loading...";
    })
    .catch(err => {
        console.log(err);
    })
})

document.getElementById("editBtn").addEventListener("click", function(){
    //get all elements with the class editable
    const editableField = document.querySelectorAll(".editable");

    //loop through each field and make it editable
    editableField.forEach(field => {
        let input = document.createElement("input");
        input.type = "text";
        input.value = field.textContent;
        input.className = "edit-input";
        input.id = field.id;
        input.maxLength = 30;
        if(input.id === "state"){
            input.style.display = "none";
        }

        field.replaceWith(input); // replace the span with input element
    });

    //special handling for state input
    const stateSelect = document.getElementById("stateSelect");
    stateSelect.style.display = 'inline';
    stateSelect.value = document.getElementById("state").value;


    //show the save button and hide the edit button
    document.getElementById("saveBtn").style.display = "inline";
    document.getElementById("editBtn").style.display = "none";
});

document.getElementById("saveBtn").addEventListener("click", function(){
    //get all elements by edit-input class
    const editInput = document.querySelectorAll(".edit-input");
    
    let isValid = true;

    //validation
    editInput.forEach(input => {
        if(!input.value.trim()) {
            input.style.borderColor = 'red';
            input.placeholder = 'Please enter a value';
            input.classList.add('placeholder-red');
            isValid = false;
        }else{
            input.style.borderColor = "";
            input.placeholder = "";
            input.classList.remove("placeholder-red");
        }

        //validate email
        if(input.id === "email" && !validateEmail(input.value)){
            input.style.borderColor = 'red';
            input.placeholder = 'Please enter a valid email';
            input.classList.add('placeholder-red');
            isValid = false;
        }

        //validate phone
        if(input.id === "phone" && !validatePhone(input.value)){
            input.style.borderColor = 'red';
            input.placeholder = 'Please enter a valid phone number';
            input.classList.add('placeholder-red');
            isValid = false;
        }

        //validate unit
        if(input.id === "unit" && !validateUnit(input.value)){
            input.style.borderColor = 'red';
            input.placeholder = 'Please enter a valid unit';
            input.classList.add('placeholder-red');
            isValid = false;
        }

        //validate street
        if(input.id === "street" && !validateStreet(input.value)){
            input.style.borderColor = 'red';
            input.placeholder = 'Please enter a valid street';
            input.classList.add('placeholder-red');
            isValid = false;
        }

        //validate postcode
        if(input.id === "postcode" && !validatePostcode(input.value)){
            input.style.borderColor = 'red';
            input.placeholder = 'Please enter a valid postcode';
            input.classList.add('placeholder-red');
            isValid = false;
        }

        //validate state select
        if(input.id === "stateSelect" && input.value === ''){
            input.style.borderColor = 'red';
            isValid = false;
        }
    });

    //end this function if it is not valid
    if(!isValid){
        return;
    }

    editInput.forEach(input => {
        let span = document.createElement("span");
        span.className = "editable";
        span.id = input.id;
        if(input.id === "state"){
            input.value = document.getElementById("stateSelect").value;
        }
        span.textContent = input.value;
        input.replaceWith(span); //replace the input element with a span
    })

    document.getElementById("stateSelect").style.display = "none";

    //show the edit button and hide the save button
    document.getElementById("saveBtn").style.display = "none";
    document.getElementById("editBtn").style.display = "inline";

    saveProfileData();
});


function saveProfileData(){
    //gather all updated values
    const updatedDataElements = document.querySelectorAll(".editable");
    const updatedData = {
        name: updatedDataElements[0].textContent,
        email: updatedDataElements[1].textContent,
        phone: updatedDataElements[2].textContent,
        address: 
            updatedDataElements[3].textContent + "," +
            updatedDataElements[4].textContent + "," +
            updatedDataElements[5].textContent + "," +
            updatedDataElements[6].textContent
    }

    fetch("saveProfileData.php",{
        method: "POST",
        headers: {"Content-Type": "application/json"},
        body: JSON.stringify(updatedData)
    })
    .then(response => response.json())
    .then(data => {
        if(data.success){
            alert("Profile updated successfully");
        }else{
            alert("Data.success: There was a problem updating your profile.");
        }
    })
    .catch(err => {
        console.error("Error: " + err);
        alert("Caught Error: There was a problem updating your profile.");
    })
}

function validateEmail(email){
    const emailRegex = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
    return emailRegex.test(email);
}

function validatePhone(phone){
    const phoneRegex = /^(\+?6?01)[01-46-9]-*[0-9]{7,8}$/;
    return phoneRegex.test(phone);
}

function parseAddress(address){

    const parts = address.split(",").map(part => part.trim());
    let unit = parts[0];
    let street = parts[1];
    let postcode = parts[2];
    let  state = parts[3];

    return {unit, street, postcode, state};
}

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
