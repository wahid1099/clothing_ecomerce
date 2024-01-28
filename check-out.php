<?php
$active = "Checkout";
include('db.php');
include("functions.php");
include("header.php");
require 'mailconfig.php';
?>


<!-- Breadcrumb Section Begin -->
<div class="breacrumb-section">
    <div class="container">
        <div class="row">
            <div class="col-lg-12">
                <div class="breadcrumb-text product-more">
                    <a href="index.php"><i class="fa fa-home"></i> Home</a>
                    <a href="shop.php">Shop</a>
                    <span>Check Out</span>
                </div>
            </div>
        </div>
    </div>
</div>
<!-- Breadcrumb Section End -->

<!-- Shopping Cart Section Begin -->
<section class="checkout-section spad">
    <div class="container">
        <form class="checkout-form" action="check-out.php?place=1" method="post" >
            <div class="row">
            <div class="col-lg-6">
            <div class="checkout-content">
                        <a href="shop.php" class="content-btn" style="background:#212529; color:#fff;">Continue Shopping</a>
                    </div>
    <div class="checkout-content">
        <h4>Your  Details</h4>
        <div class="row">
            <div class="col-md-12">
                <input type="text" name="customer_name" placeholder="Full Name" required>
            </div>
            <div class="col-md-12">
                <input type="text" name="customer_phone" placeholder="Phone No" >
            </div>
            <div class="col-md-12">
            <input type="text" name="customer_address" placeholder="Address" >

                
            </div>
           
        </div>
    </div>
</div>

                <div class="col-lg-6" >
                    
                    <div class="place-order">
                        <h4>Your Order</h4>
                        <div class="order-total">
                            <ul class="order-table">
                                <li>Products <span>Total</span></li>
                                <?php checkoutProds(); ?>

                                <li class="fw-normal">Subtotal <span><?php total_price(); ?></span></li>
                                <li class="total-price">Total <span><?php total_price(); ?></span></li>
                            </ul>
                            <div class="order-btn">
                        <button type="submit" class="site-btn place-btn">Place Order</button>
                    </div>
                          

                        </div>
                    </div>
                </div>
        </form>
    </div>
</section>
<!-- Shopping Cart Section End -->


<?php
include('footer.php');
?>

</body>

</html>


<?php



if (isset($_GET['place'])   && $_SERVER['REQUEST_METHOD'] == 'POST') {
    $customer_name = mysqli_real_escape_string($con, $_POST['customer_name']);
    $customer_email = isset($_SESSION['customer_email']) ? $_SESSION['customer_email'] : null;
    $customer_phone = mysqli_real_escape_string($con, $_POST['customer_phone']);
    $customer_address = mysqli_real_escape_string($con, $_POST['customer_address']);


    $c_id=null;
  
    if (isset($_SESSION['user_id'])) {
            $c_id= $_SESSION['user_id'];
        
        }
    $custom_id = null;

    if (!isset($_SESSION['customer_email']) || $_SESSION['customer_email'] == 'unset') {
        $custom_id = 1;
    } else {
        $custom_id = $_SESSION['customer_email'];
    }
    

    // Process cart items
    $get_items = "SELECT * FROM cart WHERE c_id = '$c_id'";
    $run_items = mysqli_query($con, $get_items);

    $total_q = 0;
    $final_price = 0;
    $product_ids = [];

    while ($row_items = mysqli_fetch_array($run_items)) {
        $p_id = $row_items['products_id'];
        $pro_qty = $row_items['qty'];

        // Store product ID in the array
        $product_ids[] = $p_id;

        $get_item = "SELECT * FROM products WHERE products_id = '$p_id'";
        $run_item = mysqli_query($con, $get_item);

        while ($row_item = mysqli_fetch_array($run_item)) {
            $pro_price = $row_item['product_price'];
            $pro_total_p = $pro_price * $pro_qty;
        }

        $total_q += $pro_qty;
        $final_price += $pro_total_p;
    }

    // Convert the array of product IDs to a comma-separated string
    $product_ids_str = implode(',', $product_ids);

    // Insert order into the database with customer details and product IDs
    $order = "INSERT INTO orders (order_qty, order_price, customer_name, c_id, customer_phone, customer_address, product_id	, date) 
              VALUES ('$total_q', '$final_price', '$customer_name', '$custom_id', '$customer_phone', '$customer_address', '$product_ids_str', NOW())";

    $run_order = mysqli_query($con, $order);
    $order_id = mysqli_insert_id($con);
 
    sendOrderConfirmationEmail($con, $order_id, $customer_name, $customer_email, $total_q, $final_price, $product_ids_str,$customer_phone,$customer_address);

   
    // Clear the cart
    $cart_clear = "DELETE FROM cart WHERE c_id = '$c_id'";
    $run_clear = mysqli_query($con, $cart_clear);
  
echo "<script>window.location.href='thankyou.php?order_id=$order_id';</script>";


}



?>