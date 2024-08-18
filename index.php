<?php session_start(); ?>
<!DOCTYPE html>
<html>

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title> Mondstadt Market </title>
    <link rel="stylesheet" href="https://site-assets.fontawesome.com/releases/v6.6.0/css/all.css" crossorigin="anonymous" referrerpolicy="no-referrer" /> <!-- Fontawesome icons -->
    <link rel="stylesheet" href="styles/styles.css">
    <link rel="stylesheet" href="styles/header.css">
    <link rel="stylesheet" href="styles/footer.css">
</head>

<body>
    <?php include("includes/header.php"); ?>
    <div class="banner">
        <div class="banner-backdrop"></div>
        <img src="https://fastcdn.hoyoverse.com/content-v2/nap/124305/517f4336e4a3819dee6f9ec4d18fb94c_3292181308204717228.png" alt="banner image">
    </div>
    <!-- grid list of shop items -->
    <main class="main">
        <div class="product-grid">
            <?php
            include('config/display_data.php'); ?>
        </div>
    </main>

    <?php include("includes/footer.php"); ?>
</body>

</html>
