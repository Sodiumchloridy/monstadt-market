<?php

include("../config/config.php");

if (isset($_GET['search_query'])) {
    $searchTerm = $_GET['search_query'] . "%";
    $query = "SELECT prod_name FROM Product WHERE prod_name LIKE ? LIMIT 10";
    $stmt = mysqli_prepare($conn, $query);
    mysqli_stmt_bind_param($stmt, "s", $searchTerm);
    mysqli_stmt_execute($stmt);
    mysqli_stmt_bind_result($stmt, $productName);
    
    $suggestions = [];
    while (mysqli_stmt_fetch($stmt)) {
        $suggestions[] = $productName;
    }
    
    mysqli_stmt_close($stmt);
    mysqli_close($conn);
    
    header('Content-Type: application/json');
    echo json_encode($suggestions);

}
?>
