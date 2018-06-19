<?php
error_reporting(E_ALL);
ini_set( 'display_errors','1'); 
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
 if (isset($_GET['remove']))
    {
        $sql = "UPDATE users SET linkedTo=0 WHERE userId='".$_GET['remove']."'";
        $db = IOC::make('database', array());
		$db->make_query($sql);
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
            <li style="background-color:rgb(238,238,238);-moz-border-radius: 4px;-webkit-border-radius: 4px;border-radius: 4px; -khtml-border-radius: 4px;"><a href="superuser_assign.php">Assign account to admin</a></li>
            <li class="active"><a href="superuser_list.php">List Accounts</a></li>
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
      <?php
	$sql = "SELECT * FROM users WHERE userId=".$_GET['aid'];
	$db = IOC::make('database', array());
	list($affect_rows, $datad) = $db->selectquerys($sql);
		foreach ($datad as $row)
      {
				$adminName = $row['loginName'];
			}
	
	
      ?>
      <h1 class="form-signin-heading">Below is a list of all the accounts that is assigned to : <a><?php echo $adminName; ?></a></h1>
      <?php
	$sql = "SELECT * FROM users WHERE linkedTo=".$_GET['aid'] ." ORDER BY loginName ASC";
    $db = IOC::make('database', array());
	list($affect_rows, $datad) = $db->selectquerys($sql);
		foreach ($datad as $inner_row)
      {  
				echo '<p><a href="superuser_editAdmin.php?remove='.$inner_row['userId'].'&aid='.$_GET['aid'].'"><button type="button" class="btn-xs btn-danger">Remove</button></a>&nbsp;&nbsp;&nbsp;'.$inner_row['loginName'].'</p>';
			}
				
				

      ?>

      </div>
  
    </div>
  

  </body>
</html>

