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

header("Content-Type: application/json");
if(mysqli_stmt_execute($stmt)){
    //return success response
    $_SESSION['username'] = $data["name"];
    $_SESSION['email'] = $data["email"];
    $_SESSION['address'] = $data["address"];
    $_SESSION['phone'] = $data["phone"];
    echo json_encode(["success" => true]);

}else {
    //return error response
    die("Execute failed: (" . mysqli_stmt_errno($stmt) . ") " . mysqli_stmt_error($stmt));
    echo json_encode(["success" => false]);
}

mysqli_stmt_close($stmt);
mysqli_close($conn);