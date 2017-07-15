<?php require_once 'include/config.php';?>

<!DOCTYPE html>
<html lang="en">
<head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <title><?=$COMPANY_NAME?></title>

    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0-alpha.6/css/bootstrap.min.css" integrity="sha384-rwoIResjU2yc3z8GV/NPeZWAv56rSmLldC3R/AZzGRnGxQQKnKkoFVhFQhNUwEyJ" crossorigin="anonymous">
    <!-- W3css -->
    <link rel="stylesheet" href="https://www.w3schools.com/lib/w3.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
</head>
<body>
  	<nav class="navbar navbar-toggleable-md navbar-light bg-faded">
	  <button class="navbar-toggler navbar-toggler-right" type="button" data-toggle="collapse" data-target="#navbarNavDropdown" aria-controls="navbarNavDropdown" aria-expanded="false" aria-label="Toggle navigation">
	    <span class="navbar-toggler-icon"></span>
	  </button>
	  <a class="navbar-brand" href="index.php"><?=$COMPANY_NAME?></a>
	  <div class="collapse navbar-collapse" id="navbarNavDropdown">
	    <ul class="navbar-nav">
	    	<?php
	    		$out="";
	    		if(isset($_SESSION["type"]) && $_SESSION["type"]=="hospital" && isset($_SESSION["id"]) && !empty($_SESSION["id"])){
	    			//hospital is login 
	    			$username=getUsernameHospital($_SESSION["id"]);
	    			$out.='<li class="nav-item" id="tab_dashboard">';
						$out.='<a class="nav-link" href="dashboard.php">Dashboard</a>';
					$out.='</li>';
	    			$out.='<li class="nav-item dropdown" id="tab_profile">';
				        $out.='<a class="nav-link dropdown-toggle" href="http://example.com" id="navbarDropdownMenuLink" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">Hello '.$username.'</a>';
				        $out.='<div class="dropdown-menu" aria-labelledby="navbarDropdownMenuLink">';
				        	$out.='<a class="dropdown-item logout" href="#">Logout</a>';
				        $out.='</div>';
				    $out.='</li>';
	    		}elseif(isset($_SESSION["type"]) && $_SESSION["type"]=="user" && isset($_SESSION["id"]) && !empty($_SESSION["id"])){
	    			// user is login
	    			$username=getUsernameUser($_SESSION["id"]);
	    			$out.='<li class="nav-item dropdown" id="tab_profile">';
				        $out.='<a class="nav-link dropdown-toggle" href="http://example.com" id="navbarDropdownMenuLink" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">Hello '.$username.'</a>';
				        $out.='<div class="dropdown-menu" aria-labelledby="navbarDropdownMenuLink">';
				        	$out.='<a class="dropdown-item logout" href="#">Logout</a>';
				        $out.='</div>';
				    $out.='</li>';
	    		}else{
	    			// no one is login
	    			$out.='<li class="nav-item" id="tab_login">';
						$out.='<a class="nav-link" href="login.php">Login</a>';
					$out.='</li>';
					$out.='<li class="nav-item dropdown" id="tab_register">';
						$out.='<a class="nav-link dropdown-toggle" href="http://example.com" id="navbarDropdownMenuLink" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">Register</a>';
						$out.='<div class="dropdown-menu" aria-labelledby="navbarDropdownMenuLink">';
							$out.='<a class="dropdown-item" href="register_user.php">As Reciever/User</a>';
							$out.='<a class="dropdown-item" href="register_hospital.php">As Hospital</a>';
						$out.='</div>';
					$out.='</li>';
	    		}
	    		echo $out;
	    	?>
	    </ul>
	  </div>
	</nav>
	<div class="container msg"></div>
