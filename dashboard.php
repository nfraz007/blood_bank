<?php require_once 'header.php';
loginCheckHospitalRedirect();
$blood=json_decode(bloodList());
?>
<div class="container">
	<div class="row">
		<div class="col-md-12">
			<h3>Available Blood Stock</h3>
		</div>
	</div>
	<div class="row">
		<div class="col-md-12">
			<span>If you want to add/update your blood stock, then click here</span>
			<a class="btn btn-outline-primary" data-toggle="collapse" href="#stock_add" aria-expanded="false" aria-controls="stock_add">Add/Update</a>
		</div>
	</div><br>
	<div class="collapse" id="stock_add">
	  	<div class="row w3-bottombar w3-topbar w3-light-grey w3-padding-16">
		    <div class="col-md-4">
		    	<div class="form-group">
				    <label for="blood">Blood Group</label>
				    <select class="form-control" id="blood_id">
				      <?php
				      	for($i=0;$i<sizeof($blood->blood);$i++){
				      		echo '<option value="'.$blood->blood[$i]->blood_id.'">'.$blood->blood[$i]->blood.'</option>';
				      	}
				      ?>
				    </select>
				</div>
		    </div>
		    <div class="col-md-4">
				<div class="form-group">
				  <label for="volume">Volume</label>
				  <input type="tel" class="form-control stock" id="volume" placeholder="Enter volume in ml">
			    </div>
		    </div>
		    <div class="col-md-4">
		    	<br>
				<a class="btn btn-outline-primary" href="#" id="stock_add_btn">Add/Update</a>
		    </div>
	    </div>
	</div>
	<div class="row" id="stock_list"></div>
	<h3>Blood Request</h3>
	<p>Latest 10 Blood request by the user. Contact them as soon as possible</p>
	<div class="row" id="request_list"></div>
</div>

<?php require_once 'footer.php'; ?>

<script>
$("document").ready(function(){
	$("#tab_dashboard").addClass("active");
	print_data();
});

function print_data(){
	print_stock();
	print_request();
}

function print_stock(){
	$.post("api/hospital/stock/stock_list.php",
	{

	},function(data){
		console.log(data);
		var out="";
		var arr=JSON.parse(data);
		if(arr["status"]=="success"){
			for(i=0;i<arr["stock"].length;i++){
				out+='<div class="col-md-2 w3-padding-16">';
					out+='<div class="card w3-light-grey">';
						out+='<div class="card-block">';
						out+='<h2 class="card-title text-center">'+arr["stock"][i]["blood"]+'</h2>';
						out+='<h5 class="card-subtitle text-center mb-2 text-muted"><span class="badge badge-default">'+arr["stock"][i]["volume"]+' ml</span></h5>';
						//out+='<p class="card-text">'+arr["stock"][i]["detail"]+'</p>';
						out+='</div>';
					out+='</div>';
				out+='</div>';
			}
		}else{
			out+='<center><p class="text-danger">'+arr["remark"]+'</p></center>';
		}
		$("#stock_list").html(out);
	})
}

$('.stock').keypress(function(e){
    if(e.which == 13){//Enter key pressed
        $('#stock_add_btn').click();//Trigger search button click event
    }
});

$("#stock_add_btn").click(function(){
	$.post("api/hospital/stock/stock_add.php",
	{
		blood_id:$("#blood_id").val(),
		volume:$("#volume").val()
	},function(data){
		console.log(data);
		var arr=JSON.parse(data);
		if(arr["status"]=="success"){
			$(".msg").html(show_alert(arr["remark"],"success"));
			print_stock();
		}else{
			$(".msg").html(show_alert(arr["remark"],"warning"));
		}
	})
});

function print_request(){
	$.post("api/hospital/request/request_list.php",
	{
		limit:20
	},function(data){
		console.log(data);
		var out="";
		var arr=JSON.parse(data);
		if(arr["status"]=="success"){
			for(i=0;i<arr["request"].length;i++){
				out+='<div class="col-md-3 w3-padding-16">';
					out+='<div class="card">';
						out+='<div class="card-block">';
							out+='<h4 class="card-title">'+arr["request"][i]["first_name"]+' '+arr["request"][i]["last_name"]+'</h4>';
							out+='<p class="card-text">I need an urgent requirement of '+arr["request"][i]["volume"]+' ml, '+arr["request"][i]["blood"]+' blood. Please Contact me.</p>';
							out+='<p class="card-text w3-small w3-text-grey">'+arr["request"][i]["datetime"]+'</p>';
							out+='<button class="btn btn-outline-primary">'+arr["request"][i]["user_mobile"]+'</button>';
						out+='</div>';
					out+='</div>';
				out+='</div>';
			}
		}else{
			out+='<center><p class="text-danger">'+arr["remark"]+'</p></center>';
		}
		$("#request_list").html(out);
	})
}

</script>