<?php

function  upload_file($myfile,$dir,$max_file_size=102400)
{
    $error=0;
    $obj=new stdClass();
    $file_name=rinse(time().$_FILES[$myfile]['name']);
    $file_name=str_replace(" ", "", $file_name);
    $file_add=$_FILES[$myfile]['tmp_name'];
    
    $file_size = $_FILES[$myfile]['size'];
    if ($_FILES[$myfile]['error'] !== UPLOAD_ERR_OK) 
    {
       $error=1;
       $message="File not uploaded properly.";
    }
    elseif (($file_size > $max_file_size))
    {      
        $message = 'File too large. File must be within '.($max_file_size/1024).' KB.'; 
        $error=1;
     }

     $info = getimagesize($_FILES[$myfile]['tmp_name']);
    if ($info === FALSE) 
    {
       $error=1;
       $message="Unable to determine image type of uploaded file";
    }

    if (($info[2] !== IMAGETYPE_JPEG) && ($info[2] !== IMAGETYPE_PNG)) 
    {
       $error=1;
       $message="Only JPEG or PNG image allowed";
    }
    
    if($error==0)
    {
        if(move_uploaded_file($file_add,$dir."/".$file_name))
        {
            $message="file uploaded succesfuly";
        }
        else
        {
            $message = $_FILES[$myfile]['error'];
            $error=1;
                // $message=$dir;
        }
    }
    $obj->error=$error;
    $obj->message=$message;
    $obj->file_name=$file_name;

    return $obj;
  
}

function  upload_file_modified($myfile,$dir,$max_file_size=102400,$i)
{
    
    $error=0;
    $obj=new stdClass();
    $file_name=rinse(time().$_FILES[$myfile]['name'][$i]);
    $file_name=str_replace(" ", "", $file_name);
    $file_add=$_FILES[$myfile]['tmp_name'][$i];
    
    $file_size = $_FILES[$myfile]['size'][$i];
    if ($_FILES[$myfile]['error'][$i] !== UPLOAD_ERR_OK) 
    {
       $error=1;
       $message="File not uploaded properly.";
    }
    elseif (($file_size > $max_file_size))
    {      
        $message = 'File too large. File must be within '.($max_file_size/1024).' KB.'; 
        $error=1;
     }

    $info = getimagesize($_FILES[$myfile]['tmp_name'][$i]);
    $mime   = $info['mime'];
  
    if ($info === FALSE) 
    {
       $error=1;
       $message="Unable to determine image type of uploaded file";
    }
    
    if (($info[2] !== IMAGETYPE_JPEG) && ($info[2] !== IMAGETYPE_PNG)) 
    {
       $error=1;
       $message="Only JPEG or PNG image allowed";
    }
    
    if($error==0)
    {
        if(move_uploaded_file($file_add,$dir."/".$file_name))
        {
            $message="file uploaded succesfuly";
        }
        else
        {
            $message = $_FILES[$myfile]['error'];
            $error=1;
                // $message=$dir;
        }
    }
    $obj->error=$error;
    $obj->message=$message;
    $obj->file_name=$file_name;

    return $obj;
  
}


function deleteImage($path)
{
    global $hostname;
    $new_path=str_replace($hostname, "", $path);
    if(strlen($new_path)!=0)
    {
        return unlink("../../".$new_path);
        // return "inside";
    }
    return "0";
}
        
function redirect_to( $location = NULL ) {
    if ($location != NULL) {
      header("Location: {$location}");
      exit;
    }
}

function clean($input)
 {
  return preg_replace('/[^A-Za-z0-9 ]/', '', $input); // Removes special chars.
 }
function rinse($input)
{
    return preg_replace('/[^A-Za-z0-9\-,@.\ ]/', '', $input); // Removes special chars.
}

 function numOnly($input)
 {
  return preg_replace('/[^0-9]/', '', $input); // Removes special chars.
 }

function securityToken(){
    $characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
        $randstring = '';
        for ($i = 0; $i < 10; $i++) {
            $randstring.=$characters[rand(0, strlen($characters))];
        }
        return $randstring;
}

function loginCheckHospital()
{
    global $con;

    if(isset($_SESSION["type"]) && $_SESSION["type"]=="hospital" && isset($_SESSION["id"]) && !empty($_SESSION["id"])){
        $output='{"status":"success"}';
    }else{
        $output='{"status":"failure","remark":"You are not login, Please login"}';
    }

    $obj=json_decode($output,true);

    if($obj['status']!="success")
        die($output);
}

function loginCheckUser()
{
    global $con;

    if(isset($_SESSION["type"]) && $_SESSION["type"]=="user" && isset($_SESSION["id"]) && !empty($_SESSION["id"])){
        $output='{"status":"success"}';
    }else{
        $output='{"status":"failure","remark":"You are not login, Please login"}';
    }

    $obj=json_decode($output,true);

    if($obj['status']!="success")
        die($output);
}

function loginCheckHospitalRedirect()
{
    if(isset($_SESSION["type"]) && $_SESSION["type"]=="hospital" && isset($_SESSION["id"]) && !empty($_SESSION["id"])){
    
    }else{
        header('Location: index.php');
    }
}

function checkHospital($username){
    global $con;

    $query="select count(*) as count from ".prefix("hospital")." where username='{$username}'";
    $result=mysqli_query($con,$query);
    if($result){
        $row=mysqli_fetch_assoc($result);
        if($row["count"]==0) return true;
        else return false;
    }else{
        return false;
    }
}

function checkHospitalId($hospital_id){
    global $con;

    $query="select count(*) as count from ".prefix("hospital")." where hospital_id='{$hospital_id}'";
    $result=mysqli_query($con,$query);
    if($result){
        $row=mysqli_fetch_assoc($result);
        if($row["count"]==1) return true;
        else return false;
    }else{
        return false;
    }
}

function getUsernameHospital($id){
    global $con;

    $query="select username from ".prefix("hospital")." where hospital_id='{$id}'";
    $result=mysqli_query($con,$query);
    if(mysqli_num_rows($result)==1){
        $row=mysqli_fetch_assoc($result);
        return $row["username"];
    }else{
        return 'Error';
    }
}

function insert_hospital($username,$hospital_name,$password,$mobile){
    global $con;

    $datetime=date("Y-m-d H:i:s");
    $status=1;
    $query="insert into ".prefix("hospital")." (username,hospital_name,password,mobile,datetime,status) values ('{$username}','{$hospital_name}','{$password}','{$mobile}','{$datetime}','{$status}') ";
    $result=mysqli_query($con,$query);
    if($result) return true;
    else return false;
}

function checkUser($username){
    global $con;

    $query="select count(*) as count from ".prefix("user")." where username='{$username}'";
    $result=mysqli_query($con,$query);
    if($result){
        $row=mysqli_fetch_assoc($result);
        if($row["count"]==0) return true;
        else return false;
    }else{
        return false;
    }
}

function getUsernameUser($id){
    global $con;

    $query="select username from ".prefix("user")." where user_id='{$id}'";
    $result=mysqli_query($con,$query);
    if(mysqli_num_rows($result)==1){
        $row=mysqli_fetch_assoc($result);
        return $row["username"];
    }else{
        return 'Error';
    }
}

function insert_user($username,$first_name,$last_name,$password,$mobile,$blood_id){
    global $con;

    $datetime=date("Y-m-d H:i:s");
    $status=1;
    $query="insert into ".prefix("user")." (username,first_name,last_name,password,mobile,blood_id,datetime,status) values ('{$username}','{$first_name}','{$last_name}','{$password}','{$mobile}','{$blood_id}','{$datetime}','{$status}') ";
    $result=mysqli_query($con,$query);
    if($result) return true;
    else return false;
}

function checkBlood($blood_id){
    global $con;

    $query="select count(*) as count from ".prefix("blood")." where blood_id='{$blood_id}'";
    $result=mysqli_query($con,$query);
    if($result){
        $row=mysqli_fetch_assoc($result);
        if($row["count"]==1) return true;
        else return false;
    }else{
        return false;
    }
}

function bloodList(){
    global $con;

    $blood=array();
    $query="select * from ".prefix('blood')." where `status`='1'";
    $result=mysqli_query($con,$query);
    if(mysqli_num_rows($result)>0){
        $output='{"status":"success","blood":';
        while ($row=mysqli_fetch_assoc($result)) {
            $blood[] = $row;
        }
        $output.=json_encode($blood).'}';
    }else{
        $output='{"status":"failure","remark":"No currency return"}';
    }
    return $output;
}

function checkStock($hospital_id,$blood_id,$volume){
    global $con;

    $query="select volume from ".prefix("stock")." where hospital_id='{$hospital_id}' and blood_id='{$blood_id}'";
    $result=mysqli_query($con,$query);
    if(mysqli_num_rows($result)==1){
        $row=mysqli_fetch_assoc($result);
        if((int)$row["volume"]>=$volume) return true;
        else return false;
    }else{
        return false;
    }
}

function stockList($obj){
    global $con;

    $stock=array();
    $query="select s.stock_id,s.hospital_id,h.hospital_name,s.blood_id,b.blood,b.detail,s.volume from ".prefix("stock")." s left join ".prefix("blood")." b on s.blood_id=b.blood_id left join ".prefix("hospital")." h on s.hospital_id=h.hospital_id where ";

    if(isset($obj->status) && $obj->status!=""){
     $query.= "s.`status` = ".$obj->status." and ";
    }

    if(isset($obj->hospital_id) && $obj->hospital_id!=""){
     $query.= "s.`hospital_id` = ".$obj->hospital_id." and ";
    }

    if(isset($obj->blood_id) && $obj->blood_id!=""){
     $query.= "s.`blood_id` = ".$obj->blood_id." and ";
    }

    if (isset($obj->search)  && $obj->search!=""){
        $search = clean($obj->search);
        $query.="( h.hospital_name like '%".$search."%' ) and ";
    }

    if(isset($obj->volume) && $obj->volume!=""){
     $query.= "s.`volume` >= ".(int)$obj->volume." and ";
    }

    $query.="1 order by b.`blood` asc ";

    if(isset($obj->limit) && $obj->limit!=0){
        $limit=$obj->limit;
    }else{
        $limit=10;
    }

    if(isset($obj->page) && $obj->page!=0){
        $page=$obj->page;
    }else{
        $page=1;
    }

    $query.=" limit {$limit} offset ".(($page-1)*$limit);
    $result = mysqli_query($con,$query);

    if(mysqli_num_rows($result) > 0){
        while ($row = mysqli_fetch_assoc($result))
        {
            $stock[] = $row;
        }
        $output='{"status":"success","stock":';
        $output.=json_encode($stock);
        $output.="}";
    }else{
         $output='{"status":"failure","remark":"No Stock found"}';
    }
    return $output;
}

function stockInsert($hospital_id,$blood_id,$volume){
    global $con;

    $query="select * from ".prefix("stock")." where hospital_id='{$hospital_id}' and blood_id='{$blood_id}'";
    $result=mysqli_query($con,$query);
    $count=mysqli_num_rows($result);
    if($count==1){
        //stock is present, so update it
        $row=mysqli_fetch_assoc($result);
        $stock_id=$row["stock_id"];
        $query="update ".prefix("stock")." set volume=volume+{$volume} where stock_id='{$stock_id}'";
        $result=mysqli_query($con,$query);
        if($result){
            return true;
        }else{
            return false;
        }
    }elseif($count==0){
        // stock is not present, so insert
        $status=1;
        $query="insert into ".prefix("stock")." (hospital_id,blood_id,volume,status) values ('{$hospital_id}','{$blood_id}','{$volume}','{$status}')";
        $result=mysqli_query($con,$query);
        if($result){
            return true;
        }else{
            return false;
        }
    }else{
        //present more than one, through error
        return false;
    }
}

function requestInsert($user_id,$hospital_id,$blood_id,$volume){
    global $con;

    $datetime=date("Y-m-d H:i:s");
    $status=1;
    $query="insert into ".prefix("request")." (user_id,hospital_id,blood_id,volume,datetime,status) values ('{$user_id}','{$hospital_id}','{$blood_id}','{$volume}','{$datetime}','{$status}')";
    $result=mysqli_query($con,$query);
    if($result){
        return true;
    }else{
        return false;
    }
}

function requestList($obj){
    global $con,$DATETIME_FORMAT;

    $request=array();
    $query="select r.*,h.hospital_name,h.mobile as hospital_mobile,u.first_name,u.last_name,u.mobile as user_mobile,b.blood from ".prefix("request")." r left join ".prefix("hospital")." h on r.hospital_id=h.hospital_id left join ".prefix("user")." u on r.user_id=u.user_id left join ".prefix("blood")." b on r.blood_id=b.blood_id where ";

    if(isset($obj->status) && $obj->status!=""){
     $query.= "r.`status` = ".$obj->status." and ";
    }

    if(isset($obj->hospital_id) && $obj->hospital_id!=""){
     $query.= "h.`hospital_id` = ".$obj->hospital_id." and ";
    }

    if(isset($obj->user_id) && $obj->user_id!=""){
     $query.= "u.`user_id` = ".$obj->user_id." and ";
    }

    if(isset($obj->blood_id) && $obj->blood_id!=""){
     $query.= "b.`blood_id` = ".$obj->blood_id." and ";
    }

    $query.="1 order by r.`datetime` desc ";

    if(isset($obj->limit) && $obj->limit!=0){
        $limit=$obj->limit;
    }else{
        $limit=10;
    }

    if(isset($obj->page) && $obj->page!=0){
        $page=$obj->page;
    }else{
        $page=1;
    }

    $query.=" limit {$limit} offset ".(($page-1)*$limit);
    $result = mysqli_query($con,$query);

    if(mysqli_num_rows($result) > 0){
        while ($row = mysqli_fetch_assoc($result))
        {
            $row["datetime"]=date($DATETIME_FORMAT,strtotime($row["datetime"]));
            $request[] = $row;
        }
        $output='{"status":"success","request":';
        $output.=json_encode($request);
        $output.="}";
    }else{
         $output='{"status":"failure","remark":"No Blood Request found"}';
    }
    return $output;
}

function crypto($action, $string) {
    //for encrypt e, for decrypt d
    $output = false;

    $encrypt_method = "AES-256-CBC";
    $secret_key = 'askjhSVSanckanSVSja353aRG5aSGSSasdSaSGSGSGsS3Sf5adS';
    $secret_iv = '3S5S53sgsgssdJgs5gs3gHs6sg5shfg3fJfdJhdh3Hdfgfh2hds';

    // hash
    $key = hash('sha256', $secret_key);
    
    // iv - encrypt method AES-256-CBC expects 16 bytes - else you will get a warning
    $iv = substr(hash('sha256', $secret_iv), 0, 16);

    if( $action == 'encrypt' || $action=="e" ) {
        $output = openssl_encrypt($string, $encrypt_method, $key, 0, $iv);
        $output = base64_encode($output);
    }
    else if( $action == 'decrypt' || $action=="d" ){
        $output = openssl_decrypt(base64_decode($string), $encrypt_method, $key, 0, $iv);
    }
    return $output;
}

function prefix($table = ""){
    return PREFIX.$table;
}

?>