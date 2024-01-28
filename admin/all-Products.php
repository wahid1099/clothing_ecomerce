<?php
// Start the session
include('../db.php');
include("auth_check.php");
// Fetch all products from the database
// $query = "SELECT * FROM products";
// $result = mysqli_query($con, $query);

$query = "SELECT p.*, pc.p_cat_title AS  product_categories, c.cat_title AS category_title  FROM products p 
          INNER JOIN  product_categories pc ON p.p_cat_id = pc.p_cat_id 
          INNER JOIN category c ON p.cat_id = c.cat_id";

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
    <title>All Products</title>
    <link rel="stylesheet" href="inclueds/sidebar.css">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css">
    <!-- toast -->
    <link rel="stylesheet" type="text/css" href="https://cdn.jsdelivr.net/npm/toastify-js/src/toastify.min.css">

    <!-- datatables -->
    <link rel="stylesheet" href="https://cdn.datatables.net/1.13.7/css/jquery.dataTables.css" />

</head>

<body>

<!-- Bootstrap Update Modal -->
<div class="modal fade" id="updateModal" tabindex="-1" role="dialog" aria-labelledby="updateModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="updateModalLabel">Update Product Data</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <!-- Update form goes here -->
                <form id="updateForm">
                    <!-- Add form fields for each attribute (e.g., product_title, product_price, etc.) -->
                    <div class="form-group">
                        <label for="updateProductTitle">Product Title</label>
                        <input type="text" class="form-control" id="updateProductTitle" name="updateProductTitle" required>
                    </div>

                    <div class="form-group">
                        <label for="updateProductPrice">Product Price</label>
                        <input type="text" class="form-control" id="updateProductPrice" name="updateProductPrice" required>
                    </div>
                     <!-- Image 1 -->
                     <div class="form-group">
                        <label for="updateImage1">Product Image 1: </label>
                        <img id="updateImage1Preview" src="" alt="Product Image" style="max-width: 100px;">
                        <input type="file" class="form-control-file" id="updateImage1" name="updateImage1">
                    </div>

                    <!-- Image 2 -->
                    <div class="form-group">
                        <label for="updateImage2">Product Image 2: </label>
                        <img id="updateImage2Preview" src="" alt="Product Image" style="max-width: 100px;">
                        <input type="file" class="form-control-file" id="updateImage2" name="updateImage2">
                    </div>
                    <div class="form-group">
                   
                        <label for="updateProductdesc">Product Description</label>
                        <div id="updateProductdesc" class="form-control" contenteditable="true" style="height: 100px; overflow-y: auto;"></div>
                    </div>


                    <div class="form-group">
                        <label for="updateProductkeyword">Product Keyword</label>
                        <input type="text" class="form-control" id="updateProductkeyword" name="updateProductkeyword" required>
                    </div>
                    <!-- Add more form fields as needed -->

                    <input type="hidden" id="updateProductId" name="updateProductId">

                    <button type="button" class="btn btn-primary" onclick="submitUpdateForm()">Update</button>
                </form>
            </div>
        </div>
    </div>
</div>
<!-- Bootstrap Update Modal -->



<!-- Bootstrap Delete Confirmation Modal -->
<div class="modal fade" id="deleteConfirmationModal" tabindex="-1" role="dialog" aria-labelledby="deleteConfirmationModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="deleteConfirmationModalLabel">Delete Confirmation</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                Are you sure you want to delete this product?
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">No</button>
                <button type="button" class="btn btn-danger" id="confirmDeleteButton">Yes</button>
            </div>
        </div>
    </div>
</div>
  <!-- Bootstrap Delete Confirmation Modal -->

    <div class="row">
        <div class="col-lg-2">
        <?php include 'inclueds/sidebar.php'; ?>
        </div>
        <div class="col-lg-12" id="main">
    <h2>All Products</h2>
    <table class="table table-striped table-bordered">
        <thead>
            <tr>
                <th scope="col">Id</th>
                <th scope="col">Product Title</th>
                <th scope="col">Product Price</th>
                <th scope="col">Product Image1</th>
                <th scope="col">Product Image2</th>
                <th scope="col">Product Category</th>
                <th scope="col">Category</th>
                <th scope="col">Product Description</th>
                <th scope="col">Product Keyword</th>
                <th scope="col">Date</th>
                <th scope="col">Action</th>

               
                <!-- Add more table headers as needed -->
            </tr>
        </thead>
        <tbody>
 
            <?php
            // Counter for numbering rows
            $counter = 1;

            // Loop through the products and display them in the table
            while ($row = mysqli_fetch_assoc($result)) {
                echo '<tr>';
               
               
                echo '<td>' . $row['products_id'] . '</td>';
                echo '<td>' . $row['product_title'] . '</td>';
                echo '<td>' . $row['product_price'] . ' Tk</td>';
                 // Concatenate the folder path with the image name
                 $imagePath1 = '../img/products/' . $row['product_img1'];
                 $imagePath2 = '../img/products/' . $row['product_img2'];
                
                 // Display the image
                 echo '<td><img src="' . $imagePath1 . '" alt="Product Image" style="max-width: 100px;"></td>';
                 echo '<td><img src="' . $imagePath2 . '" alt="Product Image" style="max-width: 100px;"></td>';
                 

                 echo "<td>{$row['product_categories']}</td>";
                 echo "<td>{$row['category_title']}</td>";

                echo '<td>' . $row['product_desc'] . '</td>';
                echo '<td>' . $row['product_keywords'] . '</td>';
                echo '<td>' . $row['date'] . '</td>';
                echo '<td>';
                echo '<button  type="button" class="btn btn-danger" onclick="confirmDelete(' . $row['products_id'] . ')" data-toggle="modal" data-target="#deleteConfirmationModal">Delete</button>
                 <button type="button" class="btn btn-warning" onclick="openUpdateModal(' . $row['products_id'] . ')">Update</button>';
                // Add more buttons or actions as needed
                echo '</td>';


               
                // Add more table cells as needed
                echo '</tr>';

                // Increment the counter
                $counter++;
            }

            // Free the result set
            mysqli_free_result($result);

            // Close the database connection
            mysqli_close($con);
            ?>
        </tbody>
    </table>
</div>


    </div>
    
     <!-- datatable -->
     <script src="https://cdn.datatables.net/1.13.7/js/jquery.dataTables.js"></script>
     <!-- datatable -->

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
   $(document).ready(function () {
    // Check if the "deleted" session variable is set
    var isProductDeleted = <?php echo isset($_SESSION['deletion_status']) ? 'true' : 'false'; ?>;
    
    // Clear the session variable to ensure the Toast is shown only once
    <?php unset($_SESSION['deletion_status']); ?>

    // Show the Toastify notification if the product has been deleted
    if (isProductDeleted) {
        Toastify({
            text: "Product is deleted successfully",
            duration: 3000,
            newWindow: true,
            close: true,
            gravity: "top", // `top` or `bottom`
            position: "right", // `left`, `center` or `right`
            backgroundColor: "#FF004D", // Red color for deletion
            onClick: function () {
                // Callback after click, you can redirect or perform additional actions here
            }
        }).showToast();
    }
});


</script>
<script src="./inclueds/allproduc.js"></script>

</body>

</html>
