<?php
require_once __DIR__.'/../../../include/config.php';

$obj=(object)$_REQUEST;
$data=stockList($obj);

echo $data;

mysqli_close($con);
?>