document.addEventListener("DOMContentLoaded", function(){

    fetch("getUserData.php?")
    .then(response => response.json())
    .then(data => {
        document.getElementById("username").textContent = data.name;
        document.getElementById("email").textContent = data.email;
        document.getElementById("address").textContent = data.address;
        document.getElementById("phone").textContent = data.phone;
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
        field.replaceWith(input); // replace the span with input element
    });

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
    });

    //end this function if it is not valid
    if(!isValid){
        return;
    }

    editInput.forEach(input => {
        let span = document.createElement("span");
        span.className = "editable";
        span.textContent = input.value;
        span.id = input.id;
        input.replaceWith(span); //replace the input element with a span
    })

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
        address: updatedDataElements[2].textContent,
        phone: updatedDataElements[3].textContent
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
    const phoneRegex = /^(\+?6?01)[02-46-9]-*[0-9]{7,8}$/;
    return phoneRegex.test(phone);
}
