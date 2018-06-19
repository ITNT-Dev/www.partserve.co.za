<?php

error_reporting(E_ALL);
ini_set('display_errors', '1');
session_start();

include "../library/stdinc.php";
require_once(dirname(__FILE__).'/../config/config.inc.php');
require_once("../newlib/index.php");
//  error_reporting(0);

date_default_timezone_set('Africa/Johannesburg');

$userId = $_SESSION['userId'];
if ( $userId < 1 || ! isset($_SESSION['adminId'])) {
  header("Location: ../onlinejobtracking.php");
  exit();
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
    <link href="../css/bootstrap.min.css" rel="stylesheet">
    <link href="../css/style2.css" rel="stylesheet">

<script type="text/javascript">
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

          

        </div>
        <div class="col-md-2">

          <div class="pull-right">
            <a href="logout.php"><button type="button" class="btn btn-success">Logout&nbsp;<?php echo $_SESSION['name'] ?></button></a>
          </div>

        </div>
      </div>

      <div class="row">
      
      <?php
      $query = "SELECT * FROM users WHERE userId = '" . $_SESSION['adminId'] . "'";
	  $db = IOC::make('database', array());
	  list($affect_rows, $data) = $db->selectquerys($query);
	  //print_r("<pre>");var_dump($datad); die();
	  $row = $data[0];
	  $user = $row['loginName'];
      echo "<h2>User : ". $user."</h2>";
      echo '<p><a href="../dashboardGlobal.php">Global</a></p>';
      $query = "SELECT * FROM users WHERE linkedTo = '" . $_SESSION['adminId'] . "'";
      $db = IOC::make('database', array());
	  list($affect_rows, $data) = $db->selectquerys($query);
	  
        //$result = mysql_query($query);
        //if (!$result) die ("SQL error on users joined on jobinfo: " . mysql_error());
if( is_array($data) && ! empty($data)){
        foreach($data as $row)
		{
			
			echo '<p><a href="become_user.php?u='.$row['userId'].'">'.$row['loginName'].'</a></p>';
    }
  }
		
      ?>




        


      </div>
  
    </div>
  
    <!-- jQuery (necessary for Bootstrap's JavaScript plugins) -->
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.0/jquery.min.js"></script>
    <!-- Include all compiled plugins (below), or include individual files as needed -->
    <script src="js/bootstrap.min.js"></script>
  </body>
</html>

