<?php 
session_start();

// connect to database
include("../config/config.php");

$stmt = mysqli_prepare($conn, "SELECT u_username, u_email, u_address, u_profile_pic, u_profile_pic_type FROM users WHERE u_id=?");
mysqli_stmt_bind_param($stmt, "i", $_SESSION['user_id']);
mysqli_stmt_execute($stmt);
mysqli_stmt_bind_result($stmt, $username, $email, $address, $profilePic, $profilePicType);
mysqli_stmt_fetch($stmt);
mysqli_stmt_close($stmt);

//convert binary data of the profile pic to base64
$profilePicBase64 = base64_encode($profilePic);

//preparing user data as an associative array
$userData = [
    'username' => $username,
    'email' => $email,
    'address' => $address,
    'profilePic' => $profilePicBase64,
    'profilePicType' => $profilePicType
];

?>

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

        <div class="profile-details">
            <p><strong>Username:</strong> <span id="username"></span></p>
            <p><strong>Email:</strong> <span id="email"></span></p>
            <p><strong>Address:</strong> <span id="address"></span></p>
        </div>

        <div class="profile-pic">
            <img id="profilePic" src="" alt="Profile Picture" />
        </div>

    </div>
    <?php include("../includes/footer.php"); ?>
    <script>
        const userData = <?php echo json_encode($userData); ?>;
        console.log(userData);
    </script>
    <script src="profile.js"></script>
</body>
</html>

