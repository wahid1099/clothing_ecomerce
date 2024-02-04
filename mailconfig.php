<?php

require './PHPMailer/src/PHPMailer.php';
require './PHPMailer/src/SMTP.php';
require './PHPMailer/src/Exception.php';

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;
use PHPMailer\PHPMailer\SMTP;

function sendOrderConfirmationEmail($con, $order_id, $customer_name, $customer_email, $total_q, $final_price, $product_ids_str,$variation_ids_str ,$customer_phone,$customer_address) {
    $c_id=null;
  
    if (isset($_SESSION['user_id'])) {
            $c_id= $_SESSION['user_id'];
        
        }
    
    $mail = new PHPMailer(true);

    try {
        // Server settings
        $mail->isSMTP();
        $mail->Host       = 'smtp.gmail.com';
        $mail->SMTPAuth   = true;
        $mail->Username   = 'codemen.wahid@gmail.com'; // Replace with your Gmail address
        $mail->Password   = 'zlsr qlyf dvot ysem'; // Replace with your Gmail password
        $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;
        $mail->Port       = 587;

        // Recipients
        $mail->setFrom('codemen.wahid@gmail.com', 'My Website');
        $mail->addAddress('wahidahmed890@gmail.com'); // Replace with your admin's email address

        // Content
        $mail->isHTML(true);
        $mail->Subject = 'New Order Placed';

        $mail->Body = "
        <p>A new order has been placed:</p>
        
        <p><strong>Order ID:</strong> $order_id</p>
        <p><strong>Customer Name:</strong> $customer_name</p>
        <p><strong>Customer Email:</strong> $customer_email</p>
        <p><strong>Customer Adress:</strong> $customer_address</p>
        <p><strong>Customer Phone:</strong> $customer_phone</p>
        <p><strong>Total Quantity:</strong> $total_q</p>
        <p><strong>Total Price:</strong> $final_price</p>
        <p><strong>Date:</strong> " . date("Y-m-d H:i:s") . "</p>

        
        <table border='1'>
            <tr>
                <th>Product ID</th>
                <th>Product Name</th>
                <th>Product Color</th>
                <th>Product Size</th>
                <th>Quantity</th>

                <!-- Add more table headers as needed -->
            </tr>";
    
    // Fetch product details and append to the table
    $product_ids = explode(',', $product_ids_str);
    $varation_ids = explode(',',  $variation_ids_str );
   
    foreach (array_map(null, $product_ids, $varation_ids) as [$product_id, $variation_id]) {
        $get_product_info = "SELECT p.product_title, p.product_price, v.* 
                         FROM products p 
                         JOIN product_variations v ON p.products_id = v.products_id 
                         WHERE p.products_id = '$product_id' AND v.variation_id = '$variation_id'";
    

    $run_product_info = mysqli_query($con, $get_product_info);

    if ($row_product_info = mysqli_fetch_array($run_product_info)) {
        $productImagePath = './img/products/' . $row_product_info['image_url'];
            $mail->addAttachment($productImagePath, basename($productImagePath));


              // Get individual product quantity
            $get_quantity = "SELECT qty FROM cart WHERE c_id = '$c_id' AND variant_id = '$variation_id'";
            $run_quantity = mysqli_query($con, $get_quantity);
            $row_quantity = mysqli_fetch_assoc($run_quantity);
            $product_quantity = $row_quantity['qty'];

    
            // Add a new row to the table for each product
            $mail->Body .= "
                <tr>
                    <td>{$row_product_info['products_id']}</td>
                    <td>{$row_product_info['product_title']}</td>
                    <td>{$row_product_info['color']}</td>
                    <td>{$row_product_info['size']}</td>
                    <td>$product_quantity</td> 

                    <!-- Add more table cells as needed -->
                </tr>";
        }
    }
    
    // Close the table and complete the email body
    $mail->Body .= "</table>";
    $mail->send();
    echo 'Message has been sent';
    } catch (Exception $e) {
        echo '<script>alert("Message could not be sent. Mailer Error: ' . $mail->ErrorInfo . '");</script>';
    }
}

?>
