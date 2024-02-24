<?php
 // Start the session
include('../db.php');
include("auth_check.php");

// Fetch all products from the database
$query = "SELECT * FROM category ORDER BY cat_id DESC";

$result = mysqli_query($con, $query);



// Check for errors in the query
if (!$result) {
    die("Query failed: " . mysqli_error($con));
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>All Category</title>
    <link rel="stylesheet" href="inclueds/sidebar.css">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css">
    <!-- toast -->
    <link rel="stylesheet" type="text/css" href="https://cdn.jsdelivr.net/npm/toastify-js/src/toastify.min.css">


</head>

<body>


<!--ADD Modal -->
<div class="modal fade" id="addcategoryModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Add Category</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form method="post" action="add_category.php" enctype="multipart/form-data">
    
                    <div class="form-group">
                        <label for="cat_title">Category Title:</label>
                        <input type="text" class="form-control" id="cat_title" name="cat_title" required>
                    </div>
                    <div class="form-group">
                        <label for="cat_desc">Category Description:</label>
                        <input type="text" class="form-control" id="cat_desc" name="cat_desc" required>
                    </div>

                    <div class="form-group">
                        <label for="image">Category Image:</label>
                        <input type="file" class="form-control-file" id="image" name="image" accept="image/*" required>
                    </div>
                    
                    
                    <!-- End of your form content -->
                    <button type="submit" class="btn btn-primary">ADD CATEGORY</button>
                </form>
            </div>
        </div>
    </div>
</div>
<!--ADD Modal -->



<div class="row">
  
        <div class="col-lg-2">
        <?php include 'inclueds/sidebar.php'; ?>
        </div>
        <div class="col-lg-12" id="main">
        <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#addcategoryModal">
    Add Category
</button>
        
        <h1>All Category</h1>
        <table class="table table-striped table-bordered">
    <thead>
        <tr>
            <th scope="col">Category ID</th>
            <th scope="col">Category Name</th>
            <th scope="col">Category Description</th>
            <th scope="col">Category Image</th>
            <th scope="col">Action</th>
           
          
        </tr>
    </thead>
    <tbody>
        <?php
        // Fetch orders from the database
        // $query = "SELECT * FROM orders";
        // $result = mysqli_query($con, $query);

        // Loop through the orders and display them in the table
        while ($row = mysqli_fetch_assoc($result)) {
            $imagePath = '../img/' . $row['image_url'];

            
            echo '<tr>';
            echo '<td>' . $row['cat_id'] . '</td>';
            echo '<td>' . $row['cat_title'] . '</td>';
            echo '<td>' . $row['cat_desc'] . '</td>';
            echo '<td><img src="' . $imagePath . '" alt="Category Image" style="max-width: 100px;"></td>';
            echo '<td>';
            echo '<button type="button" class="btn btn-danger " data-toggle="modal" data-target="#deletecategoryModal' . $row['cat_id'] . '">Delete</button>
            <button type="button" class="btn btn-warning" style="margin: 10px;"  onclick="openupdateCategoryModal(' . $row['cat_id'] . ')"  data-toggle="modal" data-target="#updateCategoryModal">Update</button>';
                // Add more buttons or actions as needed
                echo '</td>';
                include('update_modal.php'); // Create a separate PHP file for the update modal

                include('delete_modal.php'); // Create a separate PHP file for the delete modal

            echo '</tr>';
        }


        // Free the result set
        mysqli_free_result($result);
        ?>
    </tbody>
</table>


</div>


<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/js/bootstrap.min.js"></script>
    <script src="tinymce/tinymce.min.js"></script>
    <script>
        tinymce.init({
            selector: 'textarea'
        });
    </script>
    <!-- toast -->
    <script type="text/javascript" src="https://cdn.jsdelivr.net/npm/toastify-js"></script>
   


<script>

// Your JavaScript function for confirming and deleting the category
function confirmcatDelete(cat_id) {
    console.log("Confirm", cat_id)
    $.ajax({
        type: 'GET',
        url: 'delete_category.php',
        data: { cat_id: cat_id },
        success: function (data) {
            if (data.status === 'success') {
                showToast('Deleted Successfully');
                setTimeout(function () {
                    location.reload(true); // Reload the page with a hard refresh
                }, 1000);
            } else {
                showToast(data.message);
            }
        },
        error: function (error) {
            console.error('Error deleting category:', error);
            showToast('Error deleting category');
        }
    });
}


function showToast(message) {
    Toastify({
                text: message,
                duration: 3000,
                newWindow: true,
                close: true,
                gravity: 'top', // `top` or `bottom`
                position: 'right', // `left`, `center` or `right`
                backgroundColor: '#65B741', // Green color for success
                onClick: function () {
                    // Callback after click, you can redirect or perform additional actions here
                }
            }).showToast();
    }
</script>
<script src="./inclueds/category.js"></script>

</body>

</html>
