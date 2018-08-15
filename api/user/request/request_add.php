<?php
require_once __DIR__.'/../../../include/config.php';
loginCheckUser();

$output="";
$user_id=$_SESSION["id"];
$hospital_id=numOnly($_REQUEST["hospital_id"]);
$blood_id=numOnly($_REQUEST["blood_id"]);
$volume=filter_var($_REQUEST["volume"], FILTER_SANITIZE_STRING);

if(!empty($hospital_id) && !empty($blood_id) && !empty($volume)){
	if(!is_nan($_REQUEST["volume"])){
		$volume=(int)$volume;
		if(checkBlood($blood_id)){
			if(checkHospitalId($hospital_id)){
				if(checkStock($hospital_id,$blood_id,$volume)){
					$output=requestInsert($user_id,$hospital_id,$blood_id,$volume);
					if($output) $output='{"status":"success", "remark":"Successfully sent the request"}';
					else $output='{"status":"failure", "remark":"Sorry, There is something problem"}';
				}else{
					$output='{"status":"failure", "remark":"Sorry, stock is not available"}';
				}
			}else{
				$output='{"status":"failure", "remark":"Sorry, Invalid Hospital selected"}';
			}
		}else{
			$output='{"status":"failure", "remark":"Sorry, Invalid Blood selected"}';
		}
	}else{
		$output='{"status":"failure", "remark":"Volume must be in digit"}';
	}
}else{
	$output='{"status":"failure", "remark":"Please select your volume requirement."}';
}

echo $output;
mysqli_close($con);
?>