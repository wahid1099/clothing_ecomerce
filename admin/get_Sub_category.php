<?php
include('../db.php');

if (isset($_GET['p_cat_id'])) {
    $subcatid = $_GET['p_cat_id'];

    // Fetch product data based on the ID
    $query = "SELECT * FROM product_categories WHERE p_cat_id = $subcatid";
    $result = mysqli_query($con, $query);

    

    if ($row = mysqli_fetch_assoc($result)) {
        $allCategoriesQuery = "SELECT * FROM category";
        $allCategoriesResult = mysqli_query($con, $allCategoriesQuery);
        $allCategories = mysqli_fetch_all($allCategoriesResult, MYSQLI_ASSOC);
        $row['categories'] = $allCategories;

        // Return product data as JSON
        echo json_encode($row);
    } else {
        // Handle the case when no data is found or there's an error
        echo json_encode(['error' => 'Product not found or query error']);
    }
}

mysqli_close($con);
?>
