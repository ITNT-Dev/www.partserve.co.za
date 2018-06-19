<?php
session_start();

include "../library/stdinc.php";
require_once(dirname(__FILE__).'/../config/config.inc.php');
require_once("../newlib/index.php");
date_default_timezone_set('Africa/Johannesburg');

$userId = $_SESSION['userId'];
if ($userId < 1 ) {
  header("Location: ../onlinejobtracking.php");
  exit();
}

    if (isset($_POST['createAccount']))
    {
		$accountType = $_POST['accountType'];
		$userLimit = 0; //all the other accounts are assigned to userLimit = 0;
		if($accountType == 'admin'){
			$userLimit = 5; //already defined in the existing system that 5 if for the admin
		}else if($accountType == 'vendor'){
			$userLimit = 100; 
		}
        
		$query = "INSERT INTO users(loginName, loginPassword, userLimit, accountType) VALUES('".$_POST['username']."', '".$_POST['password']."', '".$userLimit."', '".$_POST['accountType']."')";
        $db = IOC::make('database', array());
		$db->make_query($query);
    }
    
    if (isset($_POST['addtoAdmin']))
    {
        $query = "UPDATE users SET linkedTo='".$_POST['admin']."' WHERE userId='".$_POST['account']."'";
        $db = IOC::make('database', array());
		$db->make_query($query);
    }
    
    

$browser    = $_SERVER['HTTP_USER_AGENT'];
$ipAddress  = $_SERVER['REMOTE_ADDR'];


?>

<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>PartServe</title>
	<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
    <!-- Bootstrap -->
    <link href="http://www.partserve.co.za/css/bootstrap.css" rel="stylesheet">
    <link href="http://www.partserve.co.za/css/style2.css" rel="stylesheet">
	<link href="http://www.partserve.co.za/css/jquery.selectBoxIt.css" rel="stylesheet">
    <link rel="stylesheet" type="text/css" href="http://www.partserve.co.za/css/bootstrap-select.css">
    <link rel="stylesheet" href="http://www.partserve.co.za/css/jquery-ui-1.10.4.min.css">
    
    <script src="http://www.partserve.co.za/online/js/jquery-1.11.js"></script>
    <script src="http://www.partserve.co.za/online/js/jquery-ui-1.10.4.min.js"></script>
    <script src="http://www.partserve.co.za/js/bootstrap.js"></script>

 </head>

  <body>
   <div class="container">
		<div class="row">
			<div class="col-md-2">&nbsp;</div>
			<div class="col-md-8">

			  <ul class="nav nav-pills" style="position:relative;left:-60px;">
				<li class="active"><a href="superuser_add.php">Add Admin Account</a></li>
				<li style="background-color:rgb(238,238,238);-moz-border-radius: 4px;-webkit-border-radius: 4px;border-radius: 4px; -khtml-border-radius: 4px;"><a href="superuser_assign.php">Assign account to admin</a></li>
				<li style="background-color:rgb(238,238,238);-moz-border-radius: 4px;-webkit-border-radius: 4px;border-radius: 4px; -khtml-border-radius: 4px;"><a href="superuser_list.php">List Accounts</a></li>
				<li style="background-color:rgb(238,238,238);-moz-border-radius: 4px;-webkit-border-radius: 4px;border-radius: 4px; -khtml-border-radius: 4px;"><a href="all_vnds.php">List Vendors</a></li>
			   <!-- <li style="background-color:rgb(238,238,238);-moz-border-radius: 4px;-webkit-border-radius: 4px;border-radius: 4px; -khtml-border-radius: 4px;"><a href="closedJobs.php">Accepted and Rejected Jobs</a></li>
				<li style="background-color:rgb(238,238,238);-moz-border-radius: 4px;-webkit-border-radius: 4px;border-radius: 4px; -khtml-border-radius: 4px;"><a href="current_job.php">Quoted Jobs</a></li>-->
			  </ul>

			</div>
			<div class="col-md-2">

			  <div class="pull-right">
				<a href="logout.php"><button type="button" class="btn btn-success">Logout&nbsp;<?php echo $_SESSION['name'] ?></button></a>
			  </div>

			</div>
		</div>
		<div class="row">
			<div class="col-md-12"><h1>Step 1 : Add an Admin/Vendor Account for global view</h1></div>
		</div>

		<div class="row">
		<br>
		<br>
			<div class="col-md-6">
				<form action="" role="form" class="register-form validate" enctype="multipart/form-data" method="post" accept-charset="utf-8" novalidate="novalidate"> 
				
				<div class="row"> 
						<div class="col-md-6"> 
							<div class="form-group"> 
								<label for="accountType" class="control-label">Account type</label>
								<select width="100%" name="accountType" id="accountType" class="form-control selectboxit"> 
									<option value="">select account type</option>
									<option value="admin">Admin</option>
									<option value="vendor">Vendor</option> 
								</select>
							</div>
						</div>
				</div>  
				<div class="row"> 
					<div class="col-sm-12"> 
						<div class="form-group"> 
							<label for="field-1" class="control-label">Username</label> 
							<input id="name" type="text" placeholder="username" class="form-control" name="username" data-validate="required" data-message-required="username" required="required" aria-required="true"> 
						</div> 
					</div>
					
				</div> 
				
				<div class="row"> 
				
					<div class="col-sm-12"> 
					<div class="form-group">
						<label for="password" class="control-label">Password</label> 
						<input id="password" type="password" placeholder="Enter new password" class="form-control" name="password" data-validate="required" data-message-required="Enter surname"> 
					</div>
					</div> 
				</div> 
							
					
					<input hidden name="createAccount" /> 	
					
					<div class="row"> 
						<div class="col-md-3"> 
							<button class="btn btn-block btn-info"> 
								submit
							</button>
						</div>
					</div> 
				</form>
				</div>
			<div class="col-md-6">
			</div>
		</div>
	
  </div>

  </body>
</html>
























