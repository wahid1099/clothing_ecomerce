<?php

require './PHPMailer/src/PHPMailer.php';
require './PHPMailer/src/SMTP.php';
require './PHPMailer/src/Exception.php';

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;
use PHPMailer\PHPMailer\SMTP;

function sendOrderConfirmationEmail($con, $order_id, $customer_name, $customer_email, $total_q, $final_price, $product_ids_str, $variation_ids_str, $customer_phone, $customer_address) {
    $c_id = null;

    if (isset($_SESSION['user_id'])) {
        $c_id = $_SESSION['user_id'];
    }

    $mail = new PHPMailer(true);

    try {
        // Server settings
        $mail->isSMTP();
        $mail->Host       = $_ENV['DB_HOST'];
        $mail->SMTPAuth   = true;
        $mail->Username   = $_ENV['DB_USER']; // Replace with your Gmail address
        $mail->Password   = $_ENV['DB_PASSWORD']; // Replace with your Gmail password
        $mail->SMTPSecure = 'tls';
        $mail->Port       = 587;

        // Recipients
        $mail->setFrom('support@poshak-bd.com', 'POSHAK BD');
        $mail->addAddress('poshaklifestyle0@gmail.com');

        // Content
        $mail->isHTML(true);
        $mail->Subject = 'New Order Placed';

        $mail->Body = "
        <p>A new order has been placed:</p>

        <p><strong>Order ID:</strong> $order_id</p>
        <p><strong>Customer Name:</strong> $customer_name</p>
        <p><strong>Customer Email:</strong> $customer_email</p>
        <p><strong>Customer Address:</strong> $customer_address</p>
        <p><strong>Customer Phone:</strong> $customer_phone</p>
        <p><strong>Total Quantity:</strong> $total_q</p>
        <p><strong>Total Price:</strong> $final_price</p>
        <p><strong>Date:</strong> " . date("Y-m-d H:i:s") . "</p>";

        // Fetch cart items
        $get_cart_items = "SELECT c.*, p.product_title, p.product_price, p.discount_percentage, p.product_code, v.image_url 
                            FROM cart c
                            JOIN products p ON c.products_id = p.products_id
                            JOIN product_variations v ON c.variant_id = v.variation_id
                            WHERE c.c_id = '$c_id'
                            ORDER BY c.date DESC";
        $run_cart_items = mysqli_query($con, $get_cart_items);

        if ($run_cart_items) {
            // Start the table in the email body
            $mail->Body .= "<table border='1'> 
                                <thead>
                                    <tr>
                                        <th>Product ID</th>
                                        <th>Product Name</th>
                                        <th>Product Price</th>
                                        <th>Image</th>
                                        <th>Color</th>
                                        <th>Size</th>
                                        <th>Quantity</th>
                                        <th>Product Code</th>
                                    </tr>
                                </thead>
                                <tbody>";

            while ($row_cart_item = mysqli_fetch_assoc($run_cart_items)) {
                $product_id = $row_cart_item['products_id'];
                $product_title = $row_cart_item['product_title'];
                $pro_price = $row_cart_item['product_price'];
                $discount_percentage = $row_cart_item['discount_percentage'];
                $pro_discounted_price = $pro_price - ($pro_price * $discount_percentage / 100);

                // Calculate total price after discount
                $quantity = $row_cart_item['qty'];
                $pro_total_p = $pro_discounted_price * $quantity;

                $image_url = $row_cart_item['image_url'];
                $color = $row_cart_item['color'];
                $size = $row_cart_item['size'];
                $p_code = $row_cart_item['product_code'];

                // Append each cart item to the table in the email body
                $mail->Body .= "<tr>
                                    <td>$product_id</td>
                                    <td>$product_title</td>
                                    <td>$pro_total_p</td>
                                    <td><img src='cid:product_image_$product_id' alt='$product_title' style='max-height:100px'></td>
                                    <td>$color</td>
                                    <td>$size</td>
                                    <td>$quantity</td>
                                    <td>$p_code</td>
                                </tr>";
                                $mail->AddEmbeddedImage('img/products/' . $image_url, "product_image_$product_id");

            }
            // Embed images as attachments



                        // Close the table and complete the email body
            $mail->Body .= "</tbody></table>";

            // Send the email
            $mail->send();
            echo 'Message has been sent';
        }
    } catch (Exception $e) {
        echo '<script>alert("Message could not be sent. Mailer Error: ' . $mail->ErrorInfo . '");</script>';
    }
}

?>
