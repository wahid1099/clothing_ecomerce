<?php
 // Start the session
include('../db.php');
include("auth_check.php");

// Fetch all products from the database
$query = "SELECT * FROM category ORDER BY cat_id DESC";

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
        <h1>All Category</h1>
        <table class="table table-striped table-bordered">
    <thead>
        <tr>
            <th scope="col">Category ID</th>
            <th scope="col">Category Name</th>
            <th scope="col">Category Description</th>
           
          
        </tr>
    </thead>
    <tbody>
        <?php
        // Fetch orders from the database
        // $query = "SELECT * FROM orders";
        // $result = mysqli_query($con, $query);

        // Loop through the orders and display them in the table
        while ($row = mysqli_fetch_assoc($result)) {
            
            echo '<tr>';
            echo '<td>' . $row['cat_id'] . '</td>';
            echo '<td>' . $row['cat_title'] . '</td>';
            echo '<td>' . $row['cat_desc'] . '</td>';
           
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


</body>

</html>
