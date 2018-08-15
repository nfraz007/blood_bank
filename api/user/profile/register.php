<?php
require_once __DIR__.'/../../../include/config.php';

$output="";
$username=filter_var($_REQUEST["username"], FILTER_SANITIZE_STRING);
$first_name=filter_var($_REQUEST["first_name"], FILTER_SANITIZE_STRING);
$last_name=filter_var($_REQUEST["last_name"], FILTER_SANITIZE_STRING);
$password=md5($_REQUEST["password"]);
$mobile=numOnly($_REQUEST["mobile"]);
$blood_id=numOnly($_REQUEST["blood_id"]);

if(!PRODUCTION){
	if(!empty($username) && !empty($first_name) && !empty($last_name) && !empty($_REQUEST["password"]) && !empty($_REQUEST["mobile"]) && !empty($_REQUEST["blood_id"])){
		if(strlen($username)>=4 && strlen($first_name)>=4 && strlen($last_name)>=4){
			if(strlen($_REQUEST["password"])>=6 && strlen($_REQUEST["password"])<=12){
				if(strlen($mobile)==10 && strlen($_REQUEST["mobile"])==10){
					if(checkUser($username)){
						if(checkBlood($blood_id)){
							$output=insert_user($username,$first_name,$last_name,$password,$mobile,$blood_id);
							if($output) $output='{"status":"success", "remark":"Successfully Registered, Please login"}';
							else $output='{"status":"failure", "remark":"Sorry, There is something problem"}';
						}else{
							$output='{"status":"failure", "remark":"Sorry, Invalid Blood selected"}';
						}
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
			$output='{"status":"failure", "remark":"Username and First/last name must be atleast 6 characters"}';
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