<?php
include('../db.php');
include("auth_check.php");
?>


<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Panel</title>
    <link rel="stylesheet" href="inclueds/sidebar.css">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css">
    <link rel="stylesheet" type="text/css" href="https://cdn.jsdelivr.net/npm/toastify-js/src/toastify.min.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/gh/habibmhamadi/multi-select-tag@2.0.1/dist/css/multi-select-tag.css">
    <style>
        .top {
            font-size: 28px;
            background-color: #e6e6e6;
            text-align: center;
            padding: 8px 0;
            margin-bottom: 20px;
            box-shadow: 0 -20px 15px -10px rgba(155, 155, 155, 0.3) inset,
                0 20px 15px -10px rgba(155, 155, 155, 0.3) inset,
                0 0 10px rgba(0, 0, 0, 0.1);
        }
    </style>


</head>

<body>

    <div class="row">
   
        <div class="col-lg-12">
            <div class="top">
                <i class="fa fa-dashboard fa-fw">
                </i> Dashboard
            </div>
        </div>
    </div>

    <div class="row">
    <div class="col-lg-3">
    <?php include 'inclueds/sidebar.php'; ?>
    </div>
        <div class="col-lg-9">
            <div class="panel panel-default">
                <div class="panel-heading">
                    <h3 class="panel-title">
                        <i class="fa fa-money fa-fw"></i> Insert Products
                    </h3>
                </div>

                <div class="panel-body">
                    <form method="post" class="form-horizontal" enctype="multipart/form-data">

                        <div class="form-group">
                            <label class="col-md-3 control-label">Product Title/Name</label>

                            <div class="col-md-6">
                                <input type="text" class="form-control" name="product_title" required>
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-md-3 control-label">Category</label>

                            <div class="col-md-6">
                                <select class="form-control" name="cat_id">

                                    <option>Select a Category</option>

                                    <?php

                                    $get_category = "select * from category";
                                    $run_category = mysqli_query($con, $get_category);

                                    while ($cat_row = mysqli_fetch_array($run_category)) {

                                        $cat_id = $cat_row['cat_id'];
                                        $cat_title = $cat_row['cat_title'];

                                        echo "
                                        
                                        <option value='$cat_id'>$cat_title</option>  
                                        
                                    
                                        ";
                                    }

                                    ?>

                                </select>
                            </div>
                        </div>


                        <div class="form-group">
                            <label class="col-md-3 control-label">Subcategory Category</label>

                            <div class="col-md-6">
                                <select class="form-control" name="p_cat_id">

                                    <option>Select a Subcategory Category</option>

                                    <?php

                                    $get_p_category = "select * from product_categories";
                                    $run_p_category = mysqli_query($con, $get_p_category);

                                    while ($p_cat_row = mysqli_fetch_array($run_p_category)) {

                                        $p_cat_id = $p_cat_row['p_cat_id'];
                                        $p_cat_title = $p_cat_row['p_cat_title'];

                                        echo "
                                        
                                        <option value='$p_cat_id'>$p_cat_title</option>  
                                        
                                    
                                        ";
                                    }

                                    ?>

                                </select>
                            </div>
                        </div>

                        
                        <div class="form-group">
                            <label class="col-md-3 control-label">Product Image # 1</label>

                            <div class="col-md-6">
                                <input type="file" class="form-control" name="product_img1" required>
                            </div>
                        </div>

                        <div class="form-group">
                            <label class="col-md-3 control-label">Product Image # 2</label>

                            <div class="col-md-6">
                                <input type="file" class="form-control" name="product_img2" required>
                            </div>
                        </div>

                        <div class="form-group">
                            <label class="col-md-3 control-label">Product Price</label>

                            <div class="col-md-6">
                                <input type="text" class="form-control" name="product_price" required>
                            </div>
                        </div>

                        <div class="form-group">
                            <label class="col-md-3 control-label">Product Keywords</label>

                            <div class="col-md-6">
                                <input type="text" class="form-control" name="product_keywords" required>
                            </div>
                        </div>

                        <div class="form-group">
                            <label class="col-md-3 control-label">Product Code</label>

                            <div class="col-md-6">
                                <input type="text" class="form-control" name="product_Code" required>
                            </div>
                        </div>

                        <div class="form-group">
                            <label class="col-md-3 control-label">Discount Percentage</label>

                            <div class="col-md-6">
                                <input type="text" class="form-control" name="discount_percent" required>
                            </div>
                        </div>


                        <div class="form-group">
                            <label class="col-md-3 control-label">Product Color</label>

                            <div class="col-md-6">
                                <input type="text" class="form-control" name="product_colors" required>
                            </div>
                        </div>

                        <div class="form-group">
                            <label class="col-md-3 control-label">Stock Quantity</label>

                            <div class="col-md-6">
                                <input type="text" class="form-control" name="product_stock" required>
                            </div>
                        </div>

                        <div class="form-group">
                            <label for="sizes" class="col-md-3 control-label">Size:
                                
                            </label>
                            <div class="col-md-6">
                            <select class="form-control" id="sizes" name="sizes[]" multiple required>
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
                            
                        </div>

                        <div class="form-group">
                            <label class="col-md-3 control-label">Product Description</label>

                            <div class="col-md-6">
                                <textarea class="form-control" name="product_desc" cols="19" rows="6"></textarea>
                            </div>
                        </div>

                        <div class="form-group" style="display: flex;justify-content:center">
                            <div class="col-md-3">
                                <input name="submit" type="submit" class="btn btn-primary form-control" value="Insert Product">
                            </div>
                        </div>

                    </form>


                </div>
            </div>
        </div>
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
     <script src="https://cdn.jsdelivr.net/gh/habibmhamadi/multi-select-tag@2.0.1/dist/js/multi-select-tag.js"></script>
     <script>
    new MultiSelectTag('sizes')  // id
</script>
</body>

</html>

<?php

if (isset($_POST['submit'])) {

    $p_cat_id = $_POST['p_cat_id'];
    $cat_id = $_POST['cat_id'];
    $product_title = $_POST['product_title'];
    $product_img1 = $_FILES['product_img1']['name'];
    $product_img2 = $_FILES['product_img2']['name'];
    $product_price = $_POST['product_price'];
    $product_keywords = $_POST['product_keywords'];
    $product_desc = $_POST['product_desc'];
    $product_code = $_POST['product_Code'];
    $product_color = $_POST['product_colors'];
    
    $product_size = implode(',', $_POST['sizes']);
  
    $product_stock_qty = $_POST['product_stock'];
    $discount_percent = $_POST['discount_percent'];

    $uploadDirectory = '../img/products/';

    // Create the directory if it doesn't exist
    if (!is_dir($uploadDirectory)) {
        mkdir($uploadDirectory, 0755, true);
    }

    $product_img1 = $product_code . '_' . $product_img1;
    $product_img2 = $product_code . '_' . $product_img2;

    $temp_name1 = $_FILES['product_img1']['tmp_name'];
    $temp_name2 = $_FILES['product_img2']['tmp_name'];

    // Move the uploaded files
    move_uploaded_file($temp_name1, $uploadDirectory . $product_img1);
    move_uploaded_file($temp_name2, $uploadDirectory . $product_img2);

    // Prepare main product insertion statement
    $insert_product = "INSERT INTO products (p_cat_id, cat_id, date, product_title, product_img1, product_img2, product_price, product_keywords, product_desc, product_code, discount_percentage) VALUES (?, ?, NOW(), ?, ?, ?, ?, ?, ?, ?, ?)";
    $stmt = mysqli_prepare($con, $insert_product);
    
    if ($stmt) {
        mysqli_stmt_bind_param($stmt, "iisssssssd", $p_cat_id, $cat_id, $product_title, $product_img1, $product_img2, $product_price, $product_keywords, $product_desc, $product_code, $discount_percent);
    
        $result = mysqli_stmt_execute($stmt);
    
        if ($result) {
            $product_id = mysqli_insert_id($con);
        
            // Prepare product variations insertion statement
            $insert_variations = "INSERT INTO product_variations (products_id, color, size, stock_quantity, image_url) VALUES (?, ?, ?, ?, ?)";
            $stmt_variations = mysqli_prepare($con, $insert_variations);
            
            if ($stmt_variations) {
                mysqli_stmt_bind_param($stmt_variations, "issss", $product_id, $product_color, $product_size, $product_stock_qty, $product_img1);
                
                $result_variations = mysqli_stmt_execute($stmt_variations);
                
                if ($result_variations) {
                    // Product variations inserted successfully
                    
                    // Show Toastify notification for success
                    echo "<script>
                        Toastify({
                            text: 'Product Inserted with Variations',
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

                        event.preventDefault();

                        // Redirect to 'insert-product.php' after 2 seconds
                        setTimeout(function () {
                            window.open('insert-product.php', '_self');
                        }, 1000);
                    </script>";
                } else {
                    // Handle insertion failure
                    echo "Error: " . mysqli_error($con);
                }
                
                mysqli_stmt_close($stmt_variations);
            } else {
                // Handle prepared statement creation failure
                echo "Error: " . mysqli_error($con);
            }
        } else {
            // Handle insertion failure
            echo "Error: " . mysqli_error($con);
        }
        
        mysqli_stmt_close($stmt);
    } else {
        // Handle prepared statement creation failure
        echo "Error: " . mysqli_error($con);
    }
}
?>
