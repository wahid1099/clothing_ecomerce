<?php
include('../db.php');

if (isset($_GET['slide_id'])) {
    $slideId = $_GET['slide_id'];

    // Perform the delete query for the slider
    $deleteSliderQuery = "DELETE FROM slider WHERE slide_id = $slideId";
    $deleteSliderResult = mysqli_query($con, $deleteSliderQuery);

    // Check if the delete query was successful
    if ($deleteSliderResult) {
       
        // Redirect back to the page after deletion
        header("Location: slider.php");
        exit();
    } else {
        // Check for errors in the delete query
        die("Delete slider query failed: " . mysqli_error($con));
    }
} else {
    // Redirect to the page if slide_id is not set
    header("Location: slider.php");
    exit();
}
?>
