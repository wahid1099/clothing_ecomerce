<?php
include('../db.php');

// Check if it's a POST request
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Extract data from the POST request and sanitize
    $catId = isset($_POST['updateCategory']) ? mysqli_real_escape_string($con, $_POST['updateCategory']) : '';
    $subcatId = isset($_POST['updatesubCatId']) ? mysqli_real_escape_string($con, $_POST['updatesubCatId']) : '';
    $subcatTitle = isset($_POST['updatesubcattitle']) ? mysqli_real_escape_string($con, $_POST['updatesubcattitle']) : '';
    $subcatDesc = isset($_POST['updatesubctgdesc']) ? mysqli_real_escape_string($con, $_POST['updatesubctgdesc']) : '';

    // Check if the catId is provided and not empty
    if (!empty($catId)) {
        // Prepare and bind the update statement
        $query = "UPDATE product_categories SET p_cat_title = ?, p_cat_desc = ?, cat_id = ? WHERE p_cat_id = ?";
        $stmt = mysqli_prepare($con, $query);

        if ($stmt) {
            mysqli_stmt_bind_param($stmt, 'ssii', $subcatTitle, $subcatDesc, $catId, $subcatId);
            // Execute the statement
            $result = mysqli_stmt_execute($stmt);

            if ($result) {
                // Return a success response
                $response = array('status' => 'success', 'message' => 'Sub-Category updated successfully');
            } else {
                // Return an error response
                $response = array('status' => 'error', 'message' => 'Failed to update Sub-Category');
            }
            // Close the statement
            mysqli_stmt_close($stmt);
        } else {
            // Handle statement preparation error
            $response = array('status' => 'error', 'message' => 'Error preparing statement');
        }
    } else {
        // Return an error response if catId is empty
        $response = array('status' => 'error', 'message' => 'Category ID is required');
    }
} else {
    // Return an error response for non-POST requests
    $response = array('status' => 'error', 'message' => 'Invalid request method');
}

// Set the Content-Type header to JSON
header('Content-Type: application/json');

// Return the response as JSON
echo json_encode($response);

// Close the connection
mysqli_close($con);
?>
