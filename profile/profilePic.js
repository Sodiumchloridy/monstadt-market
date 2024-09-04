const profilePicture = document.getElementById('profilePicture');
const editIcon = document.getElementById('editIcon');
const fileInput = document.getElementById('fileInput');

editIcon.addEventListener('click', () => {
    fileInput.click();
});

fileInput.addEventListener('change', (event) => {
    const file = event.target.files[0];
    if(file){
        const formData = new FormData();
        formData.append('profile_picture', file);

        fetch('updateProfilePic.php',{
            method: 'POST',
            body: formData
        })
        .then(response => response.json())
        .then(data => {
            if(data.success){
                profilePicture.src = URL.createObjectURL(file);
            } else {
                alert('Failed to updated profile picture');
            }
        })
        .catch(error => {
            console.error("Error: ", error);
            alert("An error occured while updating the profile picture");
        });
    }
});