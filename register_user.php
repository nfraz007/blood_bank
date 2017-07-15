<?php require_once 'header.php';
$blood=json_decode(bloodList());
?>

<div class="container">
	<div class="row">
		<div class="col-md-3"></div>
		<div class="col-md-6 w3-light-grey w3-border w3-padding-16">
		  <div class="w3-padding-24"><h2>Reciever/User Register</h2></div>
		  <div class="form-group">
		    <label for="username">Username</label>
		    <input type="text" class="form-control register" id="username" aria-describedby="usernameHelp" placeholder="Enter username">
		    <small id="usernameHelp" class="form-text text-muted">Username is your unique identity which is used for login.<span id="check_user"></span></small>
		  </div>
		  <div class="row">
		  	<div class="form-group col-md-6">
			    <label for="first_name">First Name</label>
			    <input type="text" class="form-control register" id="first_name" placeholder="Enter First Name">
			  </div>
			  <div class="form-group col-md-6">
			    <label for="last_name">Last Name</label>
			    <input type="text" class="form-control register" id="last_name" placeholder="Enter Last Name">
			  </div>
		  </div>
		  <div class="form-group">
		    <label for="password">Password</label>
		    <input type="password" class="form-control register" id="password" placeholder="Password must be atleast 6 characters long">
		  </div>
		  <div class="form-group">
			  <label for="mobile">Mobile</label>
			  <input type="tel" class="form-control register" id="mobile" placeholder="Enter 10 digit mobile number">
		  </div>
		  <div class="form-group">
		    <label for="blood">Blood Group</label>
		    <select class="form-control" id="blood">
		      <?php
		      	for($i=0;$i<sizeof($blood->blood);$i++){
		      		echo '<option value="'.$blood->blood[$i]->blood_id.'">'.$blood->blood[$i]->blood.'</option>';
		      	}
		      ?>
		    </select>
		  </div>
		  <a href="#" class="btn btn-outline-primary" id="register">Register</a>
		</div>
		<div class="col-md-3"></div>
	</div>
</div>

<?php require_once 'footer.php'; ?>

<script>
$("document").ready(function(){
	$("#tab_register").addClass("active");
});

$('.register').keypress(function(e){
    if(e.which == 13){//Enter key pressed
        $('#register').click();//Trigger search button click event
    }
});

$("#username").blur(function(){
	var username=$("#username").val();
	$.post("api/user/profile/check_username.php",
	{
		username:username
	},function(data){
		// console.log(data);
		$("#check_user").removeClass();
		if(data==true){
			$("#check_user").text(" ( Available )");
			$("#check_user").addClass("text-success");
		}else{
			$("#check_user").text(" ( Not Available )");
			$("#check_user").addClass("text-danger");
		}
	});
});

$("#register").click(function(){
	$.post("api/user/profile/register.php",
	{
		username:$("#username").val(),
		first_name:$("#first_name").val(),
		last_name:$("#last_name").val(),
		password:$("#password").val(),
		mobile:$("#mobile").val(),
		blood_id:$("#blood").val()
	},function(data){
		console.log(data);
		var arr=JSON.parse(data);
		if(arr["status"]=="success"){
			$(".msg").html(show_alert(arr["remark"],"success"));
		}else{
			$(".msg").html(show_alert(arr["remark"],"warning"));
		}
	})
});
</script>