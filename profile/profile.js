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