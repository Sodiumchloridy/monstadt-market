<?php session_start(); ?>
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
    <div class="background">
        <h1>亓才子</h1>
        <h1>QI CAI JIE</h1>
        <h1>亓才子</h1>
    </div>
    <div class="profile-container">
        <h1>My profile</h1>
        <div class="profile-picture-container">
            <img id="profilePicture" class="profile-picture" src="" alt="Profile Picture" />
            <div class="edit-icon" id="editIcon" title="Edit Profile Picture">
                <i class="fad fa-pencil"></i>
            </div>
        </div>
        <input type="file" id="fileInput" style="display: none;" accept="image/*">

        <div class="profile-details">
            <div class="field-group">
                <p>Username</p><span id="username" class="editable"></span>
            </div>
            <div class="field-group">
                <p>Email</p>
                <span id="email" class="editable"></span>
            </div>
            <div class="field-group">
                <p>Phone</p>
                <span id="phone" class="editable"></span>
            </div>
            <div class="separator"></div>
            <p id="address-title">Address</p>
            <div class="separator"></div>
            <div class="field-group">
                <p>Unit</p>
                <span id="unit" class="editable"></span>
            </div>
            <div class="field-group">
                <p>Street</p>
                <span id="street" class="editable"></span>
            </div>
            <div class="field-group">
                <p>Postcode</p>
                <span id="postcode" class="editable"></span>
            </div>
            <div class="field-group">
                <p>State</p>
                <span id="state" class="editable"></span>
                <select id="stateSelect" style="display: none;">
                    <option value="" disabled>Select State</option>
                    <option value="Johor">Johor</option>
                    <option value="Kedah">Kedah</option>
                    <option value="Kelantan">Kelantan</option>
                    <option value="Kuala Lumpur">Kuala Lumpur</option>
                    <option value="Labuan">Labuan</option>
                    <option value="Melaka">Melaka</option>
                    <option value="Negeri Sembilan">Negeri Sembilan</option>
                    <option value="Pahang">Pahang</option>
                    <option value="Penang">Penang</option>
                    <option value="Perak">Perak</option>
                    <option value="Perlis">Perlis</option>
                    <option value="Putrajaya">Putrajaya</option>
                    <option value="Sabah">Sabah</option>
                    <option value="Sarawak">Sarawak</option>
                    <option value="Selangor">Selangor</option>
                    <option value="Terengganu">Terengganu</option>
                </select>
            </div>
            <div class="field-group">
                <p>Register Date</p>
                <span id="reg" class="field"></span>
            </div>
        </div>

        <button id="editBtn">Edit</button>
        <button id="saveBtn" style="display: none;">Save</button>
    </div>
    <?php include("../includes/footer.php"); ?>
    <script src="profile.js"></script>
    <script src="profilePic.js"></script>
    <script src="script.js"></script>
    <script defer type="text/javascript">
        function googleTranslateElementInit() {
            new google.translate.TranslateElement({
                    pageLanguage: 'en'
                },
                'google_translate_element'
            );
        }
    </script>
    <script defer type="text/javascript" src="https://translate.google.com/translate_a/element.js?cb=googleTranslateElementInit"></script>
</body>

</html>
