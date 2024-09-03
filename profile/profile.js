document.addEventListener("DOMContentLoaded", function(){

    fetch("getUserData.php?")
    .then(response => response.json())
    .then(data => {
        const username = document.getElementById("username");
        const email = document.getElementById("email");
        const address = document.getElementById("address");
        const phone = document.getElementById("phone");
        const reg = document.getElementById("reg");
        const img = document.getElementById("profilePic");
        
        username.textContent = data.name;
        email.textContent = data.email;
        address.textContent = data.address;
        phone.textContent = data.phone;
        reg.textContent = data.regDate;
        img.src = `data: ${data.profilePicType};base64,${data.profilePicBase64}`;
        img.alt = "Image is loading...";
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
        field.replaceWith(input); // replace the span with input element
    });

    //show the save button and hide the edit button
    document.getElementById("saveBtn").style.display = "inline";
    document.getElementById("editBtn").style.display = "none";
});

document.getElementById("saveBtn").addEventListener("click", function(){
    //get all elements by edit-input class
    const editInput = document.querySelectorAll(".edit-input");

    //loop through each input field
    editInput.forEach(input => {
        let span = document.createElement("span");
        span.className = "editable";
        span.textContent = input.value;
        input.replaceWith(span); //replace the input element with a span
    });

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
    .then(response => response.text())
    .then(text => {
        console.log(JSON.stringify(updatedData));
        console.log("Response text: " + text);
        return JSON.parse(text);
    })
    .then(data => {
        if(data.success){
            alert("Profile updated successfully");
        }else{
            alert("There was a problem updating your profile.");
        }
    })
    .catch(err => {
        console.error("Error: " + err);
        alert("There was a problem updating your profile.");
    })
}

