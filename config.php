<?php
session_start();


$userID = session_id();
$_SESSION['user_id'] = $userID;




if (!isset($_SESSION['customer_email'])) {
    $_SESSION['customer_email'] = 'unset';
} else {
    return;
}



?>