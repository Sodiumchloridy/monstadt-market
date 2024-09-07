<?php session_start(); ?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title> Mondstadt Market </title>

    <link rel="stylesheet" href="../styles/styles.css">
    <link rel="stylesheet" href="search.css">
    <script defer src="validation.js"></script>
</head>

<body>
    <?php include('../includes/header.php'); ?>

    <main class="search-main">
        <!--Filter for product category/region-->
        <div class="filter">
            <form id="filter-form" method="GET" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>">
                <!--Input for category filter-->
                <fieldset class="category-filter">
                    <legend>Category</legend>
                    <?php
                    include('../config/config.php');

                    //Find all category available
                    $category_sql = "SELECT DISTINCT prod_region FROM product";
                    $category_result = mysqli_query($conn, $category_sql);

                    if (mysqli_num_rows($category_result) > 0) {
                        while ($category = mysqli_fetch_assoc($category_result)) {
                            //Store all available categories
                            $all_categories[] = $category['prod_region'];
                            //Store category checked
                            $checked = [];
                            if (isset($_GET['category'])) {
                                $checked = isset($_GET['category']) ? (array) $_GET['category'] : [];
                            }

                            //Display each category
                    ?>
                            <div>
                                <input type="checkbox" name="category[]" id="category_<?= $category['prod_region']; ?>"
                                    value="<?= $category['prod_region']; ?>"
                                    <?php if (in_array($category['prod_region'], $checked)) echo 'checked'; ?>>
                                <label for="category_<?= $category['prod_region']; ?>"> <?= $category['prod_region']; ?> </label>
                            </div>
                    <?php
                        }
                    } else {
                        echo "No category is found";
                    }

                    mysqli_close($conn);
                    ?>
                </fieldset>

                <!--Input for min pirce and max price-->
                <fieldset class="price-filter">
                    <legend>Price</legend>
                    <input name="min" id="min" placeholder="Min" type="number" min="0" class="filter-price-input" pattern="[0-9]*"
                        value="<?= (isset($_GET['min']) && !empty($_GET['min'])) ? htmlspecialchars($_GET['min'], ENT_QUOTES, 'UTF-8') : '' ?>">
                    <input name="max" id="max" placeholder="Max" type="number" min="0" class="filter-price-input" pattern="[0-9]*"
                        value="<?= (isset($_GET['max']) && !empty($_GET['max'])) ? htmlspecialchars($_GET['max'], ENT_QUOTES, 'UTF-8') : '' ?>">
                    <input id="price-filter-button" type="submit" value="Apply">
                    <div id="price-filter-error" class="error"></div>
                </fieldset>
                <!--Hidden input field to store search query-->
                <?php if (isset($_GET['search_query'])): ?>
                    <input type="hidden" name="search_query" value="<?php echo htmlspecialchars($_GET['search_query']); ?>">
                <?php endif; ?>
            </form>
        </div>

        <!--Display products found-->
        <div class="products-display">
            <?php
            include('../config/config.php');

            function test_input($data)
            {
                return htmlspecialchars(stripslashes(trim($data)));
            }

            function display_product($row)
            {
                $imgFileName = htmlspecialchars($row['prod_img_name'], ENT_QUOTES, 'UTF-8');
                $prodName = htmlspecialchars($row['prod_name'], ENT_QUOTES, 'UTF-8');

                // Output the image
                echo '<a href="../product?id=' . $row['prod_id'] . '">';
                echo '<div class="product">';
                echo '<img src="../images/' . $imgFileName . '" alt="' . $prodName . '"/>';
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
                if (isset($_GET['category'])) {
                    $categorychecks = [];
                    $categorychecks = isset($_GET['category']) ? (array) $_GET['category'] : [];

                    //Create a placeholder of ? for each category
                    $placeholders = implode(',', array_fill(0, count($categorychecks), '?'));
                    $sql .= " AND `prod_region` IN ($placeholders) ";
                    $param_type .= str_repeat('s', count($categorychecks));  //Add "s" for each categories
                    $params = array_merge($params, $categorychecks);
                }

                //Search query
                if (isset($_GET['search_query']) && !empty($_GET['search_query'])) {
                    //Add wildcard
                    $search_query = "%" . test_input($_GET['search_query']) . "%";
                    //Add to query
                    $sql .= "AND `prod_name` LIKE ?";
                    $param_type .= "s";
                    $params[] = $search_query;
                }

                //Min price filter
                if (isset($_GET['min']) && !empty($_GET['min'])) {
                    $sql .= " AND `prod_price` >= ?";
                    $param_type .= "d";
                    $params[] = (float) $_GET['min'];
                }

                //Max price filter
                if (isset($_GET['max']) && !empty($_GET['max'])) {
                    $sql .= " AND `prod_price` <= ?";
                    $param_type .= "d";
                    $params[] = (float) $_GET['max'];
                }

                //Execute query
                if (!empty($params)) {
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
            }

            mysqli_close($conn);

            ?>
        </div>
    </main>
    <?php include('../includes/footer.php'); ?>
</body>

</html>