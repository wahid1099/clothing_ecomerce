<?php
include('../db.php');
include("auth_check.php");

// Check if the form is submitted
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $ct_title = mysqli_real_escape_string($con, $_POST['cat_title']);
    $ct_desc = mysqli_real_escape_string($con, $_POST['cat_desc']);

    // Check if file is uploaded successfully
    if ($_FILES['image']['error'] === UPLOAD_ERR_OK) {
        $tmpFilePath = $_FILES['image']['tmp_name'];
        $filename = uniqid() . '_' . $_FILES['image']['name']; // Generate a unique filename
        $uploadDirectory = '../img/' . $filename;

        // Move uploaded file to the desired directory
        if (move_uploaded_file($tmpFilePath, $uploadDirectory)) {
            // Insert into category table using prepared statement
            $query = "INSERT INTO category (cat_title, cat_desc, image_url) VALUES (?, ?, ?)";
            $stmt = mysqli_prepare($con, $query);

            // Bind parameters and execute the statement
            mysqli_stmt_bind_param($stmt, "sss", $ct_title, $ct_desc, $filename);
            $result = mysqli_stmt_execute($stmt);

            // Check for errors in insertion
            if (!$result) {
                echo "Error: " . mysqli_error($con);
                exit;  // Exit the script if there's an error
            }

            // Close the statement
            mysqli_stmt_close($stmt);

            // Success message and redirect
            echo "<script>
                Toastify({
                    text: 'Category added successfully!',
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

            // Redirect to allcategories.php after 3 seconds
            header("Refresh: 0; URL=allcategories.php");
            exit();
        } else {
            // Error handling if file upload fails
            echo "Error uploading file.";
            exit;
        }
    } else {
        // Error handling if file upload encountered an error
        echo "Error: " . $_FILES['image']['error'];
        exit;
    }
}
?>
