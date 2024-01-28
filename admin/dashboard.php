<?php
// Start the session
include('../db.php');
include("auth_check.php");

// Function to get total number of products
function getTotalProducts() {
    global $con;
    $query = "SELECT COUNT(*) as total_products FROM products";
    $result = mysqli_query($con, $query);
    $row = mysqli_fetch_assoc($result);
    return $row['total_products'];
}

// Function to get total number of orders
function getTotalOrders() {
    global $con;
    $query = "SELECT COUNT(*) as total_orders FROM orders";
    $result = mysqli_query($con, $query);
    $row = mysqli_fetch_assoc($result);
    return $row['total_orders'];
}

// Function to get total earnings
function getTotalEarnings() {
    global $con;
    $query = "SELECT SUM(order_price) as total_earnings FROM orders";
    $result = mysqli_query($con, $query);
    $row = mysqli_fetch_assoc($result);
    return $row['total_earnings'];
}

// Example usage
$totalProducts = getTotalProducts();
$totalOrders = getTotalOrders();
$totalEarnings = getTotalEarnings();

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>All Orders</title>
    <link rel="stylesheet" href="inclueds/sidebar.css">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css">
    <!-- toast -->
    <link rel="stylesheet" type="text/css" href="https://cdn.jsdelivr.net/npm/toastify-js/src/toastify.min.css">


</head>

<body>
<div class="row">
        <div class="col-lg-2">
        <?php include 'inclueds/sidebar.php'; ?>
        </div>
        <div class="col-lg-12" id="main"> <!-- Adjust the width based on your layout -->
        <div class="card-deck">
        
           
        <div class="card col-lg-4 text-white bg-primary mb-3" style="padding:10px;text-align:center;">
            <div class="card  " >
    <div class="card-body">
      <h1 class="card-title">Total Products</h1>
      <h2 class="card-text">
      <?php echo $totalProducts; ?>
</h2>
    </div>
    
  </div>
            </div>


            <div class="card col-lg-4      mb-3" style="padding:10px ;background:red;text-align:center; color:#fff">
            <div class="card  " >
    <div class="card-body">
      <h1 class="card-title">Total Orders</h1>
      <h2 class="card-text">
      <?php echo $totalOrders; ?>
</h2>
    </div>
    
  </div>
            </div>
           

            <div class="card col-lg-4  mb-3" style="padding:10px;background:#6C22A6;text-align:center; color:#fff">
            <div class="card  " >
    <div class="card-body">
      <h1 class="card-title">Total Earning</h1>
      <h2 class="card-text">
      <p><?php echo "BDT:" . number_format($totalEarnings, 2); ?></p>
</h2>
    </div>
    
  </div>
            </div>
        
</div>


        </div>
</div>


<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/js/bootstrap.min.js"></script>
    <script src="tinymce/tinymce.min.js"></script>
    <script>
        tinymce.init({
            selector: 'textarea'
        });
    </script>
    <!-- toast -->
    <script type="text/javascript" src="https://cdn.jsdelivr.net/npm/toastify-js"></script>
    <script>
    function updateStatus(orderId, newStatus) {
        $.ajax({
            type: 'POST',
            url: 'update_status.php', // Create a new PHP file to handle the AJAX request
            data: { orderId: orderId, newStatus: newStatus },
            success: function (data) {
                // Handle success (e.g., display a success message)
                console.log('Status updated successfully');
            },
            error: function (error) {
                // Handle error (e.g., display an error message)
                console.error('Error updating status:', error);
            }
        });
    }
</script>

</body>

</html>
