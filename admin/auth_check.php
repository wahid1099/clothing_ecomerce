<?php
session_start();

// Check if the user is authenticated
if (!isset($_SESSION["user_role"]) || $_SESSION["user_role"] !== 'admin') {
    // Redirect to the login page
    header("Location: ../index.php");
    exit();
}
?>


