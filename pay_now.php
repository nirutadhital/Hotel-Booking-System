<?php
require 'admin/inc/db_config.php';
require 'admin/inc/essentials.php';
date_default_timezone_set("Asia/Kathmandu");
session_start();

if(!(isset($_SESSION['login']) && $_SESSION['login']==true)) {
    redirect('index.php');
}

if(isset($_POST['pay_now']))
{
    $ORDERID = 'ORD_'.$_SESSION['uId'].random_int(11111,999999);
    $CUST_ID = $_SESSION['uID'];
    $TXN_AMOUNT = $_SESSION['room']['payment'];
    $paramList=array();

    // Perform any necessary actions with the order and payer IDs
    // Example: Update your database, send a confirmation email, etc.

    // Send a response to the AJAX call
    $response = ['success' => true, 'message' => 'Payment completed successfully'];
    echo json_encode($response);
}
?>
