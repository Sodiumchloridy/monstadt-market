<?php session_start();?>
<!DOCTYPE html>
<html>

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title> Mondstadt Market </title>
    <base href="../">
    <link rel="stylesheet" href="https://site-assets.fontawesome.com/releases/v6.6.0/css/all.css" crossorigin="anonymous" referrerpolicy="no-referrer" /> <!-- Fontawesome icons -->
    <link rel="stylesheet" href="styles/styles.css">
    <link rel="stylesheet" href="styles/header.css">
    <link rel="stylesheet" href="styles/footer.css">
</head>

<body>
    <?php
    $item = $_GET['id'] ?? null;

    // Header
    include('../includes/header.php');

    $item or die('<h1 align="center">Please select an item.</h1>');

    // Fetch content
    include('../config/config.php');
    $stmt = mysqli_prepare($conn, "SELECT * FROM `product` WHERE `prod_id` = ?");
    mysqli_stmt_bind_param($stmt, "s", $item);
    mysqli_stmt_execute($stmt);
    $result = mysqli_stmt_get_result($stmt);

    if (mysqli_num_rows($result) > 0) {
        $row = mysqli_fetch_assoc($result);
        echo "<img src='images/" . $row['prod_img_name'] . "' alt='" . $row['prod_name'] . "'>";
        echo "<h1 align='center'>" . $row['prod_name'] . "</h1>";
        echo "<p align='center'>Description: " . $row['prod_desc'] . "</p>";
        echo "<p align='center'>Price: " . $row['prod_price'] . "</p>";
        echo "<p align='center'>Region: " . $row['prod_region'] . "</p>";
        echo "<p align='center'>Available: " . $row['prod_numAvailable'] . "</p>";
        echo "<p align='center'>Sold: " . $row['prod_numSold'] . "</p>";
    }
    ?>
</body>

</html>
