<?php

$active = "Product";
include("db.php");
include("functions.php");
include('header.php');
?>
<div style="overflow: hidden;">
    <!-- Breadcrumb Section Begin -->
    <div class="breacrumb-section">
        <div class="container">
            <div class="row">
                <div class="col-lg-12">
                    <div class="breadcrumb-text product-more">
                        <a href="index.php"><i class="fa fa-home"></i> Home</a>
                        <a href="shop.php">Shop</a>
                        <span>Details</span>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- Breadcrumb Section Begin -->

    <!-- Product Shop Section Begin -->
    <section class="product-shop spad page-details">
        <div class="container">
            <div class="row">
                <div class="col-lg-3">
                    <div class="filter-widget">
                        <h4 class="fw-title">Categories</h4>
                        <ul class="filter-catagories">
                            <?php

                            getCat();

                            ?>
                        </ul>
                    </div>
                </div>
                <div class="col-lg-9">
                    <div class="row">
                        <?php

                        getProd();
                        addCart();

                        ?>



                            <form action='product.php?add_cart=<?php if (isset($_GET['product_id'])) {
                                $product_id = $_GET['product_id'];
                                echo $product_id;
                            } ?>' method='post' id="productForm">



                                                       

                            <div class="form-group">
                                <!-- form-group Begin -->
                                <div class='quantity'>
                                    <div class='pro-qty'>
                                        <input type='text' value='1' name="product_qty">
                                    </div>
                                </div>
                            </div><!-- form-group Finish -->

                                                    <div class='col-lg-12 mb-3'>
                                <div class='dropdown-container' style='display:flex; justify-content:space-between;'>
                                    <div>
                                        <h4>Select Color:</h4>
                                        <select name="color" id='colorDropdown' onchange='updateSizes()'>
                                            <option value=''>-- Select Color --</option>
                                            <?php
                                            $variationsArray = getVariationsArray($product_id);

                                            // Loop through the array of variations to display color options
                                            foreach ($variationsArray as $variation) {
                                                $color = $variation['color'];
                                                // Display color options
                                                echo "<option value='$color'>$color</option>";
                                            }
                                            ?>
                                        </select>
                                    </div>

                                    <div id="sizeDropdownContainer">
                                        <h4>Select Size:</h4>
                                        <select name="size" id='sizeDropdown'>
                                            <option value=''>-- Select Size --</option>
                                            <!-- Sizes will be dynamically populated based on user selection -->
                                        </select>
                                    </div>
                                </div>
                            </div>
                            <input type="hidden" name="selected_size" id="selectedSize" value=""> 
                                <p id="msg"></p>
                            </div><!-- form-group Finish -->
                            <input type="hidden" name="action" id="action" value="add_to_cart"> <!-- Default action is add to cart -->

                            
                                                <?php
                            // Check if all variants are out of stock
                            $allVariantsOutOfStock = areAllVariantsOutOfStock($product_id);
                            ?>


                            <?php
                             
                    if ($allVariantsOutOfStock) {
                       
                        echo "<button class='btn btn-warning ' style='margin-top: 20px; margin-right:10px;' disabled>Out of Stock</button>";
                        echo "<button class='btn btn-warning' style='margin-top: 20px;' disabled>Out of Stock</button>";
                    } else {
                        echo "<button class='btn primary-btn pd-cart' id='cartbtn' style='margin-top: 20px; margin-right:10px;'> কার্ট অ্যাড করুন</button>";
                        echo "<button class='btn primary-btn' id='buy_now' name='buy_now' style='margin-top: 20px;'> অর্ডার করুন</button>";
                    }
                    ?>
                        </form>

                    </div>
                </div>
            </div>
        </div>
</div>

</section>


<div class="related-products spad">
    <div class="container">
        <div class="row">
            <div class="col-lg-12">
                <div class="section-title">
                    <h2>More like this</h2>
                </div>
            </div>
        </div>

        <div class="row">

            <?php

            relatedProducts();
            ?>

        </div>
    </div>
</div>
</div>

<?php
include('footer.php');
?>

<script>
   

   $("#cartbtn, #buy_now").on('click', function(event) {
    var selectedColor = $("#colorDropdown").val();
    var selectedSize = $("#sizeDropdown").val();

    if (!selectedSize || !selectedColor) {
        updateMessage("Please choose both color and size.", "alert-danger");
        event.preventDefault(); // Prevent the form submission
    } else {
        updateMessage("Product added to the cart successfully!", "alert-success");
    }
});

function updateMessage(message, alertClass) {
    // Update the message in your HTML element (e.g., a div with an id 'msg')
    $("#msg").html(message);

    // Optionally, you can add or remove a CSS class for styling
    $("#msg").removeClass().addClass("alert " + alertClass);

    // You may also want to hide the message after a certain time
    setTimeout(function() {
        $("#msg").html("");
    }, 5000); // 5000 milliseconds (5 seconds)
}



    document.getElementById('productForm').addEventListener('submit', function (event) {
        var actionInput = document.getElementById('action');
       
        if (event.submitter && event.submitter.name === 'buy_now') {
            actionInput.value = 'buy_now';
        } else {
            actionInput.value = 'add_to_cart';
        }
    });


   
</script>

</body>

</html>