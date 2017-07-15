<?php
require_once '../include/config.php';

if(isset($_SESSION["type"]) && $_SESSION["type"]=="user" && isset($_SESSION["id"]) && !empty($_SESSION["id"])){
    $output='{"type":"user"}';
}elseif(isset($_SESSION["type"]) && $_SESSION["type"]=="hospital" && isset($_SESSION["id"]) && !empty($_SESSION["id"])){
	$output='{"type":"hospital"}';
}else{
    $output='{"type":""}';
}

echo $output;

mysqli_close($con);
?>