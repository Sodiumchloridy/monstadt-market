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
    include ('../includes/header.php');

    //Content
    include ('../config/config.php');

    function test_input($data){
        return htmlspecialchars(stripslashes(trim($data)));
    }

    //Search query
    if($_SERVER['REQUEST_METHOD'] === 'GET') {
        //Check if query is empty
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
                while ($row = mysqli_fetch_assoc($result)) {
                    echo "Product Name: " . $row['prod_name'] . "<br>";
                }
            } else {
                echo "No products are found";
            }

            mysqli_stmt_close($stmt);
            mysqli_free_result($result);
        }
    }

    mysqli_close($conn);

    include ('../includes/footer.php');
    ?>
</body>
</html>