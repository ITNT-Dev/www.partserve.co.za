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

    if (isset($_POST['addAdmin']))
    {
        $query = "INSERT INTO users(loginName, loginPassword, userLimit) VALUES('".$_POST['username']."', '".$_POST['password']."', 5)";
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

    <!-- Bootstrap -->
    <link href="../css/bootstrap.css" rel="stylesheet">
    <link href="../css/style2.css" rel="stylesheet">
    <link rel="stylesheet" type="text/css" href="../css/bootstrap-select.css">
    <link rel="stylesheet" href="../css/jquery-ui-1.10.4.min.css">
    
    <script src="../js/jquery-1.11.js"></script>
    <script src="../js/jquery-ui-1.10.4.min.js"></script>
    <script type="text/javascript" src="../js/bootstrap-select.js"></script>
    <script src="../js/bootstrap.js"></script>

<script type="text/javascript">
$( document ).ready(function() {
    
    /*$("#filter").keyup(function()
    {
        
        var ans ="";
        $.ajax({
        type : "POST",
        url : "superuser_filter.php?filter="+$(this).val(),
        success : function(data){
        ans = data;
        $('#account').html(ans);
        $('#account').selectpicker('refresh');
        }
        });
        return false;
        });*/
    
    });

 $(window).on('load', function () {

        $('.selectpicker').selectpicker({
            'selectedText': 'cat'
        });
    });
<!--

function MM_preloadImages() { //v3.0
  var d=document; if(d.images){ if(!d.MM_p) d.MM_p=new Array();
    var i,j=d.MM_p.length,a=MM_preloadImages.arguments; for(i=0; i<a.length; i++)
    if (a[i].indexOf("#")!=0){ d.MM_p[j]=new Image; d.MM_p[j++].src=a[i];}}
}

//-->
</script>
<script src="../Scripts/AC_RunActiveContent.js" type="text/javascript"></script>
  </head>

  <body>
   <div class="container">
   

      <div class="row">
        <div class="col-md-2">&nbsp;</div>
        <div class="col-md-8">

          <ul class="nav nav-pills" style="position:relative;left:-60px;">
            <li class="active"><a href="superuser_add.php">Add Admin Account</a></li>
			<li style="background-color:rgb(238,238,238);-moz-border-radius: 4px;-webkit-border-radius: 4px;border-radius: 4px; -khtml-border-radius: 4px;" ><a href="create_vendor.php">Create Vendor Account</a></li>
            <li style="background-color:rgb(238,238,238);-moz-border-radius: 4px;-webkit-border-radius: 4px;border-radius: 4px; -khtml-border-radius: 4px;"><a href="superuser_assign.php">Assign account to admin</a></li>
            <li style="background-color:rgb(238,238,238);-moz-border-radius: 4px;-webkit-border-radius: 4px;border-radius: 4px; -khtml-border-radius: 4px;"><a href="superuser_list.php">List Accounts</a></li>
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

      <div class="row" style="margin-left:267px;">
      <br/>
      
      <form class="form-signin" id="loginForm" method="post" action="">
        <div class="control-group">
        
        <h1 class="form-signin-heading">Step 1 : Add an Admin Account for global view</h1>
        <br/>
        <label class="control-label">Username(minimum of 6 characters)</label>
	    <div class="controls">
	        <input type="text" name="username" class="form-control" id="username" placeholder="Username" required style="width:200px;">
	    </div>
        <label class="control-label">Password(minimum of 6 characters)</label>
	    <div class="controls">
	        <input type="password" name="password" class="form-control" id="password" placeholder="Password" required style="width:200px;">
	    </div>
        
        <!--<div class="controls">
        <label class="control-label">Description</label>
            <select class="selectpicker selector" name="desc" data-width="125px">
            <option value="0">-- SELECT --</option>
          
		  <div class="row">           
		   <?php
                $query = "SELECT * FROM jobinfoweb GROUP BY CustomerName";
                $db = IOC::make('database', array());
				list($affect_rows, $datad) = $db->selectquerys($query);
					foreach ($datad as $row)
				  {
                    echo '<option value="'.$row['CustomerName'].'">'.$row['CustomerName'].'</option>';
            
                }
                ?>
            
            </select>
        </div>-->
        
        <br/>
        <button class="btn btn-large btn-primary" type="submit" name="addAdmin">Add</button></br></br>
        </div>
	<?php
		 if (isset($_POST['addAdmin']))
		echo '<a>Admin account added</a>'
	?>
      </form>
  
    </div>
  </div>

  </body>
</html>

