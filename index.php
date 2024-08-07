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
    <?php include ("includes/header.php"); ?>
    <p>xxxx</p>

    <!-- grid list of shop items -->
    <div class="product-grid">
        <?php 
        include ('config/setup.php');
        $filePath = 'images/';
        include('config/display_data.php'); ?>        
    </div>

    <div id="search-results"></div>
        <?php include("includes/footer.php"); ?>
</body>

</html>
