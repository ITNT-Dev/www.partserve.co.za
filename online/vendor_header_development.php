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
						
						$filter = " ";
						
						foreach($_SESSION['vendorWorkshop'] as $row){
						 $filter .= " Workshop=".$row." OR " ; 
						}
						$filter = rtrim( $filter, 'OR ');
						$query .= " ". $filter;
						// $query .= "AND Status like '%Under Assessment%' ";
						
						//  print $query;
						
						if ($sort == 1) {
						  $query .= " ORDER BY QuoteJobDate ";
						  if ($sort_order == 'D') {
						    $query .= "DESC ";
						  }
						} elseif ($sort == 2) {
						  $query .= " ORDER BY QuoteMake ";
						  if ($sort_order == 'D') {
						    $query .= "DESC ";
						  }
						} elseif ($sort == 3) {
						  $query .= " ORDER BY QuoteModel ";
						  if ($sort_order == 'D') {
						    $query .= "DESC ";
						  }
						} elseif ($sort == 4) {
						  $query .= " ORDER BY QuoteSerialNumber ";
						  if ($sort_order == 'D') {
						    $query .= "DESC ";
						  }
						} elseif ($sort == 5) {
						  $query .= " ORDER BY QuoteTotal ";
						  if ($sort_order == 'D') {
						    $query .= "DESC ";
						  }
						} elseif ($sort == 6) {
						  $query .= " ORDER BY QuoteTotalTax ";
						  if ($sort_order == 'D') {
						    $query .= "DESC ";
						  }
						} elseif ($sort == 7) {
						  $query .= " ORDER BY QuoteGrandTotal ";
						  if ($sort_order == 'D') {
						    $query .= " DESC ";
						  }
						} else {
						  // Default - List by date
						  $query .= " ORDER BY QuoteJobDate DESC ";
						}
						$query .= " LIMIT " . $no_start . ", " . _ROWS_;
						// echo "Query: $query <br>";
	list($affect_rows, $datad) = $db->selectquerys($query);
  
?> 
<ul class="nav nav-pills" role="tablist">
 <?php
 
 if ($affect_rows > 0) {

  $c = count($datad);
      
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

