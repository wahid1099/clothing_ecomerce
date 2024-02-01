<?php
include('../db.php');

if ($_SERVER["REQUEST_METHOD"] == "GET" && isset($_GET['delete_variation'])) {
    $variationId = $_GET['delete_variation'];

    // Retrieve image file path
    $getImagePathQuery = "SELECT image_url FROM product_variations WHERE variation_id = $variationId";
    $imageResult = mysqli_query($con, $getImagePathQuery);

    if ($imageResult && $imageRow = mysqli_fetch_assoc($imageResult)) {
        $imagePath = '../img/products/' . $imageRow['image_url'];

        // Perform the deletion query
        $deleteQuery = "DELETE FROM product_variations WHERE variation_id = $variationId";
        $deleteResult = mysqli_query($con, $deleteQuery);

        if ($deleteResult) {
            // Deletion successful
            // Delete the associated image file
            if (file_exists($imagePath)) {
                unlink($imagePath);
            }

            $response = array('status' => 'success', 'message' => 'Product variation deleted successfully');
        } else {
            // Deletion failed
            $response = array('status' => 'error', 'message' => 'Error deleting product variation');
        }
    } else {
        // Unable to retrieve image path
        $response = array('status' => 'error', 'message' => 'Error retrieving image path');
    }

    // Send JSON response
    header('Content-Type: application/json');
    echo json_encode($response);
}
?>
