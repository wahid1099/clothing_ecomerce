<?php
 // Start the session
include('../db.php');
include("auth_check.php");

// Fetch all products from the database
$query = "SELECT pv.*, p.product_title, p.product_code FROM product_variations pv
          JOIN products p ON pv.products_id = p.products_id
          ORDER BY pv.variation_id DESC";
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
    <title>Product stock</title>
    <link rel="stylesheet" href="inclueds/sidebar.css">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css">
    <!-- toast -->
    <link rel="stylesheet" type="text/css" href="https://cdn.jsdelivr.net/npm/toastify-js/src/toastify.min.css">
    <!-- datatable -->
    <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/1.13.7/css/jquery.dataTables.min.css">

   

</head>

<body>

<!-- Modal -->
<div class="modal fade" id="addVariationModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Add Product Variation</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form method="post" action="add_variation.php" enctype="multipart/form-data">
                    <!-- Your form content goes here -->
                    <div class="form-group">
                        <label for="product_id">Product ID:</label>
                        <select class="form-control" id="product_id" name="product_id" required>
                            <?php
                            // Fetch product IDs from the database
                            $productQuery = "SELECT products_id, product_title,  product_code FROM products";
                            $productResult = mysqli_query($con, $productQuery);

                            while ($productRow = mysqli_fetch_assoc($productResult)) {
                                echo '<option value="' . $productRow['products_id'] . '">' . $productRow['products_id'] . ' - ' . $productRow['product_title'] . ' - ' . $productRow['product_code'] . '</option>';

                            }

                            // Free the result set
                            mysqli_free_result($productResult);
                            ?>
                        </select>
                    </div>
                   
                        <div class="form-group">
                            <label for="size">Size:</label>
                            <select class="form-control" id="size" name="size" required>
                                <option value="S">S</option>
                                <option value="M">M</option>
                                <option value="L">L</option>
                                <option value="XL">XL</option>
                                <option value="XXL">XXL</option>
                                <option value="XXXL">XXXL</option>
                                <option value="28">28</option>
                                <option value="30">30</option>
                                <option value="32">32</option>
                                <option value="34">34</option>
                                <option value="36">36</option>
                                <option value="38">38</option>
                                <option value="40">40</option>
                                <option value="42">42</option>
                            </select>
                        </div>

                    <div class="form-group">
                        <label for="color">Color:</label>
                        <input type="text" class="form-control" id="color" name="color" required>
                    </div>
                    <div class="form-group">
                        <label for="stock_quantity">Stock Quantity:</label>
                        <input type="number" class="form-control" id="stock_quantity" name="stock_quantity" required>
                    </div>
                    <div class="form-group">
                        <label for="image">Product Image:</label>
                        <input type="file" class="form-control-file" id="image" name="image" accept="image/*" required>
                    </div>
                    <!-- End of your form content -->
                    <button type="submit" class="btn btn-primary">Add Variation</button>
                </form>
            </div>
        </div>
    </div>
</div>
<!-- Modal -->


<div class="row">
  
        <div class="col-lg-2">
        <?php include 'inclueds/sidebar.php'; ?>
        </div>
        <div class="col-lg-12" id="main">
        <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#addVariationModal">
    Add Product Variation
</button>
        
        <h1>Product Stock And variations</h1>
        <table id="productTable" class="table table-striped table-bordered">
    <thead>
        <tr>
            <th scope="col">Prodcut  ID</th>
            <th scope="col">Prodcut Name</th>
            <th scope="col">Prodcut Code</th>
            <th scope="col">size</th>
            <th scope="col">color</th>
            <th scope="col">Stock</th>
            <th scope="col">Image</th>
            <th scope="col">Actions</th>
            
        </tr>
    </thead>
    <tbody>
        <?php
       
        // Loop through the orders and display them in the table
        while ($row = mysqli_fetch_assoc($result)) {
            $imagePath = '../img/products/' . $row['image_url'];

            
            echo '<tr>';
            echo '<td>' . $row['products_id'] . '</td>';
            echo '<td>' . $row['product_title'] . '</td>';
            echo '<td>' . $row['product_code'] . '</td>';
            
            echo '<td>' . $row['size'] . '</td>';
            echo '<td>' . $row['color'] . '</td>';
            echo '<td>' . $row['stock_quantity'] . '</td>';
            echo '<td><img src="' . $imagePath . '" alt="Product Image" style="max-width: 100px;"></td>';

            echo '<td>'; 
            echo '<button type="button" class="btn btn-warning" style="margin: 10px;"  onclick="openStockUpdateModal(' . $row['variation_id'] . ')"  data-toggle="modal" data-target="#updateStockModal">Update</button>';

            echo '<button type="button" class="btn btn-danger " data-toggle="modal" data-target="#deleteModal' . $row['variation_id'] . '">Delete</button>';
            echo '</td>';

            // Include modals for Update and Delete
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
        <!-- jQuery -->
        <script type="text/javascript" charset="utf8" src="https://code.jquery.com/jquery-3.5.1.js"></script>

    <!-- DataTables JS -->
    <script type="text/javascript" charset="utf8" src="https://cdn.datatables.net/1.13.7/js/jquery.dataTables.min.js"></script>
    <script>
    $(document).ready(function() {
        $('#productTable').DataTable({
            "destroy": true 
        }
            
        );
    });

    function confirmDelete(variationId) {
    $.ajax({
        type: 'GET',
        url: 'delete_variation.php',
        data: { delete_variation: variationId },
        success: function (data) {
            if (data.status === 'success') {
                showToast(data.message);
               
               // location.reload(true); // Reload the page with a hard refresh
                setTimeout(function () {
                    location.reload(true); // Reload the page with a hard refresh
                }, 1000);
            } else {
                showToast(data.message);
            }
        },
        error: function (error) {
            console.error('Error deleting product variation:', error);
            showToast('Error deleting product variation');
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

<script src="./inclueds/stock_data.js"></script>

</body>

</html>
