<?php



$active = "Home";
include("functions.php");
include("header.php");

?>

<section class="hero-section">
    <div class="hero-items owl-carousel">

    <?php

$get_slides = "SELECT * FROM slider";
$run_slider = mysqli_query($con, $get_slides);

while ($row_slides = mysqli_fetch_array($run_slider)) {
    $slide_name = $row_slides['slide_name'];
    $slide_image = $row_slides['slide_image'];
    $slide_heading = $row_slides['slide_heading'];
    $slide_text = $row_slides['slide_text'];

    echo "
        <div class='single-hero-items set-bg' data-setbg='img/$slide_image'>
            <div class='container'>
                <div class='row'>
                    <div class='col-lg-5'>
                        <h1>$slide_heading</h1>
                        <p>$slide_text</p>
                        <a href='shop.php' class='primary-btn'>Shop Now</a>
                    </div>
                </div>
                <div class='off-card'>
                <h2>Up to <span>60%</span></h2>
            </div>  
            </div>
        </div>
    ";
}

?>


    </div>
</section>




<!-- category -->

<!-- Categories Section Begin -->
<div class="categories-section ">
<h3 class="text-center pt-4 pb-5 ">All Categories</h3>
    <div class="container">
        <div class="row justify-content-center">
            <?php
            // Query to fetch all categories
            $query = "SELECT * FROM category";
            $result = mysqli_query($con, $query);

            // Loop through each category
            while ($row = mysqli_fetch_assoc($result)) {
                $catId = $row['cat_id'];
                $catTitle = $row['cat_title'];
                $catImage = $row['image_url'];

                // Generate HTML markup for each category
                echo "<div class='col-md-4 col-sm-6 col-lg-2 mb-4'>
                        <div class='category-item text-center'>
                            <a href='shop.php?cat_id=$catId'>
                                <img src='./img/$catImage' alt='$catTitle' class='rounded-circle mb-2' style='max-width: 150px; height: 150px;'>
                                <h6 class'mb-1'>$catTitle</h6>
                            </a>
                        </div>
                    </div>";
            }
            ?>
        </div>
    </div>
        </div>
<!-- Categories Section End -->

   
<!-- category -->


<!-- Banner Section Begin -->

<div class="banner-section spad">
    <div class="container-fluid">
        <div class="row">
            <div class="col-lg-4">
                <a href='shop.php?cat_id=1'>
                    <div class="single-banner">
                        <img src="img/mens-jeans.jpg" alt="Mens">
                        <div class="inner-text">
                            <h4>Jean's</h4>
                        </div>
                    </div>
                </a>
            </div>
            <div class="col-lg-4">
                <a href='shop.php?cat_id=15'>
                    <div class="single-banner">
                        <img src="img/panjabi-short.jpg" alt="" style="width:100%; height:303px;">
                        <div class="inner-text">
                            <h4>Panjabis</h4>
                        </div>
                    </div>
                </a>

            </div>
            <div class="col-lg-4">
                <a href='shop.php?cat_id=2'>
                    <div class="single-banner">
                        <img src="img/t-shirts.jpg" alt="" style="width:100%; height:303px;">
                        <div class="inner-text">
                            <h4>T-shirt's</h4>
                        </div>
                    </div>
                </a>
            </div>
        </div>
    </div>
</div>


<!-- Women Banner Section Begin -->

<section class="women-banner spad">
    <div class="container-fluid">
        <div class="row">
            <div class="col-lg-3">
                <div class="product-large set-bg" data-setbg="img/panjabi.jpg">
                    <h2>Panjabis</h2>
                    <a href="shop.php?p_cat_id=1">Discover More</a>
                </div>
            </div>
            <div class="col-lg-8 offset-lg-1">
                <div class="filter-control">
                    <h3> Hot Products </h3>
                </div>
                <div class="product-slider owl-carousel">

                    <?php
                    getWProduct();
                    ?>
                </div>
            </div>
        </div>
    </div>
</section>


<!-- Man Banner Section Begin -->

<section class="man-banner spad">
    <div class="container-fluid">
        <div class="row">
            <div class="col-lg-8">
                <div class="filter-control">
                    <h3> Hot Products </h3>
                </div>
                <div class="product-slider owl-carousel">
                    <?php
                    getMProduct();
                    ?>

                </div>
            </div>
            <div class="col-lg-3 offset-lg-1">
                <div class="product-large set-bg m-large" data-setbg="img/men-large.jpg">
                    <h2>Jean's</h2>
                    <a href="shop.php?cat_id=1">Discover More</a>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- Footer -->

<?php
include('footer.php');


if (isset($_GET['stat'])) {

    echo "
        <script>
                bootbox.alert({
                    message: 'Welcome! You are logged in.',
                    backdrop: true
                });
        </script>";
}
?>

</body>

</html>