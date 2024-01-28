<?php
$active = "Thank You";
include('db.php');
include("functions.php");
include("header.php");

// Retrieve the order ID from the URL
$order_id = isset($_GET['order_id']) ? $_GET['order_id'] : null;

if (!$order_id) {
    // Handle the case where order ID is not provided
    echo "Order ID not found.";
    exit;
}

// Fetch order details from the database using $order_id
$order_query = "SELECT * FROM orders WHERE order_id = $order_id";
$order_result = mysqli_query($con, $order_query);

if (!$order_result) {
    // Handle the case where order details cannot be retrieved
    echo "Error fetching order details.";
    exit;
}

$order_details = mysqli_fetch_assoc($order_result);

?>

<!-- Display order details using $order_details array -->
<!-- Example: -->
<div class="container">
    <?php if ($order_details) { ?>
        <h2>Thank You for Your Order</h2>
        <p>Your order details:</p>
        <div class="order-details">
            <p><strong>Order ID:</strong> <?php echo $order_details['order_id']; ?></p>
            <p><strong>Order Quantity:</strong> <?php echo $order_details['order_qty']; ?></p>
            <p><strong>Adress:</strong> <?php echo $order_details['customer_address']; ?></p>
            <p><strong>Phone No:</strong> <?php echo $order_details['customer_phone']; ?></p>
            
            <p><strong>Total Price:</strong> <?php echo $order_details['order_price']; ?></p>
            <!-- Add more details as needed -->
            <img src="img/thankyou.jpg" style="width:100%;height:500px;"/>

        </div>
    <?php } else { ?>
        <p>No data found for the provided Order ID.</p>
    <?php } ?>
</div>

<style>
    /* Apply custom styles to the order details */
    .order-details {
        list-style: none;
        padding: 0;
    }

    .order-details p {
        margin: 0;
        padding: 5px 0;
        border-bottom: 1px solid #ccc;
    }
</style>

<!-- Include footer and close HTML tags -->
<?php
include('footer.php');
?>
