<?php
    session_start();
    
    // db configration
    $server="localhost";
    $username="root";
    $password="";
    $database="blood_bank";
       
    date_default_timezone_set('Asia/Kolkata');
    $con=mysqli_connect($server,$username,$password,$database) or die ("could not connect to mysql");

    // some global value
    $DATETIME_FORMAT="l, M j, Y @ g:ia";
    $HOSTNAME="http://localhost/blood_bank";
    $COMPANY_NAME="Blood Bank";
    $COMPANY_ADDRESS="Mysuru";
    $COMPANY_MOBILE="+91 9748277144";
    $COMPANY_EMAIL="nfraz007@gmail.com";

    require_once 'function.php';
?>