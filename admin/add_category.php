<?php
include('../db.php');
include("auth_check.php");

// Check if the form is submitted
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $ct_title = mysqli_real_escape_string($con, $_POST['cat_title']);
    $ct_desc = mysqli_real_escape_string($con, $_POST['cat_desc']);

    // Insert into category table using prepared statement
    $query = "INSERT INTO category (cat_title, cat_desc) VALUES (?, ?)";
    $stmt = mysqli_prepare($con, $query);
    
    // Bind parameters and execute the statement
    mysqli_stmt_bind_param($stmt, "ss", $ct_title, $ct_desc);
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
}
?>
