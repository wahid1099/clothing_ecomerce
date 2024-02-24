<?php
include('../db.php');

// Check if cat_id is provided via GET request
if(isset($_GET['cat_id'])) {
    // Sanitize the input
    $catId = mysqli_real_escape_string($con, $_GET['cat_id']);

    // Fetch the image URL associated with the category
    $query = "SELECT image_url FROM category WHERE cat_id = '$catId'";
    $result = mysqli_query($con, $query);

    if ($result && mysqli_num_rows($result) > 0) {
        $row = mysqli_fetch_assoc($result);
        $imageUrl = $row['image_url'];

        // Delete the image file from the server
        $imagePath = '../img/' . $imageUrl;
        if (file_exists($imagePath)) {
            unlink($imagePath); // Delete the image file
        }

        // Delete the category from the database
        $deleteQuery = "DELETE FROM category WHERE cat_id = '$catId'";
        $deleteResult = mysqli_query($con, $deleteQuery);

        // Check for errors in deletion
        if ($deleteResult) {
            // Return success response
            $response = array('status' => 'success', 'message' => 'Category and associated image deleted successfully');
        } else {
            // Return error response if deletion fails
            $response = array('status' => 'error', 'message' => 'Error deleting category: ' . mysqli_error($con));
        }
    } else {
        // Return error response if category not found
        $response = array('status' => 'error', 'message' => 'Category not found');
    }
} else {
    // Return error response if cat_id is not provided
    $response = array('status' => 'error', 'message' => 'Category ID is required');
}

// Send JSON response
header('Content-Type: application/json');
echo json_encode($response);
?>
