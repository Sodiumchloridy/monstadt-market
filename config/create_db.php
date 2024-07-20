<?php
// Database configuration
$servername = "localhost";
$username = "root";
$password = "";

// Create connection
$conn = new mysqli($servername, $username, $password);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

$dbName = "mondstadt_market_db";

// SQL query to drop database
//$sql = "DROP DATABASE IF EXISTS $dbName";

// SQL query to create the database
$sql = "CREATE DATABASE IF NOT EXISTS $dbName";

// Execute the SQL query
if ($conn->query($sql) === TRUE) {
    echo "Database created successfully or already exists";
} else {
    echo "Error creating database: " . $conn->error;
}

// Close the connection
$conn->close();
