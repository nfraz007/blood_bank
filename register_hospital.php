<?php require_once 'header.php';?>

<div class="container">
	<div class="row">
		<div class="col-md-3"></div>
		<div class="col-md-6 w3-light-grey w3-border w3-padding-16">
		  <div class="w3-padding-24"><h2>Hospital Register</h2></div>
		  <div class="form-group">
		    <label for="username">Username</label>
		    <input type="text" class="form-control register" id="username" aria-describedby="usernameHelp" placeholder="Enter username">
		    <small id="usernameHelp" class="form-text text-muted">Username is your unique identity which is used for login.<span id="check_hospital"></span></small>
		  </div>
		  <div class="form-group">
		    <label for="hospital_name">Hospital Name</label>
		    <input type="text" class="form-control register" id="hospital_name" placeholder="Enter name of hospital">
		  </div>
		  <div class="form-group">
		    <label for="password">Password</label>
		    <input type="password" class="form-control register" id="password" placeholder="Password must be atleast 6 characters long">
		  </div>
		  <div class="form-group">
			  <label for="mobile">Mobile</label>
			  <input type="tel" class="form-control register" id="mobile" placeholder="Enter 10 digit mobile number">
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
	$.post("api/hospital/profile/check_username.php",
	{
		username:username
	},function(data){
		// console.log(data);
		$("#check_hospital").removeClass();
		if(data==true){
			$("#check_hospital").text(" ( Available )");
			$("#check_hospital").addClass("text-success");
		}else{
			$("#check_hospital").text(" ( Not Available )");
			$("#check_hospital").addClass("text-danger");
		}
	});
});

$("#register").click(function(){
	$.post("api/hospital/profile/register.php",
	{
		username:$("#username").val(),
		hospital_name:$("#hospital_name").val(),
		password:$("#password").val(),
		mobile:$("#mobile").val()
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