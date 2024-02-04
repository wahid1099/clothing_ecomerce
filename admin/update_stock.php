<?php
include('../db.php');

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Extract data from the POST request
    $variationId = $_POST['updateVariationId'];
    $stockSize = isset($_POST['updateSize']) ? $_POST['updateSize'] : '';
    $stockcolor = isset($_POST['updateColor']) ? $_POST['updateColor'] : '';
    $stockqnty = isset($_POST['updateStockQuantity']) ? $_POST['updateStockQuantity'] : '';

    // Handle file uploads
    $uploadDir = '../img/products/';
    $imageFileName = '';

    // Check if new images are selected
    if (!empty($_FILES['updateImage']['name'])) {
        // Create a unique file name by appending the variationId
        $imageFileName = $variationId . '_' . basename($_FILES['updateImage']['name']);
        move_uploaded_file($_FILES['updateImage']['tmp_name'], $uploadDir . $imageFileName);

        // Delete the previous image
        $getImage1Query = "SELECT image_url FROM product_variations WHERE variation_id = $variationId";
        $resultImage1 = mysqli_query($con, $getImage1Query);
        $rowImage1 = mysqli_fetch_assoc($resultImage1);
        $previousImage1 = $rowImage1['image_url'];

        if ($previousImage1 != '') {
            unlink($uploadDir . $previousImage1);
        }
    }

    // Update query
    $query = "UPDATE product_variations SET 
        size = '$stockSize',
        color = '$stockcolor',  
        stock_quantity = '$stockqnty'";

    // Append image fields only if new images are selected
    if ($imageFileName != '') {
        $query .= ", 	image_url = '$imageFileName'";
    }

    $query .= " WHERE variation_id = $variationId";

    $result = mysqli_query($con, $query);

    if ($result) {
        // Return a success message or handle it as needed
        echo 'Product updated successfully';
    } else {
        // Handle the update error
        echo 'Failed to update product';
    }
}

mysqli_close($con);
?>
