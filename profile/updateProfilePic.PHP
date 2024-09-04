<?php
session_start();

if(!isset($_SESSION['user_id'])){
    header("Location: ../");
    exit;
}

header('Content-Type: application/json');
$response = ['success'=>false];

if($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_FILES['profile_picture'])){
    $file = $_FILES['profile_picture'];

    $allowedTypes = ['image/jpeg', 'image/png', 'image/gif'];
    $maxSize = 5 * 1024 * 1024; // 5MB

    if(in_array($file['type'], $allowedTypes) && $file['size'] <= $maxSize){
        //read file contents
        $imageData = file_get_contents($file['tmp_name']);
        $imgType = $file['type'];

        //db connection
        include("../config/config.php");

        $stmt = mysqli_prepare($conn, "UPDATE users SET u_profile_pic=?, u_profile_pic_type=? WHERE u_id=?");
        mysqli_stmt_bind_param($stmt, "sss", $imageData, $imgType, $_SESSION['user_id']);

        if(mysqli_stmt_execute($stmt)){
            $response['success'] = true;
            $_SESSION['profile_pic'] = $imageData;
            $_SESSION['profile_pic_type'] = $imgType;
        } else {
            $response['message'] = 'Failed to update profile picture in database';
        }

        mysqli_stmt_close($stmt);
        mysqli_close($conn);
    }else{
        $response['message'] = 'Invalid file type or size';
    }
}else{
    $response['message'] = 'No file uploaded';
}

echo json_encode($response);