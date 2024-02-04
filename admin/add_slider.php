<?php
// Start the session
include('../db.php');
include("auth_check.php");

// Check if the form is submitted
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Process form data
    $slidertext = mysqli_real_escape_string($con, $_POST['slidertext']);
    $sliderheading = mysqli_real_escape_string($con, $_POST['sliderheading']);
    $sliderdesc = mysqli_real_escape_string($con, $_POST['sliderdescription']);

    // Insert into slider table
    $query = "INSERT INTO slider (slide_name, slide_heading, slide_text) 
              VALUES ('$slidertext', '$sliderheading', '$sliderdesc')";

    $result = mysqli_query($con, $query);

    // Check for errors in insertion
    if (!$result) {
        echo "Error: " . mysqli_error($con);
        exit;  // Exit the script if there's an error
    }

    // Get the auto-generated ID of the inserted record
    $lastInsertId = mysqli_insert_id($con);

    // Upload image if it exists
    if (isset($_FILES['sliderimage']) && !empty($_FILES['sliderimage']['name'])) {
        $uploadDirectory = '../img/';
        $fileName = $_FILES['sliderimage']['name'];
        $tmpName  = $_FILES['sliderimage']['tmp_name'];

        // Add slider ID to the image name
        $fileNameWithId = 'slider_' . $lastInsertId . '_' . $fileName;
        $uploadPath = $uploadDirectory . $fileNameWithId;

        // Move the uploaded file to the destination directory
        if (move_uploaded_file($tmpName, $uploadPath)) {
            // Update the slider table with the image URL
            $updateQuery = "UPDATE slider SET slide_image = '$fileNameWithId' WHERE slide_id = $lastInsertId";
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
    }

    // Success message and redirect
    echo "<script>
        Toastify({
            text: 'Slider added successfully!',
            duration: 3000,
            gravity: 'top',
            position: 'right',
            backgroundColor: '#65B741',
            close: true,
            onClick: function () {
                // Callback after click, you can redirect or perform additional actions here
            }
        }).showToast();
        </script>";

    // Redirect to product_stock.php after 3 seconds
    header("Refresh: 0; URL=slider.php");
    exit();
}
?>
