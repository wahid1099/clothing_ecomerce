<?php
include('../db.php');

// Check if cat_id is provided via GET request
if(isset($_GET['p_cat_id'])) {
    // Sanitize the input
    $subcatId = mysqli_real_escape_string($con, $_GET['p_cat_id']);

    // Delete the category from the database
    $query = "DELETE FROM product_categories WHERE p_cat_id = '$subcatId'";
    $result = mysqli_query($con, $query);

    // Check for errors in deletion
    if (!$result) {
        $response = array('status' => 'error', 'message' => 'Error deleting sub category: ' . mysqli_error($con));
    } else {
        // Return success response
        $response = array('status' => 'success', 'message' => 'Sub-Category deleted successfully');
    }
} else {
    // Return error response if cat_id is not provided
    $response = array('status' => 'error', 'message' => 'Category ID is required');
}

// Send JSON response
header('Content-Type: application/json');
echo json_encode($response);
?>
