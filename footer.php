
  <!--  Scripts-->
  <!-- jQuery first, then Tether, then Bootstrap JS. -->
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.1.1/jquery.min.js"></script>
  <!-- <script src="https://code.jquery.com/jquery-3.1.1.slim.min.js" integrity="sha384-A7FZj7v+d/sdmMqp/nOQwliLvUsJfDHW+k9Omg/a/EheAdgtzNs3hpfag6Ed950n" crossorigin="anonymous"></script> -->
  <script src="https://cdnjs.cloudflare.com/ajax/libs/tether/1.4.0/js/tether.min.js" integrity="sha384-DztdAPBWPRXSA/3eYEEUWrWCy7G5KFbe8fFjk5JAIxUYHKkDx6Qin1DkWx51bBrb" crossorigin="anonymous"></script>
  <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0-alpha.6/js/bootstrap.min.js" integrity="sha384-vBWWzlZJ8ea9aCX4pEW3rVHjgjt7zpkNpZk+02D9phzyeVkE+jo0ieGizqPLForn" crossorigin="anonymous"></script>

  </body>
</html>

<script>

//*************************************************************function for set page title************************
function set_page_name(name){
  $("#page_name").html(' / '+name);
}

function show_alert(msg,classname){
  var out="";

  out+='<div class="alert alert-'+classname+' alert-dismissible fade show" role="alert">';
    out+='<button type="button" class="close" data-dismiss="alert" aria-label="Close">';
      out+='<span aria-hidden="true">&times;</span>';
    out+='</button>';
    out+=msg;
  out+='</div>';

  return out;
}

$("body").on("click",".logout", function(){
  $.post("api/logout.php",
  {

  },function(data){
    console.log(data);
    var arr=JSON.parse(data);
    if(arr["status"]=="success"){
      $(".msg").html(show_alert(arr["remark"],"success"));
      window.location="index.php";
    }else{
      $(".msg").html(show_alert(arr["remark"],"warning"));
    }
  })
});
</script>