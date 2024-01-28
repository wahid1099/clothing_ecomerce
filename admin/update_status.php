<?php
include('../db.php');

// Get parameters from the AJAX request
$orderId = $_POST['orderId'];
$newStatus = mysqli_real_escape_string($con, $_POST['newStatus']);

// Update the status in the orders table
$updateQuery = "UPDATE orders SET status = '$newStatus' WHERE order_id = $orderId";
$updateResult = mysqli_query($con, $updateQuery);

// Check for errors in the query
if (!$updateResult) {
    die("Query failed: " . mysqli_error($con));
}

// Close the database connection
mysqli_close($con);
?>
