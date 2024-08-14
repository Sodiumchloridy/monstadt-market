<?php
include 'config.php';

//Create user table
$sql = "CREATE TABLE IF NOT EXISTS Users (
    u_id INT(6) UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    u_username VARCHAR(30) UNIQUE,
    u_password VARCHAR(255) NOT NULL,
    u_email VARCHAR(100),
    u_address VARCHAR(255),
    u_phone VARCHAR(50),
    u_profile_pic LONGBLOB,
    u_profile_pic_type VARCHAR(50),
    u_reg_date TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
)";

if (mysqli_query($conn, $sql)) {
    echo "Table Users created successfully <br>";
} else {
    echo "Error creating table Users: " . mysqli_error($conn);
}

//Create product table
$sql = "CREATE TABLE IF NOT EXISTS Product (
    prod_id INT(6) UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    prod_img_name VARCHAR(255),
    prod_name VARCHAR(128) NOT NULL,
    prod_desc TEXT,
    prod_price DECIMAL(10,2) NOT NULL, 
    prod_region VARCHAR(128),
    prod_numAvailable INT(6) NOT NULL,
    prod_numSold INT(6) NOT NULL,
    INDEX(prod_name)
)";

if (mysqli_query($conn, $sql)) {
    echo "Table Product created successfully <br>";
} else {
    echo "Error creating table Product: " . mysqli_error($conn);
}

//Create cart table
$sql = "CREATE TABLE IF NOT EXISTS Cart(
    u_id INT(6) UNSIGNED,
    prod_id INT(6) UNSIGNED,
    quantity INT(6) NOT NULL,
    PRIMARY KEY (u_id, prod_id),
    FOREIGN KEY (u_id) REFERENCES Users(u_id) ON DELETE CASCADE,
    FOREIGN KEY (prod_id) REFERENCES Product(prod_id) ON DELETE CASCADE,
    UNIQUE KEY unique_cart_item (u_id, prod_id)
)";

if (mysqli_query($conn, $sql)) {
    echo "Table Cart created successfully <br>  ";
} else {
    echo "Error creating table Cart: " . mysqli_error($conn);
}

//Close connection
mysqli_close($conn);
