<?php
include('../db.php');

// Check if the product_id is set in the query parameters
if (isset($_GET['product_id'])) {
    $productId = $_GET['product_id'];

    // Perform the delete operation
    $deleteQuery = "DELETE FROM products WHERE products_id = $productId";
    $deleteResult = mysqli_query($con, $deleteQuery);

    // Check for errors in the delete query
    if (!$deleteResult) {
        die("Delete query failed: " . mysqli_error($con));
    }

    // Set a session variable to indicate that deletion has occurred
    session_start();
    $_SESSION['deletion_status'] = 'deleted';

    // Redirect back to the page after deletion
    header("Location: all-Products.php");
    exit();
} else {
    // Redirect to the page if product_id is not set
    header("Location: all-Products.php");
    exit();
}
?>
