<?php



ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

$db = mysqli_connect('localhost', 'root', '', 'threaderz_store');

echo '<script src="./js/product.js"></script>';

function getRealIpUser()
{

    switch (true) {

        case (!empty($_SERVER['HTTP_X_REAL_IP'])):
            return $_SERVER['HTTP_X_REAL_IP'];
        case (!empty($_SERVER['HTTP_CLIENT_IP'])):
            return $_SERVER['HTTP_CLIENT_IP'];
        case (!empty($_SERVER['HTTP_X_FORWARDED_FOR'])):
            return $_SERVER['HTTP_X_FORWARDED_FOR'];

        default:
            return $_SERVER['REMOTE_ADDR'];
    }
}


function addCart()
{
    global $db;
    $c_id=null;
  
        if (isset($_SESSION['user_id'])) {
                $c_id= $_SESSION['user_id'];
            
            }
        

    if (isset($_GET['add_cart'])) {
        $ip_add = getRealIpUser();
        $p_id = $_GET['add_cart'];
        $qty = $_POST['product_qty'];
        $size = $_POST['selected_size'];
        $color = $_POST['color'];
       // Redirect to the checkout page
     

     
       $variant_query = "SELECT variation_id FROM product_variations WHERE products_id = '$p_id' AND color = '$color'";
       $run_variant_query = mysqli_query($db, $variant_query);
            
        if ($run_variant_query && $variant_row = mysqli_fetch_assoc($run_variant_query)) {
          $variant_id = $variant_row['variation_id'];
          

             $check_product = "SELECT * FROM cart WHERE c_id = '$c_id' AND products_id = '$p_id' AND size='$size' AND variant_id = '$variant_id'";
               $run_check = mysqli_query($db, $check_product);
                    
            if (mysqli_num_rows($run_check) > 0) {
                $update_query = "UPDATE cart SET qty = qty + '$qty' WHERE c_id = '$c_id' AND products_id = '$p_id'  AND variant_id = '$variant_id'";
                $run_update = mysqli_query($db, $update_query);
    
                echo "<script>window.open('product.php?product_id=$p_id','_self')</script>";
            } else {
              
                $query = "INSERT INTO cart (products_id, variant_id, ip_add, qty, size, color, date, c_id) VALUES ('$p_id', '$variant_id', '$ip_add', '$qty', '$size', '$color', NOW(), '$c_id')";
                $run_query = mysqli_query($db, $query);
                if (isset($_POST['action']) && $_POST['action'] === 'buy_now') {
                    echo "<script>window.open('check-out.php','_self')</script>"; // Redirect to the checkout page
                } else {
                    echo "<script>window.open('product.php?product_id=$p_id','_self')</script>";
                }
            }
    
    }

    }
}



function getWProduct()
{
    global $db;

    $get_products = "select * from products where  cat_id=15 order by RAND() LIMIT 7";
    $run_products = mysqli_query($db, $get_products);



    while ($row_products = mysqli_fetch_array($run_products)) {

        $products_id = $row_products['products_id'];
        $product_title = $row_products['product_title'];
        $product_price = $row_products['product_price'];
        $product_img1 = $row_products['product_img1'];




        echo "
        
        <div class='product-item'>
        <div class='pi-pic' style='max-height:300px'>
            <img src='img/products/$product_img1' alt='$product_title'>
            <ul>
                <li class='quick-view'><a href='product.php?product_id=$products_id' style='background:#fe4231;color:white'>View Details</a></li>
            </ul>
        </div>
        <div class='pi-text'>
            <a href='product.php?product_id=$products_id'>
                <h5>$product_title</h5>
            </a>
            <div class='product-price'>
            BDT $product_price
            </div>
        </div>
    </div>

    ";
    }
}

// Retrieve men Products for index slider

function getMProduct()
{
    global $db;

    $get_products = "select * from products where cat_id=1 order by RAND() LIMIT 7";
    $run_products = mysqli_query($db, $get_products);



    while ($row_products = mysqli_fetch_array($run_products)) {

        $products_id = $row_products['products_id'];
        $product_title = $row_products['product_title'];
        $product_price = $row_products['product_price'];
        $product_img1 = $row_products['product_img1'];

        echo "
        
        <div class='product-item'>
        <div class='pi-pic' style='max-height:300px'>
            <img src='img/products/$product_img1' alt='$product_title'>
            <ul>
                <li class='quick-view'><a href='product.php?product_id=$products_id' style='background:#fe4231;color:white'>View Details</a></li>
            </ul>
        </div>
        <div class='pi-text'>
            <a href='#'>
                <h5>$product_title</h5>
            </a>
            <div class='product-price'>
            BDT $product_price
            </div>
        </div>
    </div>

    ";
    }
}


// Retrieve Products Catergories

function getProdCat()
{

    global $db;

    $get_p_cats = "select * from product_categories";
    $run_p_cats = mysqli_query($db, $get_p_cats);



    while ($row_p_cats = mysqli_fetch_array($run_p_cats)) {

        $p_cat_id = $row_p_cats['p_cat_id'];
        $p_cat_title = $row_p_cats['p_cat_title'];


        echo "


        <li><a href='shop.php?p_cat_id=$p_cat_id'>$p_cat_title</a></li>

        ";
    }
}

// Retrieve Catergories

function getCat()
{

    global $db;

    $get_cats = "select * from category";
    $run_cats = mysqli_query($db, $get_cats);



    while ($row_cats = mysqli_fetch_array($run_cats)) {

        $cat_id = $row_cats['cat_id'];
        $cat_title = $row_cats['cat_title'];


        echo "

        <li class='hovclass'><a href='shop.php?cat_id=$cat_id'>$cat_title</a></li>

        ";
    }
}
function getPcatProd()
{
    global $db;

    if (isset($_GET['p_cat_id'])) {

        $p_cat_id = $_GET['p_cat_id'];

        $get_p_cat = "select * from product_categories where p_cat_id='$p_cat_id'";
        $run_p_cat = mysqli_query($db, $get_p_cat);

        // Check if the query was successful and if there are rows returned
        if ($run_p_cat && mysqli_num_rows($run_p_cat) > 0) {
            $row_p_cat = mysqli_fetch_array($run_p_cat);

            $p_cat_title = $row_p_cat['p_cat_title'];
            $p_cat_desc = $row_p_cat['p_cat_desc'];

            $get_products = "select * from products where p_cat_id='$p_cat_id'";
            $run_products = mysqli_query($db, $get_products);

            $count = mysqli_num_rows($run_products);

            if ($count == 0) {
                echo "
                    <div class='card' style='font-weight:bold; color:#fe4231'>
                        <div class='card-body'>No Products Available</div>
                    </div>
                ";
            } else {
                while ($row_products = mysqli_fetch_array($run_products)) {
                    $products_id = $row_products['products_id'];
                    $product_title = $row_products['product_title'];
                    $product_price = $row_products['product_price'];
                    $product_img1 = $row_products['product_img1'];

                    echo "
                        <div class='col-lg-4 col-sm-6'>
                            <div class='product-item'>
                                <div class='pi-pic' style='max-height:350px'>
                                    <img src='img/products/$product_img1' alt='$product_title'>
                                    <ul>
                                        <li class='quick-view'><a href='product.php?product_id=$products_id' style='background:#fe4231;color:white'>View Details</a></li>
                                    </ul>
                                </div>
                                <div class='pi-text'>
                                    <div class='catagory-name'></div>
                                    <a href='product.php?product_id=$products_id'>
                                        <h5>$product_title</h5>
                                    </a>
                                    <div class='product-price'>
                                        BDT $product_price                    
                                    </div>
                                </div>
                            </div>
                        </div>
                    ";
                }
            }
        } else {
            // Handle the case where no rows were returned from the query
            echo "No Category Found";
        }
    }
}


function getcatProd()
{
    global $db;

    if (isset($_GET['cat_id'])) {

        $cat_id = $_GET['cat_id'];

        $get_cat = "select * from category where cat_id='$cat_id'";
        $run_cat = mysqli_query($db, $get_cat);

        $row_cat = mysqli_fetch_array($run_cat);

        $p_cat_title = $row_cat['cat_title'];
        $p_cat_desc = $row_cat['cat_desc'];

        $get_products = "select * from products where cat_id='$cat_id'";
        $run_products = mysqli_query($db, $get_products);

        $count = mysqli_num_rows($run_products);





        if ($count == 0) {

            echo "
                <div class='card' style='font-weight:bold; color:#fe4231'>
                    <div class='card-body'>No Products Available</div>
                </div>

                    ";
        } else {



            while ($row_products = mysqli_fetch_array($run_products)) {

                $products_id = $row_products['products_id'];
                $product_title = $row_products['product_title'];
                $product_price = $row_products['product_price'];
                $product_img1 = $row_products['product_img1'];

                echo "
        
                <div class='col-lg-4 col-sm-6'>
                <div class='product-item'>
                    <div class='pi-pic' style='max-height:350px'>
                        <img src='img/products/$product_img1' alt='$product_title'>
                        <ul>
                            <li class='quick-view'><a href='product.php?product_id=$products_id' style='background:#fe4231;color:white'>View Details</a></li>
                        </ul>
                    </div>
                    <div class='pi-text'>
                        <div class='catagory-name'></div>
                        <a href='product.php?product_id=$products_id'>
                            <h5>$product_title</h5>
                        </a>
                        <div class='product-price'>
                        BDT $product_price                    
                        </div>
                    </div>
                </div>
            </div>

    ";
            }
        }
    }
}
function areAllVariantsOutOfStock($product_id) {
    global $db; // Assuming $db is your database connection

    // Your database query to check if all variants are out of stock
$get_stock_query = "SELECT SUM(stock_quantity) AS total FROM product_variations WHERE products_id='$product_id'";
    $run_stock_query = mysqli_query($db, $get_stock_query);
 

    if ($run_stock_query) {
        $row = mysqli_fetch_assoc($run_stock_query);
        
        return $row['total'] == 0; // If total is 0, all variants are out of stock
    } else {
        // Handle database query error
        return true; // Assuming an error means all variants are out of stock
    }
}

function getProd()
{
    global $db;

    if (isset($_GET['product_id'])) {

        $product_id = $_GET['product_id'];

        

        $get_product_id = "select * from products where products_id='$product_id'";
        $run_product_id = mysqli_query($db, $get_product_id);

        $row_products = mysqli_fetch_array($run_product_id);

        $product_title = $row_products['product_title'];
        $product_price = $row_products['product_price'];
        $product_desc = $row_products['product_desc'];
        $product_img1 = $row_products['product_img1'];
        $product_img2 = $row_products['product_img2'];
        $discount_percentage = $row_products['discount_percentage'];

        $get_p_cat_name = "select p_cat_title from products as P,product_categories as C where P.p_cat_id=C.p_cat_id and products_id=$product_id";
        $run_get_p_cat_name = mysqli_query($db, $get_p_cat_name);

        $row_p_cat_name = mysqli_fetch_array($run_get_p_cat_name);

        $p_cat_name = $row_p_cat_name['p_cat_title'];
        echo '<input type="hidden" id="productIdvar" value="' . $row_products['products_id'] . '">';


        // Query to get variations data from the product_variations table
        $get_variations = "SELECT DISTINCT size, color, image_url,stock_quantity FROM product_variations WHERE products_id='$product_id'";
        $run_variations = mysqli_query($db, $get_variations);

        // Fetch variations into an array
        $variationsArray = array();
        while ($variation = mysqli_fetch_assoc($run_variations)) {
            $variationsArray[] = $variation;
        }

        echo "
    <div class='col-lg-6' style='margin:0 auto'>
        <div class='product-pic-zoom  col-md-8' style='max-height:400px;margin: 0 0 30px 0'>
            <img class='product-big-img' src='img/products/$product_img1' alt='$product_title'>
            <div class='zoom-icon'>
                <i class='fa fa-search-plus'></i>
            </div>
        </div>
        <div class='product-thumbs'>
            <div class='product-thumbs-track ps-slider owl-carousel'>
                <div class='pt active' data-imgbigurl='img/products/$product_img1'><img src='img/products/$product_img1' alt='$product_title'></div>
                <div class='pt' data-imgbigurl='img/products/$product_img2'><img src='img/products/$product_img2' alt='$product_title'></div>
            </div>
        </div>
    </div>
    <div class='col-lg-6'>
        <div class='product-details'>
            <div class='pd-title'>
                <h3>$product_title</h3>
            </div>
            "
            
           
            ;
            
            if ($discount_percentage > 0) {
                // Calculate discounted price
                $discounted_price = $product_price - ($product_price * $discount_percentage / 100);
            
                echo "
                    <div class='pd-desc'>
                        <p>$product_desc</p>
                        <h4>
                            <span style='text-decoration: line-through;'>BDT $product_price</span>
                            <br>
                            Offer Price: BDT $discounted_price ({$discount_percentage}% off)
                        </h4>
                    </div>";
            } else {
                echo "
                    <div class='pd-desc'>
                        <p>$product_desc</p>
                        <h4>BDT $product_price</h4>
                    </div>";
            }
           
           echo" <ul class='pd-tags'>
           <li><span>Brand</span>: $p_cat_name</li>
       </ul>";

        // Display product variations
        echo "
        <!-- Product variations -->
        <div class='col-lg-12' style='margin:0'>
            <p>Available Sizes and Colors:</p>
            <div class='product-variations' style='display:flex;gap: 10px;'>";

        // Loop through the array of variations to display
        foreach ($variationsArray as $variation) {
            $size = $variation['size'];
            $color = $variation['color'];
            $imageUrl = $variation['image_url'];

            // Display variation information (you can customize this as needed)
            echo "
            
            <div  data-imgbigurl='img/products/$imageUrl'>
                <img src='img/products/$imageUrl' alt='$product_title' class='small-image'>
                <p id='colorName' class='text-center'> $color</p>

            
        </div>";
        }

        echo "
            </div>
        </div>";

       
        
    }
}

function getVariationsArray(){
    global $db;

    if (isset($_GET['product_id'])) {

        $product_id = $_GET['product_id'];

        // Query to get variations data from the product_variations table
        $get_variations = "SELECT DISTINCT size, color, image_url,stock_quantity FROM product_variations WHERE products_id='$product_id'";
        $run_variations = mysqli_query($db, $get_variations);

        // Fetch variations into an array
        $variationsArray = array();
        while ($variation = mysqli_fetch_assoc($run_variations)) {
            $variationsArray[] = $variation;
        }

        return $variationsArray;
    }
}


function relatedProducts()
{
    global $db;

    if (isset($_GET['product_id'])) {

        $product_id = $_GET['product_id'];


        $get_p_cat_id = "select C.p_cat_id,C.p_cat_title from products as P,product_categories as C where P.p_cat_id=C.p_cat_id and products_id=$product_id";
        $run_get_p_cat_id = mysqli_query($db, $get_p_cat_id);

        $row_p_cat_id = mysqli_fetch_array($run_get_p_cat_id);

        $pcat_id = $row_p_cat_id['p_cat_id'];

        $get_r_products = "select * from products where p_cat_id=$pcat_id LIMIT 1,4";
        $run_get_r_products = mysqli_query($db, $get_r_products);


        while ($row_get_r_products = mysqli_fetch_array($run_get_r_products)) {



            $p_id = $row_get_r_products['products_id'];
            $p_name = $row_get_r_products['product_title'];
            $p_img1 = $row_get_r_products['product_img1'];
            $p_price = $row_get_r_products['product_price'];


            if ($p_id != $product_id) {
                echo "


        <div class='col-lg-3 col-sm-6'>
            <div class='product-item' >
                <div class='pi-pic' style='max-height:300px'>
                    <img src='img/products/$p_img1' alt='$p_name'>
                    <ul>
                        <li class='quick-view'><a href='product.php?product_id=$p_id' style='background:#fe4231;color:white'>View Details</a></li>
                    </ul>
                </div>
                <div class='pi-text'>
                    <a href='#'>
                        <h5>$p_name</h5>
                    </a>
                    <div class='product-price'>
                    BDT $p_price
                    </div>
                </div>
            </div>
        </div>
        
        ";
            }
        }
    }
}


function items()
{

    global $db;

    $ip_add = getRealIpUser();
    $c_id=null;
  
    if (isset($_SESSION['user_id'])) {
        $c_id= $_SESSION['user_id'];
      
    }
   

    $get_items = "select * from cart where c_id = '$c_id'";
    $run_items = mysqli_query($db, $get_items);

    $count_items = mysqli_num_rows($run_items);

    echo $count_items;
}


function total_price()
{

    global $db;
    $c_id=null;

    $ip_add = getRealIpUser();
   
    if (isset($_SESSION['user_id'])) {
        $c_id= $_SESSION['user_id'];
      
    }

    $total = 0;

    $get_items = "select * from cart where c_id = '$c_id'";
    $run_items = mysqli_query($db, $get_items);


    while ($row_items = mysqli_fetch_array($run_items)) {
        $p_id = $row_items['products_id'];
        $pro_qty = $row_items['qty'];

        $get_price = "select * from products where products_id = '$p_id'";
        $run_price = mysqli_query($db, $get_price);
        $sub_price =0;

        while ($row_price = mysqli_fetch_array($run_price)) {
            $product_price = $row_price['product_price'];

            $discount_percentage = $row_price['discount_percentage'];
            if ($discount_percentage > 0) {
                $discounted_price = calculateDiscountedPrice($product_price, $discount_percentage);
                $sub_price = $discounted_price * $pro_qty;
            } else {
               
                $sub_price = $product_price * $pro_qty;
            }

           
            $total += $sub_price;
        }
    }
    echo "BDT " . $total;
}


function totalWithDeliveryCharge() {
    global $db;
    $c_id = null;

    $ip_add = getRealIpUser();

    if (isset($_SESSION['user_id'])) {
        $c_id = $_SESSION['user_id'];
    }

    $total = 0;

    $get_items = "SELECT * FROM cart WHERE c_id = '$c_id'";
    $run_items = mysqli_query($db, $get_items);

    while ($row_items = mysqli_fetch_array($run_items)) {
        $p_id = $row_items['products_id'];
        $pro_qty = $row_items['qty'];

        $get_price = "SELECT * FROM products WHERE products_id = '$p_id'";
        $run_price = mysqli_query($db, $get_price);
        $sub_price = 0;

        while ($row_price = mysqli_fetch_array($run_price)) {
            $product_price = $row_price['product_price'];

            $discount_percentage = $row_price['discount_percentage'];
            if ($discount_percentage > 0) {
                $discounted_price = calculateDiscountedPrice($product_price, $discount_percentage);
                $sub_price = $discounted_price * $pro_qty;
            } else {
                $sub_price = $product_price * $pro_qty;
            }

            $total += $sub_price;
        }
    }

    // Add delivery charge
    $delivery_charge = 60;
    $total += $delivery_charge;

    echo "BDT " . $total;}



function calculateDiscountedPrice($originalPrice, $discountPercentage)
{
    return $originalPrice - ($originalPrice * $discountPercentage / 100);
}

$countrows = 0;

function cart_items()
{

    global $db;

    $c_id=null;
    if (isset($_SESSION['user_id'])) {
        $c_id= $_SESSION['user_id'];
      
    }

    $get_items = "select * from cart where c_id = '$c_id' ORDER BY date DESC";
    $run_itemss = mysqli_query($db, $get_items);

    $countrows =  mysqli_num_rows($run_itemss);

    if ($countrows == 0) {
        echo  " 

    <div class='card col-md-3 col-10' style='margin:0 auto; border-radius:25px 5px;box-shadow: inset -12px -8px 40px #e5e5e5;'>
        <div class='card-body'>
           <h5 style='text-align:center;font-weight:500'> No items in Cart </h5>
        </div>
    </div>
           
        ";
    } else {

        echo "
        
        <thead style='font-size: larger;'>
                            <tr>
                                <th>Image</th>
                                <th class='p-name'>Product Name</th>
                                <th>Price</th>
                                <th>Size</th>
                                <th>Color</th>
                                <th>Quantity</th>
                                <th>Total</th>
                                <th></th>
                            </tr>
                        </thead>

        ";


        while ($row_items = mysqli_fetch_array($run_itemss)) {
            $p_id = $row_items['products_id'];
            $variant_id = $row_items['variant_id'];
            $pro_qty = $row_items['qty'];
            $pro_size = $row_items['size'];

          


            // $get_item = "select * from products where products_id = '$p_id'";
                    
            $get_item = "SELECT products.products_id,products.product_title, products.product_price,products.discount_percentage,product_variations.color,product_variations.image_url, cart.size
            FROM products 
            LEFT JOIN product_variations ON products.products_id = product_variations.products_id
            LEFT JOIN cart ON product_variations.variation_id = cart.variant_id
            WHERE cart.variant_id = '$variant_id'";


            $run_item = mysqli_query($db, $get_item);
           // $item_data = [];

            while ($row_item = mysqli_fetch_array($run_item)) {
              //  $item_data[] = $row_item;
               


                $pro_id = $row_item['products_id'];
                $pro_name = $row_item['product_title'];
                $pro_price = $row_item['product_price'];
               
                $pro_color = $row_item['color'];
                $pro_img1 = $row_item['image_url'];
                $discount_percentage = $row_item['discount_percentage'];
                $pro_discounted_price = $pro_price - ($pro_price * $discount_percentage / 100);

                // Calculate total price after discount
                $pro_total_p = $pro_discounted_price * $pro_qty;


               // $pro_total_p = $pro_price * $pro_qty;
            }

            // $item_json = json_encode($item_data);
            // echo "<script>console.log(JSON.parse('" . $item_json . "'));</script>";

            echo "
    <tr style='border-bottom: 0.5px solid #ebebeb'>
       <td class='cart-pic first-row'><img src='img/products/$pro_img1' alt='$pro_name' style='max-height:100px'></td>
       <td class='cart-title first-row'>
           <h5><a href='product.php?product_id=$pro_id' style='color:black;font-weight:bold'>$pro_name</h5>
       </td>
       <td class='p-price first-row'>";

    // Display both original and discounted price if there is a discount
    if ($discount_percentage > 0) {
        echo "BDT <del>$pro_price</del> $pro_discounted_price";
    } else {
        echo "BDT $pro_price";
    }

    echo "</td>
    <td> <h5><a href='product.php?product_id=$pro_id' style='color:black;font-weight:bold'>$pro_size</a></h5></td>
            <td> <h5><a href='product.php?product_id=$pro_id' style='color:black;font-weight:bold'>$pro_color</a></h5></td>
           
       <td class='qua-col first-row'>
           <div class='quantity'>
               <div class='pro-qty'>
                   <input id='qqty' type='text' value='$pro_qty'>
               </div>
           </div>
       </td>
       <td class='total-price first-row'>BDT $pro_total_p</td>
       <td class='close-td first-row'><a href='shopping-cart.php?del=$pro_id'><i class='ti-close' style='color:black'></i></a></td>
    </tr>";
        }
    }
}

function cart_icon_prod()
{

    global $db;
    $c_id=null;

    $ip_add = getRealIpUser();
    if (isset($_SESSION['user_id'])) {
        $c_id= $_SESSION['user_id'];
      
    }
   


    $get_items = "select * from cart where c_id = '$c_id' ORDER BY date DESC LIMIT 0,2";
    $run_items = mysqli_query($db, $get_items);



    if (mysqli_num_rows($run_items) == 0) {
        echo  " 

        
        <p style='text-align:center; font-weight:500;color:#fe4231'>Cart Empty </p>
    
           
        ";
    } else {

        while ($row_items = mysqli_fetch_array($run_items)) {
            $p_id = $row_items['products_id'];
            $v_id = $row_items['variant_id'];
            $pro_qty = $row_items['qty'];

            $get_item = "SELECT products.*, product_variations.*
            FROM products 
            LEFT JOIN product_variations ON products.products_id = product_variations.products_id
            WHERE product_variations.variation_id = '$v_id'  ORDER BY date DESC";
            $run_item = mysqli_query($db, $get_item);

            while ($row_item = mysqli_fetch_array($run_item)) {

                $pro_name = $row_item['product_title'];
                $pro_price = $row_item['product_price'];
                $discount_price = $row_item['discount_percentage'];
                $pro_img1 = $row_item['image_url'];

                $discounted = $pro_price - ($pro_price * $discount_price / 100);
//

                $pro_total_p = $discounted * $pro_qty;
            }

            echo "
        <tr>
        <td class='si-pic'><img src='img/products/$pro_img1' alt='$pro_name' style='max-height:70px'></td>
        <td class='si-text'>
            <div class='product-selected'>
                <p>BDT $discounted x $pro_qty</p>
                <h6>$pro_name</h6>
            </div>
        </td>
        <td class='si-close'>
        <a href='shopping-cart.php?delcart=$p_id'> <i class='ti-close' style='color:black'></i></a>
        </td>
    </tr>
    ";
        }
    }
}


function checkoutProds()
{


    global $db;

    $ip_add = getRealIpUser();
    $c_id=null;
   
    if (isset($_SESSION['user_id'])) {
        $c_id= $_SESSION['user_id'];
      
    }


    $get_items = "select * from cart where c_id = '$c_id' ORDER BY date DESC";
    $run_items = mysqli_query($db, $get_items);


    if (mysqli_num_rows($run_items) == 0) {
        echo  " 

        
        <li class='fw-normal' style='text-align:center;font-weight:bold;font-size:larger;color:#fe4231'>No Items in Cart</li>
    
           
        
        ";
    } else {

        while ($row_items = mysqli_fetch_array($run_items)) {
            $p_id = $row_items['products_id'];
            $pro_qty = $row_items['qty'];
            $prod_size= $row_items['size'];
            $prod_color= $row_items['color'];

            $get_item = "select * from products where products_id = '$p_id' ORDER BY date DESC";
            $run_item = mysqli_query($db, $get_item);

            while ($row_item = mysqli_fetch_array($run_item)) {

                $pro_name = $row_item['product_title'];
                $pro_price = $row_item['product_price'];
                $discount_percentage = $row_item['discount_percentage'];
                $pro_discounted_price = $pro_price - ($pro_price * $discount_percentage / 100);

                // Calculate total price after discount
                $pro_total_p = $pro_discounted_price * $pro_qty;



             //   $pro_total_p = $pro_price * $pro_qty;
            }

            echo "
        <li class='fw-normal'>$pro_name($prod_size+$prod_color)  x $pro_qty <span>$pro_total_p</span></li>
    
";
        }
    }
}



