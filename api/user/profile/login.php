<?php
require_once __DIR__.'/../../../include/config.php';

$output="";
$username=filter_var($_REQUEST["username"], FILTER_SANITIZE_STRING);
$password=md5($_REQUEST["password"]);

if(!empty($username) && !empty($_REQUEST["password"])){
	if(strlen($username)>=4){
		if(strlen($_REQUEST["password"])>=6 && strlen($_REQUEST["password"])<=12){
			$query="select * from ".prefix("user")." where username='{$username}' and password='{$password}'";
			$result=mysqli_query($con,$query);
			if(mysqli_num_rows($result)==1){
				$row=mysqli_fetch_assoc($result);
				$_SESSION["id"]=$row["user_id"];
				$_SESSION["type"]="user";
				$output='{"status":"success", "remark":"Successfully login"}';
			}else{
				$output='{"status":"failure", "remark":"Invalid Username or Password"}';
			}
		}else{
			$output='{"status":"failure", "remark":"Password must be 6-12 characters long"}';
		}
	}else{
		$output='{"status":"failure", "remark":"Username must be atleast 6 characters"}';
	}
}else{
	$output='{"status":"failure", "remark":"All field are required"}';
}

echo $output;
mysqli_close($con);
?>