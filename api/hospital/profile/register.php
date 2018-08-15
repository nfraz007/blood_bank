<?php
require_once __DIR__.'/../../../include/config.php';

$output="";
$username=filter_var($_REQUEST["username"], FILTER_SANITIZE_STRING);
$hospital_name=filter_var($_REQUEST["hospital_name"], FILTER_SANITIZE_STRING);
$password=md5($_REQUEST["password"]);
$mobile=numOnly($_REQUEST["mobile"]);

if(!PRODUCTION){
	if(!empty($username) && !empty($hospital_name) && !empty($_REQUEST["password"]) && !empty($_REQUEST["mobile"])){
		if(strlen($username)>=4 && strlen($hospital_name)>=4){
			if(strlen($_REQUEST["password"])>=6 && strlen($_REQUEST["password"])<=12){
				if(strlen($mobile)==10 && strlen($_REQUEST["mobile"])==10){
					if(checkHospital($username)){
						$output=insert_hospital($username,$hospital_name,$password,$mobile);
						if($output) $output='{"status":"success", "remark":"Successfully Registered, Please login"}';
						else $output='{"status":"failure", "remark":"Sorry, There is something problem"}';
					}else{
						$output='{"status":"failure", "remark":"Username exist, choose another one"}';
					}
				}else{
					$output='{"status":"failure", "remark":"Mobile must be 10 digit long"}';
				}
			}else{
				$output='{"status":"failure", "remark":"Password must be 6-12 characters long"}';
			}
		}else{
			$output='{"status":"failure", "remark":"Username and hospital must be atleast 6 characters"}';
		}
	}else{
		$output='{"status":"failure", "remark":"All field are required"}';
	}
}else{
	$output='{"status":"failure", "remark":"This feature is disabled."}';
}

echo $output;
mysqli_close($con);
?>