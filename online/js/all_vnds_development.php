<?php
error_reporting(E_ALL);
ini_set( 'display_errors','1'); 
session_start();

include "../library/stdinc.php";
require_once(dirname(__FILE__).'/../config/config.inc.php');
require_once("../newlib/index.php");

//  error_reporting(0);

date_default_timezone_set('Africa/Johannesburg');

$userId = $_SESSION['userId'];
if ($userId < 1 ) {
  header("Location: ../onlinejobtracking.php");
  exit();
}


if (isset($_POST['addAdmin']))
    {
	
        $sql = "INSERT INTO users(loginName, loginPassword, userLimit) VALUES('".$_POST['username']."', '".$_POST['password']."', 5)";
		$db = IOC::make('database', array());
		$db->make_query($sql);
    }
    
    if (isset($_POST['addtoAdmin']))
    {
        //$query = "INSERT INTO users(loginName, loginPassword, userLimit) VALUES('".$_POST['username']."', '".$_POST['password']."', 5)";
        
        $sql = "UPDATE users SET linkedTo='".$_POST['admin']."' WHERE userId='".$_POST['account']."'";
        $db = IOC::make('database', array());
		$db->make_query($sql);
    }
    
    

$browser    = $_SERVER['HTTP_USER_AGENT'];
$ipAddress  = $_SERVER['REMOTE_ADDR'];


?>
<?php
	if(isset($_POST['addPermission'])){
		var_dump($_POST);
		if( $_POST['addPermission'] != 1) die('You are not allowed to do that');
		$userId  		= $_POST['_userId'];
		$permissions 	= json_encode($_POST['workshop']);
		
		$sql = "UPDATE users SET vendorWorkshop='".$permissions."' WHERE userId='".$userId."'";
        $db = IOC::make('database', array());
		$db->make_query($sql);
	}

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
    
    $("#filter").keyup(function()
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
        });
    
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
<div class="col-md-12">
<h1 class="form-signin-heading">Below is a list of all the vendor accounts</h1>
<hr/>

	<table class="table table-bordered table-hover">
		<thead>
			<tr>
				<th width="10px">#</th>
				<th>Account</th>
				<th colspan="2">Vendors</th>
			</tr>
		</thead>
		<tbody>
		
		<?php 

		///var_dump($_POST);

		$query = "SELECT * FROM jobinfoweb ORDER BY Workshop ASC";
				$db2 = IOC::make('database', array());
				list($affect_rows2, $datad) = $db2->selectquerys($query);
							
		?>
		<?php
		$sql = "SELECT * FROM users WHERE userLimit=100";
		$db = IOC::make('database', array());
		list($affect_rows, $data) = $db->selectquerys($sql);

		if($affect_rows == 0)
		{
		$no_records = 0;

		}
		$count = 1;
		foreach ($data as $result)
		{
		?>

		<form action="all_vnds_development.php?userId=<?php echo $result['userId']; ?>" method="POST">
		<tr>
		
		
			<input name="_userId" hidden value="<?php echo $result['userId']; ?>" />
			<input name="addPermission" hidden value="1" />
			<td><?php echo $count++; ?></td>
			<td><?php echo $result['loginName']; ?></td>
			<td>
				<div class="col-md-6"> 
					<div class="form-group"> 
						<select width="100%" name="workshop[]"class="form-control" multiple> 
							<?php 
								if ($affect_rows2 > 0) {
									
									$filter = array();
									foreach($datad as $row){
										if(!in_array( $row['Workshop'], $filter)){
											
										$existing = json_decode($row['vendorWorkshop'], true);
										$selected = in_array($row['Workshop'], $existing) ? 'selected' : '';
										 echo "<option value='".$row['Workshop']."' ".$selected.">".$row['Workshop']."</option>";	
										 $filter[] =$row['Workshop'];
											
										};
						?>
									
						<?php
									}
								}?>
						</select>
					</div>
				</div>
			</td>
			<td><button type="submit" class="btn btn-block bnt-info">save</button></td>
		
		</tr>
		</form>

		<?php	
		}
		?>
		</tbody>
	</table>
</div>
</div> 
    </div>
  

  </body>
</html>

