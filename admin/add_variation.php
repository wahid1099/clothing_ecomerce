<?php
// Start the session
include('../db.php');
include("auth_check.php");

// Check if the form is submitted
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Process form data
    $product_id = mysqli_real_escape_string($con, $_POST['product_id']);
    $size = mysqli_real_escape_string($con, $_POST['size']);
    $color = mysqli_real_escape_string($con, $_POST['color']);
    $stock_quantity = mysqli_real_escape_string($con, $_POST['stock_quantity']);

    // Insert into product_variations table
    $query = "INSERT INTO product_variations (products_id, size, color, stock_quantity) 
              VALUES ('$product_id', '$size', '$color', '$stock_quantity')";

    $result = mysqli_query($con, $query);

    // Check for errors in insertion
    if (!$result) {
        echo "Error: " . mysqli_error($con);
        exit;  // Exit the script if there's an error
    }

    // Get the last inserted variation id
    $variation_id = mysqli_insert_id($con);

    // Upload image if it exists
    if (isset($_FILES['image']) && !empty($_FILES['image']['name'])) {
        $uploadDirectory = '../img/products/';
        $fileName = $_FILES['image']['name'];
        $tmpName  = $_FILES['image']['tmp_name'];

        // Check if a file is selected and the upload is successful
        if (is_uploaded_file($tmpName)) {
            // Add variation id to the image name
            $fileNameWithId = $variation_id . '_' . $fileName;
            $uploadPath = $uploadDirectory . $fileNameWithId;

            // Move the uploaded file to the destination directory
            if (move_uploaded_file($tmpName, $uploadPath)) {
                // Update the product_variations table with the image URL
                $updateQuery = "UPDATE product_variations SET image_url = '$fileNameWithId' WHERE variation_id = $variation_id";
                $updateResult = mysqli_query($con, $updateQuery);

                // Check for errors in updating the image URL
                if (!$updateResult) {
                    echo "Error updating image URL: " . mysqli_error($con);
                    exit;  // Exit the script if there's an error
                }
            } else {
                echo "Error uploading file.";
                exit;  // Exit the script if there's an error
            }
        } else {
            echo "Error: Invalid file.";
            exit;  // Exit the script if there's an error
        }
    }

    // Success message and redirect
   // Success message and redirect
echo "<script>
Toastify({
    text: 'Product variation added successfully!',
    duration: 3000,
    gravity: 'top',
    position: 'right',
    backgroundColor: '#65B741',
    close: true,
    onClick: function () {
        // Callback after click, you can redirect or perform additional actions here
    }
}).showToast();
// setTimeout(function () {
     // window.location.href = 'product_stock.php';
//     window.location.href = './product_stock.php';

// }, 3000);


</script>";
// Success message and redirect
header("Refresh: 0; URL=product_stock.php"); // Redirect to product_stock.php after 3 seconds
exit();
}
?>
