<?php
session_start();

if(!isset($_SESSION['user_id'])){
    header("Location: ../");
    exit;
}

//db connection
include("../config/config.php");

if(!$conn){
    die("Connection failed: " . mysqli_connect_error());
}

//get the raw post data
$input = file_get_contents("php://input");
$data = json_decode($input, true);

//prepare and execute the updated query
$stmt = mysqli_prepare($conn, "UPDATE users SET u_username=?, u_email=?, u_address=?, u_phone=? WHERE u_id=?");
mysqli_stmt_bind_param($stmt, "sssss", $data["name"], $data["email"], $data["address"], $data["phone"], $_SESSION['user_id']);

if(mysqli_stmt_execute($stmt)){
    //return success response
    echo json_encode(["success" => true]);
}else {
    //return error response
    echo json_encode(["success" => false]);
}

mysqli_stmt_close($stmt);
mysqli_close($conn);