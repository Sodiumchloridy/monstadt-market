<?php
include 'config.php';

// Assuming you want to display the image with `prod_id` = 1
$prod_id = 1;

// Prepare the SQL query to fetch the image path
$sql = "SELECT `prod_img_name`, `prod_name`, `prod_id` FROM `Product`";
$result = mysqli_query($conn, $sql);

if ($result) {
    if (mysqli_num_rows($result) > 0) {
        // Loop through each row in the result set
        while ($row = mysqli_fetch_assoc($result)) {
            // Ensure the path and name are safe and properly escaped
            $imgFileName = htmlspecialchars($row['prod_img_name'], ENT_QUOTES, 'UTF-8');
            $prodName = htmlspecialchars($row['prod_name'], ENT_QUOTES, 'UTF-8');

            // Output the image
            echo '<a href="product?id=' . $row['prod_id'] . '">';
            echo '<div class="product">';
            echo '<img src="images/' . $imgFileName . '" alt="' . $prodName . '"/>';
            echo '<p>' . $prodName . '</p>';
            echo '</div>';
            echo '</a>';
        }
    } else {
        echo "No products found.";
    }
} else {
    echo "Error: " . $sql . "<br>" . mysqli_error($conn);
}

mysqli_close($conn);
