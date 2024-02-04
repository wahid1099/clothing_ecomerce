<?php
include('../db.php');

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    
    $sliderId = $_POST['updateSliderId'];
    $slidertitle = isset($_POST['updatesliderTitle']) ? $_POST['updatesliderTitle'] : '';
    $sliderHeading = isset($_POST['updatesliderheading']) ? $_POST['updatesliderheading'] : '';
    $slidertext = isset($_POST['updatesliderdescr']) ? $_POST['updatesliderdescr'] : '';
  
    $uploadDir = '../img/';

    $image1FileName = '';
  

    // Check if new images are selected
    if (!empty($_FILES['updatesliderImage']['name'])) {
        $image1FileName = basename($_FILES['updatesliderImage']['name']);
        move_uploaded_file($_FILES['updatesliderImage']['tmp_name'], $uploadDir . $image1FileName);

        // Delete the previous image
        $getImage1Query = "SELECT slide_image FROM slider WHERE slide_id  = $sliderId";
        $resultImage1 = mysqli_query($con, $getImage1Query);
        $rowImage1 = mysqli_fetch_assoc($resultImage1);
        $previousImage1 = $rowImage1['slide_image'];

        if ($previousImage1 != '') {
            unlink($uploadDir . $previousImage1);
        }
    }

    

    // Update the product data in the database
    $query = "UPDATE slider SET 
        slide_name = '$slidertitle',
        slide_heading	 = '$sliderHeading',
        slide_text = '$slidertext'";

    // Append image fields only if new images are selected
    if ($image1FileName != '') {
        $query .= ", slide_image = '$image1FileName'";
    }

    $query .= " WHERE slide_id = $sliderId";

    $result = mysqli_query($con, $query);

    if ($result) {
        // Return a success message or handle it as needed
        echo 'Slider updated successfully';
    } else {
        // Handle the update error
        echo 'Failed to Slider product';
    }
}

mysqli_close($con);
?>
