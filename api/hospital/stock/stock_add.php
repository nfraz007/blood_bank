<?php
require_once __DIR__.'/../../../include/config.php';
loginCheckHospital();

$output="";
$hospital_id=$_SESSION["id"];
$blood_id=numOnly($_REQUEST["blood_id"]);
$volume=filter_var($_REQUEST["volume"], FILTER_SANITIZE_STRING);

if(!empty($blood_id) && !empty($volume)){
	if(!is_nan($_REQUEST["volume"])){
		$volume=(int)$volume;
		if(checkBlood($blood_id)){
			$output=stockInsert($hospital_id,$blood_id,$volume);
			if($output) $output='{"status":"success", "remark":"Successfully added/updated"}';
			else $output='{"status":"failure", "remark":"Sorry, There is something problem"}';
		}else{
			$output='{"status":"failure", "remark":"Sorry, Invalid Blood selected"}';
		}
	}else{
		$output='{"status":"failure", "remark":"Volume must be in digit"}';
	}
}else{
	$output='{"status":"failure", "remark":"All field are required"}';
}

echo $output;
mysqli_close($con);
?>