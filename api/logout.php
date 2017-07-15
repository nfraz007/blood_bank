<?php
session_start();
unset($_SESSION['type']);
unset($_SESSION['id']);
session_destroy();

$output='{"status":"success", "remark":"Successfully Logout"}';
echo $output;
?>