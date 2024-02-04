<?php
include('../db.php');

if (isset($_GET['product_id'])) {
    $productId = $_GET['product_id'];

    // Delete dependent records from product_variations table
    $deleteVariationsQuery = "DELETE FROM product_variations WHERE products_id = ?";
    $stmtVariations = mysqli_prepare($con, $deleteVariationsQuery);
    mysqli_stmt_bind_param($stmtVariations, "i", $productId);
    $resultVariations = mysqli_stmt_execute($stmtVariations);

    if ($resultVariations) {
        // Now, delete the product from the products table
        $deleteProductQuery = "DELETE FROM products WHERE products_id = ?";
        $stmtProduct = mysqli_prepare($con, $deleteProductQuery);
        mysqli_stmt_bind_param($stmtProduct, "i", $productId);
        $deleteResult = mysqli_stmt_execute($stmtProduct);

        if (!$deleteResult) {
            die("Delete query failed: " . mysqli_error($con));
        }

        session_start();
        $_SESSION['deletion_status'] = 'deleted';

        // Redirect back to the page after deletion
        header("Location: all-Products.php");
        exit();
    }

    // Check for errors in the delete query
    die("Delete variations query failed: " . mysqli_error($con));
} else {
    // Redirect to the page if product_id is not set
    header("Location: all-Products.php");
    exit();
}
?>
