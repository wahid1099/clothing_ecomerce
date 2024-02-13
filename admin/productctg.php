<?php
 // Start the session
include('../db.php');
include("auth_check.php");

// Fetch all products from the database
$query = "SELECT pc.*, c.cat_title 
          FROM product_categories pc
          INNER JOIN category c ON pc.cat_id = c.cat_id
          ORDER BY pc.p_cat_id DESC";

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
    <title>All Sub-Category</title>
    <link rel="stylesheet" href="inclueds/sidebar.css">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css">
    <!-- toast -->
    <link rel="stylesheet" type="text/css" href="https://cdn.jsdelivr.net/npm/toastify-js/src/toastify.min.css">


</head>

<body>



<!--ADD Modal -->
<!--ADD Modal -->
<div class="modal fade" id="addsubcategoryModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Add Sub-Category</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form method="post" action="add_subcategory.php">
                    <div class="form-group">
                        <label for="cat_id" class="col-md-3 control-label">Category:</label>
                        <select class="form-control" name="cat_id">
                            <option>Select a Category</option>
                            <?php
                            $get_category = "SELECT * FROM category";
                            $run_category = mysqli_query($con, $get_category);
                            while ($cat_row = mysqli_fetch_array($run_category)) {
                                $cat_id = $cat_row['cat_id'];
                                $cat_title = $cat_row['cat_title'];
                                echo "<option value='$cat_id'>$cat_title</option>";
                            }
                            ?>
                        </select>
                    </div>
                    <div class="form-group">
                        <label for="p_cat_title">Sub-Category Title:</label>
                        <input type="text" class="form-control" id="p_cat_title" name="p_cat_title" required>
                    </div>
                    <div class="form-group">
                        <label for="p_cat_desc">Sub-Category Description:</label>
                        <input type="text" class="form-control" id="p_cat_desc" name="p_cat_desc" required>
                    </div>
                    <button type="submit" class="btn btn-primary" name="submit">ADD SUB-CATEGORY</button>
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
        <h1>All Sub-Category</h1>
        <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#addsubcategoryModal">
    Add Sub-Category
</button>
        <table class="table table-striped table-bordered">
    <thead>
        <tr>
            <th scope="col"> Sub-Category ID</th>
            <th scope="col"> Sub-Category Name</th>
            <th scope="col"> Sub-Category Description</th>
            <th scope="col"> Category</th>
            <th scope="col"> Action</th>
           
          
        </tr>
    </thead>
    <tbody>
        <?php
        // Fetch orders from the database
        // $query = "SELECT * FROM orders";
        // $result = mysqli_query($con, $query);

        // Loop through the orders and display them in the table
        while ($row = mysqli_fetch_assoc($result)) {
            
            echo '<tr>';
            echo '<td>' . $row['p_cat_id'] . '</td>';
            echo '<td>' . $row['p_cat_title'] . '</td>';
            echo '<td>' . $row['p_cat_desc'] . '</td>';
            echo '<td>' . $row['cat_title'] . '</td>';
            echo '<td>';
            echo '<button type="button" class="btn btn-danger " data-toggle="modal" data-target="#deletesubcategoryModal' . $row['p_cat_id'] . '">Delete</button>
            <button type="button" class="btn btn-warning" style="margin: 10px;"  onclick="openupdatesubCategoryModal(' . $row['p_cat_id'] . ')"  data-toggle="modal" data-target="#updatesubCategoryModal">Update</button>';
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
   
    <script src="./inclueds/subCategory.js"></script>

<script>
function confirmsubcatDelete(p_cat_id) {
   // console.log("Confirm", cat_id)
    $.ajax({
        type: 'GET',
        url: 'delete_subctg.php',
        data: { p_cat_id: p_cat_id },
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
            console.error('Error deleting sub-category:', error);
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
</body>

</html>


