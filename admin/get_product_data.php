<?php
include('../db.php');

if (isset($_GET['productId'])) {
    $productId = $_GET['productId'];

    // Fetch product data based on the ID
    $query = "SELECT * FROM products WHERE products_id = $productId";
    $result = mysqli_query($con, $query);

    if ($row = mysqli_fetch_assoc($result)) {
        // Return product data as JSON
        echo json_encode($row);
    } else {
        // Handle the case when no data is found or there's an error
        echo json_encode(['error' => 'Product not found or query error']);
    }
}

mysqli_close($con);
?>
