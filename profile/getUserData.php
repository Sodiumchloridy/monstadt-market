<?php
session_start();
if(!isset($_SESSION['user_id'])){
    header("Location: ../auth/login.php");
    exit;
}

//connect db
include("../config/config.php");

if (!$conn) {
    die("Connection failed: " . mysqli_error($conn));
}

$stmt = mysqli_prepare($conn, "SELECT u_username, u_email, u_address, u_phone, u_profile_pic, u_profile_pic_type, u_reg_date FROM users WHERE u_id = ?");
if (!$stmt) {
    die("Prepare failed: " . mysqli_error($conn));
}
mysqli_stmt_bind_param($stmt, "s", $_SESSION['user_id']);


mysqli_stmt_execute($stmt);
mysqli_stmt_bind_result($stmt, $username, $email, $address, $phone, $profilePic, $profilePicType, $regDate);



if(mysqli_stmt_fetch($stmt)){
    $profilePicBase64 = base64_encode($profilePic);
    $userData = [
        "name" => $username, 
        "email" => $email, 
        "address" => $address, 
        "phone" => $phone, 
        "profilePicBase64" => $profilePicBase64, 
        "profilePicType" => $profilePicType, 
        "regDate" => $regDate
    ];
}else{
    $userData = [];
}
mysqli_stmt_close($stmt);
header("Content-Type: application/json");
echo json_encode($userData);
