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
    <?php include('../includes/header.php'); ?>
    <div>
        <!--Filter for product category/region-->
        <div class="filter">
            <form method="GET" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>">
                <fieldset>
                    <legend>Category</legend>
                    <?php
                    include('../config/config.php');
                    
                    //Find all category available
                    $category_sql = "SELECT DISTINCT prod_region FROM product";
                    $category_result = mysqli_query($conn, $category_sql);

                    if (mysqli_num_rows($category_result) > 0){
                        while($category = mysqli_fetch_assoc($category_result)) {
                            //Store all available categories
                            $all_categories[] = $category['prod_region'];
                            //Store category checked
                            $checked = [];
                            if (isset($_GET['category'])){
                                $checked = $_GET['category'];
                            }

                            //Display each category
                            ?>
                            <div>
                                <input type="checkbox" name="category[]" id="category_<?=$category['prod_region']; ?>" 
                                value="<?= $category['prod_region']; ?>"
                                <?php if(in_array($category['prod_region'], $checked)) echo 'checked'; ?>>
                                <label for="category_<?=$category['prod_region']; ?>"> <?=$category['prod_region']; ?> </label>
                            </div>
                            <?php
                        }
                    } else {
                        echo "No brand found";
                    }

                    mysqli_close($conn);
                    ?>
                    <input type="submit" value="Apply">
                </fieldset>
            </form>
        </div>

        <!--Display products found-->
        <div class="TODO"> 
        <?php
            //Content
            include('../config/config.php');

            function test_input($data){
                return htmlspecialchars(stripslashes(trim($data)));
            }

            function display_product($row){
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

            //Search query and filter
            if ($_SERVER['REQUEST_METHOD'] === 'GET') {
                //For prepared statement
                $sql =  "SELECT * FROM `product` WHERE 1 ";
                $param_type = "";
                $params = [];

                //Category filter
                if (isset($_GET['category'])){
                    $categorychecks = [];
                    $categorychecks = $_GET['category'];

                    //Create a placeholder of ? for each category
                    $placeholders = implode(',', array_fill(0, count($categorychecks), '?')); 
                    $sql = "SELECT * FROM `product` WHERE `prod_region` IN ($placeholders)";
                    $param_type .= str_repeat('s', count($categorychecks));  //Add types for categories
                    $params = array_merge($params, $categorychecks);
                }

                //Search query
                if (isset($_GET['search_query']) && !empty($_GET['search_query'])){
                    //Add wildcard
                    $search_query = "%" . test_input($_GET['search_query']) . "%";
                    //Add to query
                    $sql .= "AND `prod_name` LIKE ?";
                    $param_type .= "s";
                    $params[] = $search_query;
                } 

                //Execute query
                if ((isset($_GET['search_query']) && !empty($_GET['search_query'])) || isset($_GET['category'])){
                    //Prepare and bind statement
                    $stmt = mysqli_prepare($conn, $sql);
                    mysqli_stmt_bind_param($stmt, $param_type, ...$params);

                    //Execute query
                    mysqli_stmt_execute($stmt);

                    //Get result
                    $result = mysqli_stmt_get_result($stmt);
                    if (mysqli_num_rows($result) > 0) {
                        echo '<div class="product-grid">';
                        while ($row = mysqli_fetch_assoc($result)) {
                            display_product($row);
                        }
                        echo '</div>';
                    } else {
                        echo '<h1 align="center">No products are found.</h1>';
                    }

                    mysqli_stmt_close($stmt);
                    mysqli_free_result($result);
                } else {
                    echo '<h1 align="center">No products are found.</h1>';
                }

                //Check if query is empty
                /*
                if (isset($_GET['search_query']) && !empty($_GET['search_query'])) {
                    //Add wildcard
                    $query = "%" . test_input($_GET['search_query']) . "%";

                    //Prepare and bind statement
                    $stmt = mysqli_prepare($conn, "SELECT * FROM `product` WHERE `prod_name` LIKE ?");
                    mysqli_stmt_bind_param($stmt, "s", $query);

                    //Execute query
                    mysqli_stmt_execute($stmt);

                    //Get result
                    $result = mysqli_stmt_get_result($stmt);

                    if (mysqli_num_rows($result) > 0) {
                        echo '<div class="product-grid">';
                        while ($row = mysqli_fetch_assoc($result)) {
                            display_product($row);
                        }
                        echo '</div>';
                    } else {
                        echo '<h1 align="center">No products are found.</h1>';
                    }

                    mysqli_stmt_close($stmt);
                    mysqli_free_result($result);
                }*/

            }

            mysqli_close($conn);

            ?>
        </div>
    </div>

    <?php include('../includes/footer.php'); ?>
</body>

</html>
