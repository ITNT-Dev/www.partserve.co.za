<?php
if (session_id() == "") { session_start(); }

$userId = isset($_SESSION['userId']) ? $_SESSION['userId'] : 0;

require_once (dirname(dirname(__FILE__)) . "/library/onlinejobtracking.class.php");
?>

<!--<div class="col-md-8">-->
<div class="col-12">
<?php 

$query = "SELECT * FROM users u ";
  $query .= "LEFT JOIN jobinfoweb j ON (u.customer = j.customer) ";
  $query .= "WHERE ";
  $query .= " Workshop='8' OR Workshop='9' ";
	$db = IOC::make('database', array());
	list($affect_rows, $datad) = $db->selectquerys($query);
  
?> 
<ul class="nav nav-pills" role="tablist">
 <?php
 
 if ($affect_rows > 0) {

     $c =0;
		foreach ($datad as $row)
      {
		 $c++; //Lazy count :: Apply fix 
	  }
 }
 ?>
    <li <?php if (strtolower($pagename) == "dashboard.php") { echo " class='active' "; } else { ?>  <?php } ?>><a href="#">Global View  <span class="badge"> <?php echo $c; ?></span></a></li>
	
</ul>
    
</div>
  
<div class="col-12">
    <center><div>
            <p>&nbsp;</p>
      <a href="logout.php"><button type="button" class="btn btn-success">Logout&nbsp;<?php echo $_SESSION['name'] ?></button></a>

    </div>
    </center>
 </div>

