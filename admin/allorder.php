<?php
 // Start the session
include('../db.php');
include("auth_check.php");

// Fetch all products from the database
$query = "SELECT * FROM orders";
$result = mysqli_query($con, $query);



// Check for errors in the query
if (!$result) {
    die("Query failed: " . mysqli_error($con));
}
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
        <div class="col-lg-12" id="main">
        <h1>All Orders</h1>
        <table class="table table-striped table-bordered">
    <thead>
        <tr>
            <th scope="col">Order ID</th>
            <th scope="col">Customer Name</th>
            <th scope="col">Adress</th>
            <th scope="col">Phone No</th>
            <th scope="col">Total Price</th>
            <th scope="col">Product Id's</th>
            <th scope="col">Date</th>
            <th scope="col">Status</th>
            <th scope="col">Action</th>
        </tr>
    </thead>
    <tbody>
        <?php
        // Fetch orders from the database
        $query = "SELECT * FROM orders";
        $result = mysqli_query($con, $query);

        // Loop through the orders and display them in the table
        while ($row = mysqli_fetch_assoc($result)) {
            
            echo '<tr>';
            echo '<td>' . $row['order_id'] . '</td>';
            echo '<td>' . $row['customer_name'] . '</td>';
            echo '<td>' . $row['customer_address'] . '</td>';
            echo '<td>' . $row['customer_phone'] . '</td>';
            echo '<td>' . $row['order_price'] . '</td>';
            echo '<td>' . $row['product_id'] . '</td>';
            echo '<td>' . $row['date'] . '</td>';
            echo '<td>' . $row['status'] . '</td>';
            
            echo '<td>';
            echo '<select class="form-control" id="statusDropdown" onchange="updateStatus(' . $row['order_id'] . ', this.value)"';
            if ($row['status'] == 'Delivered') {
                echo ' disabled'; // Disable the dropdown if status is 'Delivered'
            }
            echo '>';
            echo '<option value="Pending" ' . ($row['status'] == 'Pending' ? 'selected' : '') . '>Pending</option>';
            echo '<option value="Shipped" ' . ($row['status'] == 'Shipped' ? 'selected' : '') . '>Shipped</option>';
            echo '<option value="Delivered" ' . ($row['status'] == 'Delivered' ? 'selected' : '') . '>Delivered</option>';
            // Add more status options as needed
            echo '</select>';
            echo '</td>';
            echo '</tr>';
        }

        // Free the result set
        mysqli_free_result($result);
        ?>
    </tbody>
</table>


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
        url: 'update_status.php',
        data: { orderId: orderId, newStatus: newStatus },
        success: function (data) {
            // Handle success (e.g., display a success message)
            console.log('Status updated successfully');
            showToast('Status updated successfully');
            setTimeout(function () {
                location.reload(); // Reload the page after a delay
            }, 1000); // 1000 milliseconds = 1 second
        },
        error: function (error) {
            // Handle error (e.g., display an error message)
            console.error('Error updating status:', error);
            showToast('Error updating status');
        }
    });
}

function showToast(message) {
    Toastify({
        text: message,
        duration: 3000, // 3 seconds
        gravity: 'bottom', // Display the toast at the bottom
        position: 'center', // Center the toast horizontally
        backgroundColor: 'linear-gradient(to right, #00b09b, #96c93d)', // Set your preferred background color
    }).showToast();
}
</script>


</body>

</html>
