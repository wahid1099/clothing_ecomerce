<?php
include('../db.php');

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Extract data from the POST request
    $productId = $_POST['updateProductId'];
    $productTitle = isset($_POST['updateProductTitle']) ? $_POST['updateProductTitle'] : '';
    $productPrice = isset($_POST['updateProductPrice']) ? $_POST['updateProductPrice'] : '';
    $productDesc = isset($_POST['updateProductdesc']) ? $_POST['updateProductdesc'] : '';
    $productKeywords = isset($_POST['updateProductkeyword']) ? $_POST['updateProductkeyword'] : '';
    // Extract more fields as needed

    // Handle file uploads
    $uploadDir = '../img/products/';

    $image1FileName = '';
    $image2FileName = '';

    // Check if new images are selected
    if (!empty($_FILES['updateImage1']['name'])) {
        $image1FileName = basename($_FILES['updateImage1']['name']);
        move_uploaded_file($_FILES['updateImage1']['tmp_name'], $uploadDir . $image1FileName);

        // Delete the previous image
        $getImage1Query = "SELECT product_img1 FROM products WHERE products_id = $productId";
        $resultImage1 = mysqli_query($con, $getImage1Query);
        $rowImage1 = mysqli_fetch_assoc($resultImage1);
        $previousImage1 = $rowImage1['product_img1'];

        if ($previousImage1 != '') {
            unlink($uploadDir . $previousImage1);
        }
    }

    if (!empty($_FILES['updateImage2']['name'])) {
        $image2FileName = basename($_FILES['updateImage2']['name']);
        move_uploaded_file($_FILES['updateImage2']['tmp_name'], $uploadDir . $image2FileName);

        // Delete the previous image
        $getImage2Query = "SELECT product_img2 FROM products WHERE products_id = $productId";
        $resultImage2 = mysqli_query($con, $getImage2Query);
        $rowImage2 = mysqli_fetch_assoc($resultImage2);
        $previousImage2 = $rowImage2['product_img2'];

        if ($previousImage2 != '') {
            unlink($uploadDir . $previousImage2);
        }
    }

    // Update the product data in the database
    $query = "UPDATE products SET 
        product_title = '$productTitle',
        product_price = '$productPrice',
        product_desc = '$productDesc',
        product_keywords = '$productKeywords'";

    // Append image fields only if new images are selected
    if ($image1FileName != '') {
        $query .= ", product_img1 = '$image1FileName'";
    }

    if ($image2FileName != '') {
        $query .= ", product_img2 = '$image2FileName'";
    }

    $query .= " WHERE products_id = $productId";

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
