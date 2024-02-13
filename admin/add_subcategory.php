<?php
include('../db.php');
include("auth_check.php");

if (isset($_POST['submit'])) {
    // Sanitize input
    $cat_id = mysqli_real_escape_string($con, $_POST['cat_id']);
    $p_cat_title = mysqli_real_escape_string($con, $_POST['p_cat_title']);
    $p_cat_desc = mysqli_real_escape_string($con, $_POST['p_cat_desc']);

    // Prepare the insert statement
    $query = "INSERT INTO product_categories (cat_id, p_cat_title, p_cat_desc) VALUES (?, ?, ?)";
    $stmt = mysqli_prepare($con, $query);

    if (!$stmt) {
        echo "Error: " . mysqli_error($con);
        exit;
    }

    // Bind parameters and execute the statement
    mysqli_stmt_bind_param($stmt, 'iss', $cat_id, $p_cat_title, $p_cat_desc);
    $result = mysqli_stmt_execute($stmt);

    if (!$result) {
        echo "Error: " . mysqli_error($con);
        exit;  // Exit the script if there's an error
    }

    // Close the statement
    mysqli_stmt_close($stmt);

    // Success message and redirect
    echo "<script>
        Toastify({
            text: 'Sub-Category added successfully!',
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
    header("Refresh: 0; URL=productctg.php");
    exit();
}
?>
