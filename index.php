<?php require_once 'header.php';
$blood=json_decode(bloodList());
?>

<div class="container">
	<!-- <div class="card"> -->
		<div class="row w3-padding-24">
			<div class="col-md-4">
				<div class="form-group">
				    <label for="volume">Volume</label>
				    <select class="form-control" id="volume">
				      <option value="" selected>Select blood volume</option>
						<?php
							for($i=50;$i<=1000;$i+=50){
								echo '<option value="'.$i.'">'.$i.' ml</option>';
							}
						?>
				    </select>
				</div>
			</div>
			<div class="col-md-4">
				<div class="form-group">
				    <label for="blood">Blood Group</label>
				    <select class="form-control" id="blood">
				    	<option value="" selected>Select blood group</option>
						<?php
							for($i=0;$i<sizeof($blood->blood);$i++){
								echo '<option value="'.$blood->blood[$i]->blood_id.'">'.$blood->blood[$i]->blood.'</option>';
							}
						?>
				    </select>
				</div>
			</div>
			<div class="col-md-4">
				<label>Search</label>
				<div class="form-inline my-2 my-lg-0">
			      <input class="form-control mr-sm-2" type="text" placeholder="Hospital name" id="search">
			      <button class="btn btn-outline-primary my-2 my-sm-0" type="submit" id="search_btn">Search</button>
			    </div>
			</div>
		</div>
	<!-- </div> -->
	<div class="row" id="stock_list"></div>
</div>

<?php require_once 'footer.php'; ?>

<script>
$("document").ready(function(){
	$("#tab_home").addClass("active");
	print_data();
})

$("#blood").change(function(){
	print_data();
});

$("#volume").change(function(){
	print_data();
});

$("#search").keyup(function(){
	print_data();
})

function print_data(){
	var blood_id=$("#blood").val();
	var volume=$("#volume").val();
	var search=$("#search").val();
	$.post("api/user/stock/stock_list.php",
	{
		blood_id:blood_id,
		volume:volume,
		search:search,
		limit:50
	},function(data){
		console.log(data);
		var out="";
		var arr=JSON.parse(data);
		if(arr["status"]=="success"){
			for(i=0;i<arr["stock"].length;i++){
				out+='<div class="col-md-3 w3-padding-16">';
					out+='<div class="card w3-light-grey">';
						out+='<div class="card-block">';
							out+='<h4 class="card-title">'+arr["stock"][i]["hospital_name"]+' <span class="badge badge-default">'+arr["stock"][i]["blood"]+'</span></h4>';
							out+='<p class="card-text">Available '+arr["stock"][i]["volume"]+' ml</p>';
							out+='<a href="#" class="btn btn-outline-primary request_blood_btn" data-hospital_id="'+arr["stock"][i]["hospital_id"]+'" data-blood_id="'+arr["stock"][i]["blood_id"]+'">Request blood</a>';
						out+='</div>';
					out+='</div>';
				out+='</div>';
			}
		}else{
			out+='<center><p class="text-danger">'+arr["remark"]+'</p></center>';
		}
		$("#stock_list").html(out);
		request_btn();
	});
}

function request_btn(){
	$.post("api/check_login.php","",function(data){
		console.log(data);
		var arr=JSON.parse(data);
		if(arr["type"]=="hospital"){
			//hopital is login, then disabled this option
			$(".request_blood_btn").addClass("disabled");
		}else if(arr["type"]=="user"){
			// user is login, nothing to do
		}else{
			// no one is login, so enable request btn, and link to login btn
			$(".request_blood_btn").prop("href","login.php");
		}
	});
}

$("body").on("click",".request_blood_btn",function(){
	var hospital_id=$(this).data("hospital_id");
	var blood_id=$(this).data("blood_id");
	var volume=$("#volume").val();

	console.log({hospital_id,blood_id});
	$.post("api/user/request/request_add.php",
	{
		hospital_id:hospital_id,
		blood_id:blood_id,
		volume:volume
	},function(data){
		console.log(data);
		var arr=JSON.parse(data);
		if(arr["status"]=="success"){
			$(".msg").html(show_alert(arr["remark"],"success"));
			print_data();
		}else{
			$(".msg").html(show_alert(arr["remark"],"warning"));
		}
	});
});
</script>