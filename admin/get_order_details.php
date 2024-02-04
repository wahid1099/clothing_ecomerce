<?php
include('../db.php');

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Check if the order ID is provided
    if (isset($_POST['orderId'])) {
        $orderId = $_POST['orderId'];

        // Fetch order details from the database
        $orderDetailsQuery = "SELECT order_details.*, products.product_title ,products.product_code,products.product_price,products.discount_percentage
            FROM order_details
            INNER JOIN products ON order_details.products_id = products.products_id
            WHERE order_details.order_id = ?";

        $stmtOrderDetails = mysqli_prepare($con, $orderDetailsQuery);

        if ($stmtOrderDetails) {
            mysqli_stmt_bind_param($stmtOrderDetails, 'i', $orderId);
            mysqli_stmt_execute($stmtOrderDetails);
            $resultOrderDetails = mysqli_stmt_get_result($stmtOrderDetails);

            // Construct the HTML content for order details
            $htmlContent = '<table class="table table-bordered">
                                <thead>
                                    <tr>
                                        <th>Product Name</th>
                                        <th>Product Price</th>
                                        <th>Product Code</th>
                                        <th>Product Size</th>
                                        <th>Product Color</th>
                                        
                                        <th>Quantity</th>
                                    </tr>
                                </thead>
                                <tbody>';

            while ($rowOrderDetails = mysqli_fetch_assoc($resultOrderDetails)) {
                $discount_percent= $rowOrderDetails['discount_percentage'];
               $pro_price =$rowOrderDetails['product_price'];
               $pro_qty=$rowOrderDetails['quantity'];


               $discounted = $pro_price - ($pro_price * $discount_percent / 100);
               $total_price=$pro_qty*$discounted;
                
              

                $htmlContent .= '<tr>';
                $htmlContent .= '<td>' . $rowOrderDetails['product_title'] . '</td>';
                $htmlContent .= '<td>' . $total_price . '</td>';
                $htmlContent .= '<td>' . $rowOrderDetails['product_code'] . '</td>';
                $htmlContent .= '<td>' . $rowOrderDetails['size'] . '</td>';
                $htmlContent .= '<td>' . $rowOrderDetails['color'] . '</td>';
                $htmlContent .= '<td>' . $pro_qty . '</td>';
                $htmlContent .= '</tr>';
            }

            $htmlContent .= '</tbody></table>';

            // Send the HTML content as the response
            echo $htmlContent;

            // Free the result set
            mysqli_free_result($resultOrderDetails);
        } else {
            echo "Error preparing order details statement: " . mysqli_error($con);
        }

        // Close the statement
        mysqli_stmt_close($stmtOrderDetails);
    } else {
        echo "Order ID not provided.";
    }
} else {
    echo "Invalid request method.";
}
?>
