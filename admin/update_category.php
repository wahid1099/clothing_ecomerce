<?php
include('../db.php');

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Extract data from the POST request and sanitize
    $catId = isset($_POST['updateCatId']) ? mysqli_real_escape_string($con, $_POST['updateCatId']) : '';
    $catTitle = isset($_POST['updatecattitle']) ? mysqli_real_escape_string($con, $_POST['updatecattitle']) : '';
    $catDesc = isset($_POST['updatedesc']) ? mysqli_real_escape_string($con, $_POST['updatedesc']) : '';

    // Check if the catId is provided and not empty
    if (!empty($catId)) {
        // Check if a new image file is uploaded
        if ($_FILES['updatecategoryimage']['error'] === UPLOAD_ERR_OK) {
            // Handle file upload
            $tmpFilePath = $_FILES['updatecategoryimage']['tmp_name'];
            $filename = uniqid() . '_' . $_FILES['updatecategoryimage']['name']; // Generate a unique filename
            $uploadDirectory = '../img/' . $filename;

            // Move uploaded file to the desired directory
            if (move_uploaded_file($tmpFilePath, $uploadDirectory)) {
                // Update category information along with the new image URL
                $query = "UPDATE category SET cat_title = ?, cat_desc = ?, image_url = ? WHERE cat_id = ?";
                $stmt = mysqli_prepare($con, $query);
                mysqli_stmt_bind_param($stmt, 'sssi', $catTitle, $catDesc, $filename, $catId);
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
                // Return an error response if file upload fails
                $response = array('status' => 'error', 'message' => 'Error uploading image file');
                echo json_encode($response);
            }
        } else {
            // If no new image file is uploaded, update category information without updating the image URL
            $query = "UPDATE category SET cat_title = ?, cat_desc = ? WHERE cat_id = ?";
            $stmt = mysqli_prepare($con, $query);
            mysqli_stmt_bind_param($stmt, 'ssi', $catTitle, $catDesc, $catId);
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
        }
    } else {
        // Return an error response if catId is empty
        $response = array('status' => 'error', 'message' => 'Category ID is required');
        echo json_encode($response);
    }
}

// Close the connection
mysqli_close($con);
?>
