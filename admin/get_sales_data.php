<?php
// Check connection
include('../db.php');

// Fetch sales data
$query = "SELECT date, order_price FROM  orders";
$result = mysqli_query($con, $query);

// Check for errors in the query
if (!$result) {
    die("Query failed: " . mysqli_error($con));
}

// Fetch data as an associative array
$salesData = [];
while ($row = mysqli_fetch_assoc($result)) {
    $salesData[] = $row;
}

// Free the result set
mysqli_free_result($result);

// Close the database connection
mysqli_close($con);

// Output sales data as JSON
echo json_encode($salesData);
?>