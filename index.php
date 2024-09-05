<?php
session_start();

include 'config/config.php';
$region = "";

// Prepare the SQL query to fetch the image path
$sql = "SELECT `prod_img_name`, `prod_name`, `prod_id` FROM `Product`";
if (isset($_GET['region'])) { //region check
    $region = $_GET['region'];
    if ($region == 'Mondstadt' || $region == 'Liyue' || $region == 'Inazuma' || $region == 'Penacony') {
        $sql .= " WHERE `prod_region` = '{$region}'";
    }
}
$result = mysqli_query($conn, $sql);
mysqli_close($conn);
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title> Mondstadt Market </title>
    <link rel="stylesheet" href="https://site-assets.fontawesome.com/releases/v6.6.0/css/all.css" crossorigin="anonymous" referrerpolicy="no-referrer" /> <!-- Fontawesome icons -->
    <link rel="stylesheet" href="styles/styles.css">
</head>

<body>
    <?php include("includes/header.php"); ?>
    <div class="banner">
        <div class="banner-backdrop"></div>
        <img src="https://fastcdn.hoyoverse.com/content-v2/nap/124305/517f4336e4a3819dee6f9ec4d18fb94c_3292181308204717228.png" alt="banner image">
        <h1>Featured Items</h1>
        <h1 class="shadow">Featured Items</h1>
    </div>
    <!-- grid list of shop items -->
    <main>
        <section id="region-filter">
            <div class="region-grid">
                <a href="/monstadt-market/?region=Mondstadt">
                    <div class="region" id="monstadt" <?php echo "data-value='{$region}'" ?>>Mondstadt</div>
                </a>
                <a href="/monstadt-market/?region=Liyue">
                    <div class="region" id="liyue" <?php echo "data-value='{$region}'" ?>>Liyue</div>
                </a>
                <a href="/monstadt-market/?region=Inazuma">
                    <div class="region" id="inazuma" <?php echo "data-value='{$region}'" ?>>Inazuma</div>
                </a>
                <a href="/monstadt-market/?region=Penacony">
                    <div class="region" id="penacony" <?php echo "data-value='{$region}'" ?>>Penacony</div>
                </a>
            </div>
        </section>
        <div class="product-grid">
            <?php
            if ($result) {
                if (mysqli_num_rows($result) > 0) {
                    // Loop through each row in the result set
                    while ($row = mysqli_fetch_assoc($result)) {
                        // Ensure the path and name are safe and properly escaped
                        $imgFileName = htmlspecialchars($row['prod_img_name'], ENT_QUOTES, 'UTF-8');
                        $prodName = htmlspecialchars($row['prod_name'], ENT_QUOTES, 'UTF-8');

                        // Output the image
                        echo "<a href='product/?id={$row['prod_id']}'>";
                        echo "<div class='product' title='{$prodName}''>";
                        echo "<img src='images/{$imgFileName}' alt='{$prodName}'/>";
                        echo "<p>{$prodName}</p>";
                        echo "</div>";
                        echo "</a>";
                    }
                } else {
                    echo "No products found.";
                }
            } else {
                echo "An error occured: " . $sql . "<br>" . mysqli_error($conn);
            } ?>
        </div>
    </main>
    <?php include("includes/footer.php"); ?> 
</body>

</html>
