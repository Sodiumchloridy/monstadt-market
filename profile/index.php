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
            <p><strong>Username:</strong> <span id="username" class="editable field"></span></p>
            <p><strong>Email:</strong> <span id="email" class="editable field"></span></p>
            <p><strong>Address:</strong> <span id="address" class="editable field"></span></p>
            <p><strong>Phone:</strong> <span id="phone" class="editable field"></span></p>
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

