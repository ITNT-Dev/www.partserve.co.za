<?php
session_start();
 error_reporting(E_ALL);
ini_set( 'display_errors','1'); 
include "../library/stdinc.php";
require_once(dirname(__FILE__).'/../config/config.inc.php');
require_once("../newlib/index.php");

//  error_reporting(0);

date_default_timezone_set('Africa/Johannesburg');

$userId = @$_SESSION['userId'];
/*
if ($userId < 1 ) {
  header("Location: ../onlinejobtracking.php");
  exit();
  // echo "User ID: " . $_SESSION['userId'] . "<br>";
}
*/

//$sort        = htmlentities($_GET['sort']);
$sort        = 3;
if ($sort < 1) {
  $sort = 1;
}
// echo "Sort: $sort <br>";

//$sort_order  = htmlentities($_GET['sort_order']);
$sort_order  = "";
if ($sort == "") {
  $sort = 'A';
}
// echo "Sort: $sort <br>";

$browser    = $_SERVER['HTTP_USER_AGENT'];
$ipAddress  = $_SERVER['REMOTE_ADDR'];



// Get pagination details
$sql = "SELECT * FROM users u ";
$sql .= "LEFT JOIN jobinfoweb j ON (u.customer=j.customer) ";
//$sql .= "WHERE userId= '" . $_SESSION['userId'] . "' ";
$sql .= "WHERE userId= '500' ";
$sql .= "AND Status like '%Under Assessment%' ";
//$query = $conn->query($sql);
$query = $sql;
$db = IOC::make('database', array());
list($affect_rows, $datad) = $db->selectquerys($query);
$no_records = $affect_rows;
$no_page = 1;
if (!(isset($no_page) && ($no_page/1==$no_page) && $no_page!=0)) {
  $no_page = 1;
}
$no_start = ($no_page-1) * _ROWS_;
// echo "No Start: $no_start<br>";
 
// Check if page number less than max number of records
if ($no_start >= $no_records) {
  $no_start = $no_records - _ROWS_;
}

if ($no_start < 0){
  $no_start = 0;
}

// echo "No Start: $no_start<br>";
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

          <ul class="nav nav-pills" style="position:relative;left:-60px;">
            <li style="background-color:rgb(238,238,238);-moz-border-radius: 4px;-webkit-border-radius: 4px;border-radius: 4px; -khtml-border-radius: 4px;"><a href="../dashboardGlobal.php">Global View</a></li>
            <li class="active"><a href="assesment_jobGlobal.php">Under Assessment</a></li>
            <li style="background-color:rgb(238,238,238);-moz-border-radius: 4px;-webkit-border-radius: 4px;border-radius: 4px; -khtml-border-radius: 4px;"><a href="collection_jobGlobal.php">Ready for Collection</a></li>
            <li style="background-color:rgb(238,238,238);-moz-border-radius: 4px;-webkit-border-radius: 4px;border-radius: 4px; -khtml-border-radius: 4px;"><a href="closedJobsGlobal.php">Accepted and Rejected Jobs</a></li>
            <li style="background-color:rgb(238,238,238);-moz-border-radius: 4px;-webkit-border-radius: 4px;border-radius: 4px; -khtml-border-radius: 4px;"><a href="current_jobGlobal.php">Quoted Jobs</a></li>
          </ul>

        </div>
        <div class="col-md-2">

          <div class="pull-right">
            <a href="logout.php"><button type="button" class="btn btn-success">Logout&nbsp;<?php echo $_SESSION['name'] ?></button></a>
            
          

                        <?php
if ($_SESSION['accountType'] == "admin" ) {
?>
            <br><br><a href="admin_page.php"><button type="button" class="btn btn-success">Back to Admin</button></a>
            <?php
}
?>
          </div>

        </div>
      </div>

      <div class="row">

        <p>&nbsp;</p>

        <?php //include "inc_table_assessment_nav.php"; ?>
        <?php //include "inc_table_assessment.php"; ?>
          <?php
         
		$sql = "SELECT * FROM users WHERE userId=".$_SESSION['adminId'];  
		//$sql = "SELECT * FROM users WHERE userId=500"; 
		$db = IOC::make('database', array());
	list($affect_rows, $datad) = $db->selectquerys($sql);
		foreach ($datad as $row)
      {
				$desc = $row['fullName'];
			}
			
        //$sql = "SELECT * FROM users u INNER JOIN jobinfoweb j ON (u.customer = j.customer) WHERE u.linkedTo = '" . $_SESSION['adminId'] . "' AND Status LIKE '%Under Assessment%' ";
		
	///	$sql = "SELECT * FROM users u INNER JOIN jobinfoweb j ON (u.customer = j.customer) WHERE u.linkedTo = '" . $_SESSION['adminId'] . "' AND Status LIKE '%Under Assessment%' ";
    if($_SESSION['accountType'] == 'admin'){
      $sql = "SELECT * FROM users u INNER JOIN jobinfoweb j ON (u.customer = j.customer) WHERE u.linkedTo = '" . $_SESSION['adminId'] . "' AND j.Status='Under Assessment' ";
    }else{
      $sql = "SELECT * FROM users u INNER JOIN jobinfoweb j ON (u.customer = j.customer) WHERE u.userId = '" . $_SESSION['adminId'] . "' AND j.Status='Under Assessment' ";
    }

 


  if ($sort == 1) {
    $sql .= "ORDER BY QuoteJobDate ";
    if ($sort_order == 'D') {
      $sql .= "DESC ";
    }
  } elseif ($sort == 2) {
    $sql .= "ORDER BY QuoteMake ";
    if ($sort_order == 'D') {
      $sql .= "DESC ";
    }
  } elseif ($sort == 3) {
    $sql .= "ORDER BY QuoteModel ";
    if ($sort_order == 'D') {
      $sql .= "DESC ";
    }
  } elseif ($sort == 4) {
    $sql .= "ORDER BY QuoteSerialNumber ";
    if ($sort_order == 'D') {
      $sql .= "DESC ";
    }
  } elseif ($sort == 5) {
    $sql .= "ORDER BY QuoteTotal ";
    if ($sort_order == 'D') {
      $sql .= "DESC ";
    }
  } elseif ($sort == 6) {
    $sql .= "ORDER BY QuoteTotalTax ";
    if ($sort_order == 'D') {
      $sql .= "DESC ";
    }
  } elseif ($sort == 7) {
    $sql .= "ORDER BY QuoteGrandTotal ";
    if ($sort_order == 'D') {
      $sql .= "DESC ";
    }
  } else {
    // Default - List by date
    $sql .= "ORDER BY QuoteJobDate DESC ";
  }
  $sql .= " LIMIT " . $no_start . ", " . _ROWS_;
  // echo "Query: $query <br>";
 
  
  ?>

  <table class="table table-striped table-condensed table-hover">
    <thead>
      <tr>
        <th>&nbsp;</th>
        <th>Job No</a></th>
        <th>Quote Job Date 
        <?php
        if ($sort == 1) {
          if ($sort_order == 'D') {
            echo "<a href='?sort=1&sort_order=A'><span class='glyphicon glyphicon-sort-by-attributes-alt'></span></a>";
          } else {
            echo "<a href='?sort=1&sort_order=D'><span class='glyphicon glyphicon-sort-by-attributes'></span></a>";
          }
        } else {
          echo "<a href='?sort=1&sort_order=D'><span class='glyphicon glyphicon-sort'></span></a>";
        }
        ?>
        </th>
        <th>Make
        <?php
        if ($sort == 2) {
          if ($sort_order == 'D') {
            echo "<a href='?sort=2&sort_order=A'><span class='glyphicon glyphicon-sort-by-attributes-alt'></span></a>";
          } else {
            echo "<a href='?sort=2&sort_order=D'><span class='glyphicon glyphicon-sort-by-attributes'></span></a>";
          }
        } else {
          echo "<a href='?sort=2&sort_order=D'><span class='glyphicon glyphicon-sort'></span></a>";
        }
        ?>
        </th>
        <th>Model 
        <?php
        if ($sort == 3) {
          if ($sort_order == 'D') {
            echo "<a href='?sort=3&sort_order=A'><span class='glyphicon glyphicon-sort-by-attributes-alt'></span></a>";
          } else {
            echo "<a href='?sort=3&sort_order=D'><span class='glyphicon glyphicon-sort-by-attributes'></span></a>";
          }
        } else {
          echo "<a href='?sort=3&sort_order=D'><span class='glyphicon glyphicon-sort'></span></a>";
        }
        ?>
        </th>
        <th>Serial No
        <?php
        if ($sort == 4) {
          if ($sort_order == 'D') {
            echo "<a href='?sort=4&sort_order=A'><span class='glyphicon glyphicon-sort-by-attributes-alt'></span></a>";
          } else {
            echo "<a href='?sort=4&sort_order=D'><span class='glyphicon glyphicon-sort-by-attributes'></span></a>";
          }
        } else {
          echo "<a href='?sort=4&sort_order=D'><span class='glyphicon glyphicon-sort'></span></a>";
        }
        ?>
        </th>
        <th>Amount 
        <?php
        if ($sort == 5) {
          if ($sort_order == 'D') {
            echo "<a href='?sort=5&sort_order=A'><span class='glyphicon glyphicon-sort-by-attributes-alt'></span></a>";
          } else {
            echo "<a href='?sort=5&sort_order=D'><span class='glyphicon glyphicon-sort-by-attributes'></span></a>";
          }
        } else {
          echo "<a href='?sort=5&sort_order=D'><span class='glyphicon glyphicon-sort'></span></a>";
        }
        ?>
        </th>
        <th>Tax (VAT)
        <?php
        if ($sort == 6) {
          if ($sort_order == 'D') {
            echo "<a href='?sort=6&sort_order=A'><span class='glyphicon glyphicon-sort-by-attributes-alt'></span></a>";
          } else {
            echo "<a href='?sort=6&sort_order=D'><span class='glyphicon glyphicon-sort-by-attributes'></span></a>";
          }
        } else {
          echo "<a href='?sort=6&sort_order=D'><span class='glyphicon glyphicon-sort'></span></a>";
        }
        ?>
        </th>
        <th>Total
        <?php
        if ($sort == 7) {
          if ($sort_order == 'D') {
            echo "<a href='?sort=7&sort_order=A'><span class='glyphicon glyphicon-sort-by-attributes-alt'></span></a>";
          } else {
            echo "<a href='?sort=7&sort_order=D'><span class='glyphicon glyphicon-sort-by-attributes'></span></a>";
          }
        } else {
          echo "<a href='?sort=7&sort_order=D'><span class='glyphicon glyphicon-sort'></span></a>";
        }
        ?>
        </th>
        <th>Status</th>
	<th>Deliver Address</th>
	<th>Workshop</th>
      </tr>
    </thead>
    <tbody>

    <?php
	
	 $db = IOC::make('database', array());
	list($affect_rows, $datad) = $db->selectquerys($sql);
   // var_dump($datad);
  if(is_array($datad) && count($datad) > 0){
  $j = 1;
    foreach ($datad as $row)
      {
				$job_jobno            = $row['Job'];
          $job_quote_date       = $row['QuoteJobDate'];
          $job_quote_make       = $row['QuoteMake'];
          $job_quote_model      = $row['QuoteModel'];
          $job_quote_serial     = $row['QuoteSerialNumber'];
          $job_quote_amount     = $row['QuoteTotal'];
          $job_quote_tax        = $row['QuoteTotalTax'];
          $job_quote_total      = $row['QuoteGrandTotal'];
          $job_quote_status     = $row['Status'];
	  $delivery_address       = $row['DeliveryAddress'];
		$workshop       = $row['Workshop'];

          echo "<tr>";
          echo "<td><a href='quote.php?qid=" . $job_jobno . "&icon=2'>" . $j++ . "</a></td>";
          echo "<td><a href='quote.php?qid=" . $job_jobno . "'>" . $job_jobno . "</a></td>";
          echo "<td><a href='quote.php?qid=" . $job_jobno . "'>" . $job_quote_date . "</a></td>";
          echo "<td><a href='quote.php?qid=" . $job_jobno . "'>" . $job_quote_make . "</a></td>";
          echo "<td><a href='quote.php?qid=" . $job_jobno . "'>" . $job_quote_model . "</a></td>";
          echo "<td><a href='quote.php?qid=" . $job_jobno . "'>" . $job_quote_serial . "</a></td>";
          echo "<td><a href='quote.php?qid=" . $job_jobno . "'>" . $job_quote_amount . "</a></td>";
          echo "<td><a href='quote.php?qid=" . $job_jobno . "'>" . $job_quote_tax . "</a></td>";
          echo "<td><a href='quote.php?qid=" . $job_jobno . "'>" . $job_quote_total . "</a></td>";
          echo "<td><a href='quote.php?qid=" . $job_jobno . "'>" . $job_quote_status . "</a></td>";
	  echo "<td><a href='online/quote.php?qid=" . $job_jobno . "'>".$delivery_address."</a></td>";
	  echo "<td><a href='online/quote.php?qid=" . $job_jobno . "'>".$workshop."</a></td>";

          echo "</tr>";
			}
	
    }
	
    ?>
    </tbody>
  </table>

        <?php //include "inc_table_assessment_nav.php"; ?>

      </div>
  
    </div>
  
    <!-- jQuery (necessary for Bootstrap's JavaScript plugins) -->
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.0/jquery.min.js"></script>
    <!-- Include all compiled plugins (below), or include individual files as needed -->
    <script src="../js/bootstrap.min.js"></script>
  </body>
</html>
