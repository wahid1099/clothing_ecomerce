<?php
include('../db.php');

if (isset($_GET['productId'])) {
    $productId = $_GET['productId'];

    // Fetch product data and corresponding category data
    $query = "SELECT p.*, c.cat_title, pc.p_cat_title 
              FROM products p 
              LEFT JOIN category c ON p.cat_id = c.cat_id 
              LEFT JOIN product_categories pc ON p.p_cat_id = pc.p_cat_id
              WHERE p.products_id = $productId";
    $result = mysqli_query($con, $query);

    if ($row = mysqli_fetch_assoc($result)) {
        // Fetch category data for the product
      //  $categoryId = $row['cat_id'];

        $allCategoriesQuery = "SELECT * FROM category";
        $allCategoriesResult = mysqli_query($con, $allCategoriesQuery);
        $allCategories = mysqli_fetch_all($allCategoriesResult, MYSQLI_ASSOC);


         // Fetch product categories
         $productCategoriesQuery = "SELECT * FROM product_categories";
         $productCategoriesResult = mysqli_query($con, $productCategoriesQuery);
         $productCategories = mysqli_fetch_all($productCategoriesResult, MYSQLI_ASSOC);
 

        // Include category data in the response
        $row['categories'] = $allCategories;
        $row['productCategories'] = $productCategories;


        // Return product data and category data as JSON
        echo json_encode($row);
    } else {
        // Handle the case when no data is found or there's an error
        echo json_encode(['error' => 'Product not found or query error']);
    }
}

mysqli_close($con);
?>
