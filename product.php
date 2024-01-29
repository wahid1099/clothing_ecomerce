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

                            <div class="form-group">
                                <!-- form-group Begin -->
                                <div class='pd-size-choose'>
                                    <div class='sc-item'>
                                        <input type='radio' id='sm-size' class="form-control" name='size' value="Small" required novalidate>
                                        <label for='sm-size'>s</label>
                                    </div>
                                    <div class='sc-item'>
                                        <input type='radio' id='md-size' class="form-control" name='size' value="Medium">
                                        <label for='md-size'>m</label>
                                    </div>
                                    <div class='sc-item'>
                                        <input type='radio' id='lg-size' class="form-control" name='size' value="Large">
                                        <label for='lg-size'>l</label>
                                    </div>
                                    <div class='sc-item'>
                                        <input type='radio' id='xl-size' class="form-control" name='size' value="XL">
                                        <label for='xl-size'>xl</label>
                                    </div>
                                </div>
                                <p id="msg"></p>
                            </div><!-- form-group Finish -->
                            <input type="hidden" name="action" id="action" value="add_to_cart"> <!-- Default action is add to cart -->

                            <button class='btn primary-btn pd-cart' id='cartbtn' style='margin-top: 20px;'> কার্ট অ্যাড করুন</button>
                            <button class='btn primary-btn ' id='buy_now' name='buy_now' style='margin-top: 20px;'> অর্ডার করুন
</button>
                         
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
    // $("#cartbtn").on('click', function() {
    //     var atLeastOneChecked = false;
    //     if (!$("input[name='size']").is(':checked')) {

    //         $("#msg").html(
    //             "<span class='alert alert-danger'>" +
    //             "Please Choose Size </span>");
    //     } else {
    //         $("#msg").html("<span class='alert alert-success'>Product added to the cart successfully!</span>");

    //         return;
    //     }

    // });

    // $("#buy_now").on('click', function() {
    //     var atLeastOneChecked = false;
    //     if (!$("input[name='size']").is(':checked')) {

    //         $("#msg").html(
    //             "<span class='alert alert-danger'>" +
    //             "Please Choose Size </span>");
    //     } else {
           

    //         return;
    //     }

    // });

    function updateMessage(message, type) {
    $("#msg").html("<span class='alert " + type + "'>" + message + "</span>");
}

$("#cartbtn, #buy_now").on('click', function() {
    if (!$("input[name='size']").is(':checked')) {
        updateMessage("Please Choose Size", "alert-danger");
    } else {
        updateMessage("Product added to the cart successfully!", "alert-success");
    }
});


    document.getElementById('productForm').addEventListener('submit', function (event) {
        var actionInput = document.getElementById('action');
        console.log("Button clicked");

        if (event.submitter && event.submitter.name === 'buy_now') {
            actionInput.value = 'buy_now';
        } else {
            actionInput.value = 'add_to_cart';
        }
    });

</script>

</body>

</html>