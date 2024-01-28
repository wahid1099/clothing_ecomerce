<?php
session_start();
session_unset();
session_destroy();

unset($_SESSION['customer_email']);

echo "<script>window.open('login.php','_self')</script>";

include('config.php');

?>
