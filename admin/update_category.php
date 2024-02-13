<?php
include('../db.php');

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Extract data from the POST request and sanitize
    $catId = isset($_POST['updateCatId']) ? mysqli_real_escape_string($con, $_POST['updateCatId']) : '';
    $catTitle = isset($_POST['updatecattitle']) ? mysqli_real_escape_string($con, $_POST['updatecattitle']) : '';
    $catDesc = isset($_POST['updatedesc']) ? mysqli_real_escape_string($con, $_POST['updatedesc']) : '';

    // Check if the catId is provided and not empty
    if (!empty($catId)) {
        // Prepare and bind the update statement
        $query = "UPDATE category SET cat_title = ?, cat_desc = ? WHERE cat_id = ?";
        $stmt = mysqli_prepare($con, $query);
        mysqli_stmt_bind_param($stmt, 'ssi', $catTitle, $catDesc, $catId);

        // Execute the statement
        $result = mysqli_stmt_execute($stmt);

        if ($result) {
            // Return a success response
            $response = array('status' => 'success', 'message' => 'Category updated successfully');
            echo json_encode($response);
        } else {
            // Return an error response
            $response = array('status' => 'error', 'message' => 'Failed to update category');
            echo json_encode($response);
        }

        // Close the statement
        mysqli_stmt_close($stmt);
    } else {
        // Return an error response if catId is empty
        $response = array('status' => 'error', 'message' => 'Category ID is required');
        echo json_encode($response);
    }
}

// Close the connection
mysqli_close($con);
?>
