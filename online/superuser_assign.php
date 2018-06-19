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

    if (isset($_POST['addtoAdmin']))
    {
	foreach($_POST as $index=>$value)
	{
		if (substr($index,0,3) == "acc")
		{
			$query = "UPDATE users SET linkedTo='".$_POST['admin']."' WHERE userId='".$value."'";
			$db = IOC::make('database', array());
			$db->make_query($query);
		}
	}
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
    $('#wait').hide();
  /*  $("#filter").keyup(function()
    {
        
        var ans ="";
        $.ajax({
        type : "POST",
        url : "superuser_filter.php?filter="+$(this).val(),
	beforeSend: function() { $('#wait').show(); },
        complete: function() { $('#wait').hide(); },
        success : function(data){
        ans = data;
        $('#account').html(ans);
       // $('#account').selectpicker('refresh');
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
      <div class="row"></div>
<div class="row">
    <div class="col-md-2">&nbsp;</div>
        <div class="col-md-8">

          <ul class="nav nav-pills" style="position:relative;left:-60px;">
            <li style="background-color:rgb(238,238,238);-moz-border-radius: 4px;-webkit-border-radius: 4px;border-radius: 4px; -khtml-border-radius: 4px;"><a href="superuser_add.php">Add Admin Account</a></li>
            <li class="active"><a href="superuser_assign.php">Assign account to admin</a></li>
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

      <div class="row">
	<br>
	<h1 class="form-signin-heading">Step 2 : Select an account to add to an admin account</h1>
	<form class="form-signin" method="post" action="">
	<label class="control-label">Filter</label>
		<div class="controls">
		<input type="text" name="filter" class="form-control" id="filter" placeholder="Type the description to filter by" required style="width:250px;"><a id="wait">Proccessing...</a>
		</div>
	<br>
        <button class="btn btn-large btn-primary" type="submit" name="accountFilter">Search</button></br></br>
	</form>
      
      <form class="form-signin" method="post" action="">
        <div class="control-group">

        <br/>
        
        <div class="controls">
        <label class="control-label">Admin Username</label>
        <br>
            <select class="selectpicker selector" name="admin" data-width="250px">
            <option value="0">-- SELECT --</option>
            <?php
                $query = "SELECT * FROM users WHERE userLimit=5";
				$db = IOC::make('database', array());
				list($affect_rows, $datad) = $db->selectquerys($query);
					foreach ($datad as $row)
				  {
				  
			echo '<option value="'.$row['userId'].'">'.$row['loginName'].'</option>';
                }
            ?>
            </select>
        </div>
        
        
        <!--<div class="controls">
        <label class="control-label">Username</label>
        <br>
            <select class="selectpicker selector" name="account" data-width="250px">
            <option value="0">-- SELECT --</option>
            </select>
        </div>-->
	<div id="account">
	<?php
		if (isset($_POST['accountFilter']))
		{
			$query = "SELECT * FROM users u INNER JOIN jobinfoweb j ON (u.customer = j.Customer) WHERE j.CustomerName LIKE '%".$_POST['filter']."%' GROUP BY j.Customer";
			$db = IOC::make('database', array());
			list($affect_rows, $datad) = $db->selectquerys($query);
			foreach ($datad as $row)
			{
			// echo '<option value="'.$row['userId'].'">'.$row['loginName'].' => '.$row['CustomerName'].'</option>';
			echo '<p><input type="checkbox" value="'.$row['userId'].'" name="account'.$row['userId'].'"/>&nbsp;&nbsp;&nbsp;'.$row['loginName'].' =>'.$row['CustomerName'].'</p>';
			}
		}
	?>
	</div>
        
        <br/>
        <button class="btn btn-large btn-primary" type="submit" name="addtoAdmin">Add</button></br></br>
        </div>
        <!--<a href="register.php">Register</a>-->
      </form>
      




        


      </div>
  
    </div>
  

  </body>
</html>

