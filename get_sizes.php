<?php
include('db.php');

if (isset($_GET['product_id']) && isset($_GET['color'])) {
    $product_id = mysqli_real_escape_string($con, $_GET['product_id']);
    $color = mysqli_real_escape_string($con, $_GET['color']);

    // Continue with your database queries...
    $get_sizes_query = "SELECT DISTINCT size FROM product_variations WHERE products_id='$product_id' AND color='$color'";
    $run_sizes_query = mysqli_query($con, $get_sizes_query);

    if ($run_sizes_query) {
        $sizes = array();
        while ($row = mysqli_fetch_assoc($run_sizes_query)) {
            $sizes[] = $row['size'];
        }

        // Return sizes in JSON format
        echo json_encode($sizes);
    } else {
        // Handle database query error
        echo json_encode(array("error" => "Database query error"));
    }
} else {
    // Handle the case where parameters are not provided
    echo json_encode(array("error" => "Invalid parameters"));
}
?>
