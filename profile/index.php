<?php session_start();?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Profile</title>
    <link rel="stylesheet" href="profile.css">
    <link rel="stylesheet" href="https://site-assets.fontawesome.com/releases/v6.6.0/css/all.css" crossorigin="anonymous" referrerpolicy="no-referrer" /> <!-- Fontawesome icons -->
</head>
<body>

    <?php include("../includes/header.php"); ?>

    <div class="profile-container">
        <h1>Your profile</h1>
        <div class="profile-picture-container">
            <img id="profilePicture" class="profile-picture" src="" alt="Profile Picture" />
            <div class="edit-icon" id="editIcon">✏️</div>
        </div>
        <input type="file" id="fileInput" style="display: none;" accept="image/*">

        <div class="profile-details">
            <p><strong>Username:</strong> <span id="username" class="editable"></span></p>
            <p><strong>Email:</strong> <span id="email" class="editable"></span></p>
            <p><strong>Phone:</strong> <span id="phone" class="editable"></span></p>

            <strong>Address:</strong>
            <p>Unit:<span id="unit" class="editable"></span></p>
            <p>Street:<span id="street" class="editable"></span></p>
            <p>Postcode:<span id="postcode" class="editable"></span></p>
            <p>
                State:
                <span id="state" class="editable"></span>
                <select id="stateSelect" style="display: none;">
                    <option value="" disabled >Select State</option>
                    <option value="Johor" >Johor</option>
                    <option value="Kedah" >Kedah</option>
                    <option value="Kelantan" >Kelantan</option>
                    <option value="Kuala Lumpur" >Kuala Lumpur</option>
                    <option value="Labuan" >Labuan</option>
                    <option value="Melaka" >Melaka</option>
                    <option value="Negeri Sembilan" >Negeri Sembilan</option>
                    <option value="Pahang" >Pahang</option>
                    <option value="Penang" >Penang</option>
                    <option value="Perak" >Perak</option>
                    <option value="Perlis" >Perlis</option>
                    <option value="Putrajaya" >Putrajaya</option>
                    <option value="Sabah" >Sabah</option>
                    <option value="Sarawak" >Sarawak</option>
                    <option value="Selangor" >Selangor</option>
                    <option value="Terengganu">Terengganu</option>
                    </select>
            </p>



            <p><strong>Register Date:</strong> <span id="reg" class="field"></span></p>            
        </div>

        <button id="editBtn">Edit</button>
        <button id="saveBtn" style="display: none;">Save</button>

    </div>
    <?php include("../includes/footer.php"); ?>
    <script src="profile.js"></script>
    <script src="profilePic.js"></script>
</body>
</html>
