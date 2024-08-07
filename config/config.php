<?php
//Database configuration
$dbHost = "localhost";
$dbUsername = "root";
$dbPassword = "";
$dbName = "mondstadt_market_db";

//Connect to database
$conn = mysqli_connect($dbHost, $dbUsername, $dbPassword, $dbName);

//Check connection
$conn or die("Connection failed: " . mysqli_connect_error());
?>
