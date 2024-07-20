<?php
include 'config.php';

$sql = "CREATE TABLE IF NOT EXISTS Users (
    u_id INT(6) UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    username VARCHAR(30) UNIQUE,
    email VARCHAR(50) NOT NULL,
    phone VARCHAR(50) NOT NULL,
    reg_date TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
)";

if ($conn->query($sql) === TRUE) {
    echo "Table Users created successfully\n";
} else {
    echo "Error creating table: " . $conn->error;
}

$sql = "CREATE TABLE IF NOT EXISTS Product (
    prod_id INT(6) UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    prod_img MEDIUMBLOB,
    prod_name VARCHAR(128) NOT NULL,
    prod_desc VARCHAR(256),
    prod_price DECIMAL(10,2) NOT NULL, 
    prod_numAvailable INT(6) NOT NULL,
    prod_numSold INT(6) NOT NULL
)";

if ($conn->query($sql) === TRUE) {
    echo "Table Product created successfully\n";
} else {
    echo "Error creating table: " . $conn->error;
}

$sql = "CREATE TABLE IF NOT EXISTS Cart(
    u_id INT(6) UNSIGNED,
    prod_id INT(6) UNSIGNED,
    quantity INT(6) NOT NULL,
    PRIMARY KEY (u_id, prod_id),
    FOREIGN KEY (u_id) REFERENCES Users(u_id) ON DELETE CASCADE,
    FOREIGN KEY (prod_id) REFERENCES Product(prod_id) ON DELETE CASCADE
)";

if ($conn->query($sql) === TRUE) {
    echo "Table Cart created successfully\n";
} else {
    echo "Error creating table: " . $conn->error;
}

//Close connection
$conn->close();
