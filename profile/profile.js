document.addEventListener("DOMContentLoaded", function(){
    if(userData){
        document.getElementById("username").textContent = userData.username || "N/A";
        document.getElementById("email").textContent = userData.email || "N/A";
        document.getElementById("address").textContent = userData.address || "N/A";
        document.getElementById("profilePic").src = `data:${userData.profilePicType};base64,${userData.profilePic}`;
    } else {
        console.error("User data is not available");
    }
})