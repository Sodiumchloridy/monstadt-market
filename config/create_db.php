<?php
// Database configuration
$servername = "localhost";
$username = "root";
$password = "";

// Create connection
$conn = mysqli_connect($servername, $username, $password);

// Check connection
if (!$conn) {
    die("Connection failed: " . mysqli_connect_error());
}

$dbName = "mondstadt_market_db";

// SQL query to drop database
$sql = "DROP DATABASE IF EXISTS $dbName";

if (mysqli_query($conn, $sql)) {
    echo "Database dropped successfully <br>";
} else {
    echo "Error dropping database: " . mysqli_error($conn);
}

// SQL query to create the database
$sql = "CREATE DATABASE IF NOT EXISTS $dbName";

// Execute the SQL query
if (mysqli_query($conn, $sql)) {
    echo "Database created successfully or already exists <br>";
} else {
    echo "Error creating database: " . mysqli_error($conn);
}

// Close the connection
mysqli_close($conn);
