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
                                <li class="fw-normal">Delivery Charge: <span>60TK</span></li>
                                <li class="cart-total">Total <span><?php totalWithDeliveryCharge() ?></span></li>
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

if (isset($_GET['place']) && $_SERVER['REQUEST_METHOD'] == 'POST') {
    $customer_name = mysqli_real_escape_string($con, $_POST['customer_name']);
    $customer_email = isset($_SESSION['customer_email']) ? $_SESSION['customer_email'] : null;
    $customer_phone = mysqli_real_escape_string($con, $_POST['customer_phone']);
    $customer_address = mysqli_real_escape_string($con, $_POST['customer_address']);

    $c_id = null;

    if (isset($_SESSION['user_id'])) {
        $c_id = $_SESSION['user_id'];
    }

    $custom_id = isset($_SESSION['customer_email']) ? $_SESSION['customer_email'] : null;

    // Process cart items
    $get_items = "SELECT * FROM cart WHERE c_id = ?";
    $stmt_get_items = mysqli_prepare($con, $get_items);
    mysqli_stmt_bind_param($stmt_get_items, 's', $c_id);
    mysqli_stmt_execute($stmt_get_items);
    $run_items = mysqli_stmt_get_result($stmt_get_items);

    $total_q = 0;
    $final_price = 0;
    $product_ids = [];
    $variation_ids = [];
    $product_data = [];


    while ($row_items = mysqli_fetch_array($run_items)) {
        $p_id = $row_items['products_id'];
        $pro_qty = $row_items['qty'];
        $size = $row_items['size'];
        $color = $row_items['color'];
        $variant_id = $row_items['variant_id'];

        $get_item = "SELECT * FROM products WHERE products_id = ?";
        $stmt_get_item = mysqli_prepare($con, $get_item);
        mysqli_stmt_bind_param($stmt_get_item, 's', $p_id);
        mysqli_stmt_execute($stmt_get_item);
        $run_item = mysqli_stmt_get_result($stmt_get_item);

        while ($row_item = mysqli_fetch_array($run_item)) {
            $pro_price = $row_item['product_price'];
            $discount_percent = $row_item['discount_percentage'];
            $pro_discount_price = $pro_price - ($pro_price * $discount_percent / 100);


            $pro_total_p = $pro_discount_price * $pro_qty;
        }

        $total_q += $pro_qty;
        $final_price += $pro_total_p;
        $product_ids[] = $p_id;
        $variation_ids[] = $variant_id;
        $product_data[] = [
            'product_id' => $p_id,
            'pro_qty' => $pro_qty,
            'size' => $size,
            'color' => $color,
            'variant_id' => $variant_id,
        ];
    }

    // Convert the array of product IDs to a comma-separated string
    $product_ids_str = implode(',', $product_ids);
    $variation_ids_str = implode(',', $variation_ids);
    $product_data_str = json_encode($product_data);

    
// Add 60 TK delivery charge to the final price

    $final_price+=60;


    // Insert order into the orders table
    $order = "INSERT INTO orders (order_qty, order_price, customer_name, c_id, customer_phone, customer_address, product_id, date) 
              VALUES (?, ?, ?, ?, ?, ?, ?, NOW())";
    $stmt_order = mysqli_prepare($con, $order);
    mysqli_stmt_bind_param($stmt_order, 'sssssss', $total_q, $final_price, $customer_name, $custom_id, $customer_phone, $customer_address, $product_ids_str);
    $run_order = mysqli_stmt_execute($stmt_order);
    $order_id = mysqli_insert_id($con);

    if ($run_order) {
        // Insert order details into the order_details table
        $order_details_query = "INSERT INTO order_details (order_id, products_id, size, color, quantity, varient_id) VALUES (?, ?, ?, ?, ?, ?)";
        $stmt_order_details = mysqli_prepare($con, $order_details_query);
        foreach ($product_data as $product) {
            $p_id = $product['product_id'];
            $pro_qty = $product['pro_qty'];
            $size = $product['size'];
            $color = $product['color'];
            $variant_id = $product['variant_id'];

                        // Insert order details

    
            mysqli_stmt_bind_param($stmt_order_details, 'ssssss', $order_id, $p_id, $size, $color, $pro_qty, $variant_id);
            $run_order_details = mysqli_stmt_execute($stmt_order_details);
    
            if (!$run_order_details) {
                // Handle the error appropriately (e.g., log the error, display a user-friendly message)
                echo "Error inserting order details: " . mysqli_error($con);
            }
               // Update stock_quantity in product_variations
               $update_stock_query = "UPDATE product_variations SET stock_quantity = GREATEST(stock_quantity - ?, 0) WHERE variation_id = ?";

               $stmt_update_stock = mysqli_prepare($con, $update_stock_query);
               mysqli_stmt_bind_param($stmt_update_stock, 'ss', $pro_qty, $variant_id);
               $run_update_stock = mysqli_stmt_execute($stmt_update_stock);
        }

            } else {
                // Handle the error appropriately (e.g., log the error, display a user-friendly message)
                echo "Error preparing order details statement: " . mysqli_error($con);
            }
        

        sendOrderConfirmationEmail($con, $order_id, $customer_name, $customer_email, $total_q, $final_price, $product_ids_str, $variation_ids_str, $customer_phone, $customer_address);

        // Clear the cart
        $cart_clear = "DELETE FROM cart WHERE c_id = ?";
        $stmt_clear = mysqli_prepare($con, $cart_clear);
        mysqli_stmt_bind_param($stmt_clear, 's', $c_id);
        $run_clear = mysqli_stmt_execute($stmt_clear);

        echo "<script>window.location.href='thankyou.php?order_id=$order_id';</script>";
    } else {
        // Handle the error appropriately (e.g., log the error, display a user-friendly message)
        echo "Error inserting order: " . mysqli_error($con);
    }

?>
