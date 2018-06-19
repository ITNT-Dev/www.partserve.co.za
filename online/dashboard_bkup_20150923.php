<?php
session_start();

include "../library/stdinc.php";
require_once(dirname(dirname(__FILE__)).'/config/config.inc.php');

$pagename = "dashboard.php";

date_default_timezone_set('Africa/Johannesburg');

$userId = $_SESSION['userId'];
if ($userId < 1 ) {
  header("Location: onlinejobtracking.php");
  exit();
  // echo "User ID: " . $_SESSION['userId'] . "<br>";
}

require_once '../bootstrap.php';

//TMy_Utils::print_Array(TOnlineJobTracking::getJobs($_SESSION['userId']));

// Connect to database
$db_server = mysql_connect(_DB_HOST_, _DB_USER_, _DB_PASS_);
if (!$db_server) die("Unable to connect to mySQL: " . mysql_error());
mysql_select_db(_DB_NAME_) or die ("Unable to select database: " . mysql_error());

$sort        = isset($_GET['sort']) ? htmlentities($_GET['sort']) : "";
if ($sort < 1) {
  $sort = 1;
}

$sort_order  = isset($_GET['sort_order']) ? htmlentities($_GET['sort_order']) : "";
if ($sort == "") {
  $sort = 'A';
}
// echo "Sort: $sort <br>";

$browser    = $_SERVER['HTTP_USER_AGENT'];
$ipAddress  = $_SERVER['REMOTE_ADDR'];

// Get pagination details
$query = "SELECT * FROM users u ";
$query .= "LEFT JOIN jobinfoweb j ON (u.customer=j.customer) ";
$query .= "WHERE userId= '" . $_SESSION['userId'] . "' ";
// $query .= "AND Status like '%Under Assessment%' ";
// echo "SQL: $query<p>";
$result = mysql_query($query);
if (!$result) die ("Database access failed: " . mysql_error());
$no_records = mysql_num_rows($result);
// echo "No records: $no_records<p>";

// Get page number and set variables
$no_page = isset($_GET['page']) ? sanitiseString($_GET['page']) : 0;
if (!(isset($no_page) && ($no_page/1==$no_page) && $no_page!=0)) {
  $no_page = 1;
}
$no_start = ($no_page-1) * _ROWS_;
// echo "No Start: $no_start<br>";
 
// Check if page number less than max number of records
if ($no_start >= $no_records) {
  $no_start = $no_records - _ROWS_;
}

if ($no_start < 0) {
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
    <link href="css/bootstrap.min.css" rel="stylesheet">
    <link href="css/style2.css" rel="stylesheet">

<script type="text/javascript">
<!--
function MM_preloadImages() { //v3.0
  var d=document; if(d.images){ if(!d.MM_p) d.MM_p=new Array();
    var i,j=d.MM_p.length,a=MM_preloadImages.arguments; for(i=0; i<a.length; i++)
    if (a[i].indexOf("#")!=0){ d.MM_p[j]=new Image; d.MM_p[j++].src=a[i];}}
}
//-->
</script>
<script src="Scripts/AC_RunActiveContent.js" type="text/javascript"></script>
  </head>
   <body>

  
    <div class="container">
      <div class="row">
      
       <div id="pagewrap"></div>
<div class="row">
    <div class="col-md-1">&nbsp;</div>

        <?php require_once (dirname(__FILE__) . '/header.php'); ?>
      </div>

      <div class="row">

        <p>&nbsp;</p>

        <?php //include "inc_table_all_nav.php"; ?>
        <?php // include "inc_table_all.php"; ?>
        
          <?php
  // Old assessment SQL
  // SELECT * FROM users u
	//	LEFT JOIN jobinfoweb j ON (u.customer=j.customer)
  //				WHERE userId= '".$_SESSION['userId']."' 
	//				AND Status like '%Under Assessment%'
	//  			ORDER BY QuoteJobDate DESC $max";
 
  // Get data from database
  $query = "SELECT * FROM users u ";
  $query .= "LEFT JOIN jobinfoweb j ON (u.customer = j.customer) ";
  $query .= "WHERE userId = '" . $_SESSION['userId'] . "' ";
  // $query .= "AND Status like '%Under Assessment%' ";

  if ($sort == 1) {
    $query .= "ORDER BY QuoteJobDate ";
    if ($sort_order == 'D') {
      $query .= "DESC ";
    }
  } elseif ($sort == 2) {
    $query .= "ORDER BY QuoteMake ";
    if ($sort_order == 'D') {
      $query .= "DESC ";
    }
  } elseif ($sort == 3) {
    $query .= "ORDER BY QuoteModel ";
    if ($sort_order == 'D') {
      $query .= "DESC ";
    }
  } elseif ($sort == 4) {
    $query .= "ORDER BY QuoteSerialNumber ";
    if ($sort_order == 'D') {
      $query .= "DESC ";
    }
  } elseif ($sort == 5) {
    $query .= "ORDER BY QuoteTotal ";
    if ($sort_order == 'D') {
      $query .= "DESC ";
    }
  } elseif ($sort == 6) {
    $query .= "ORDER BY QuoteTotalTax ";
    if ($sort_order == 'D') {
      $query .= "DESC ";
    }
  } elseif ($sort == 7) {
    $query .= "ORDER BY QuoteGrandTotal ";
    if ($sort_order == 'D') {
      $query .= "DESC ";
    }
  } else {
    // Default - List by date
    $query .= "ORDER BY QuoteJobDate DESC ";
  }
  //$query .= " LIMIT " . $no_start . ", " . _ROWS_;
  // echo "Query: $query <br>";
  $result = mysql_query($query);
  if (!$result) die ("Database access failed: " . mysql_error());
  ?>

  <table class="table table-striped table-condensed table-hover">
    <thead>
      <tr>
        <th>&nbsp;</th>
        <th>Account</a></th>
        <th>Name</a></th>
        <th>Job No</a></th>
        <th>Quote&nbsp;Date 
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
        <th>Amount Ex VAT
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
        <th>Status</th>
        <th>Store Ref</th>
        <th>Vendor Ref</th>
        <th>Details</th>
	<th>Deliver Address</th>
	<th>Workshop</th>
      </tr>
    </thead>
    <tbody>

    <?php
    $rows = mysql_num_rows($result);
    // echo "Rows: $rows<p>";

    if ($rows > 0) {

      for ($j = 1; $j <= $rows; ++$j)
        {

          $row = mysql_fetch_assoc($result);

          $job_account_no         = $row['Customer'];
          $job_account_name       = $row['CustomerName'];

          $job_jobno              = $row['Job'];
          $job_quote_date         = $row['QuoteJobDate'];
          $job_quote_make         = $row['QuoteMake'];
          $job_quote_model        = $row['QuoteModel'];
          $job_quote_serial       = $row['QuoteSerialNumber'];
          $job_quote_amount       = $row['QuoteTotal'];
          $job_quote_tax          = $row['QuoteTotalTax'];
          $job_quote_total        = $row['QuoteGrandTotal'];

          $job_quote_store_ref    = $row['StoreRefNo'];
          $job_quote_vendor_ref   = $row['VendorRefNo'];

          $job_quote_status       = $row['Status'];
	  
		$delivery_address       = $row['DeliveryAddress'];
		$workshop       = $row['Workshop'];

          echo "<tr>";
          $counter = $j + $no_start;
          echo "<td><a href='quote.php?qid=" . $job_jobno . "'>" . $counter . "</a></td>";
          echo "<td><a href='quote.php?qid=" . $job_jobno . "'>" . $job_account_no . "</a></td>";
          echo "<td><a href='quote.php?qid=" . $job_jobno . "'>" . $job_account_name . "</a></td>";
          echo "<td><a href='quote.php?qid=" . $job_jobno . "'>" . $job_jobno . "</a></td>";
          echo "<td><a href='quote.php?qid=" . $job_jobno . "'>" . $job_quote_date . "</a></td>";
          echo "<td><a href='quote.php?qid=" . $job_jobno . "'>" . $job_quote_make . "</a></td>";
          echo "<td><a href='quote.php?qid=" . $job_jobno . "'>" . $job_quote_model . "</a></td>";
          echo "<td><a href='quote.php?qid=" . $job_jobno . "'>" . $job_quote_serial . "</a></td>";
          echo "<td><a href='quote.php?qid=" . $job_jobno . "'>" . $job_quote_amount . "</a></td>";
          echo "<td><a href='quote.php?qid=" . $job_jobno . "'>" . $job_quote_status . "</a></td>";
          echo "<td><a href='quote.php?qid=" . $job_jobno . "'>" . $job_quote_store_ref . "</a></td>";
          echo "<td><a href='quote.php?qid=" . $job_jobno . "'>" . $job_quote_vendor_ref . "</a></td>";
          echo "<td><a href='quote.php?qid=" . $job_jobno . "'>Details</a></td>";
	  echo "<td><a href='quote.php?qid=" . $job_jobno . "'>".$delivery_address."</a></td>";
	  echo "<td><a href='quote.php?qid=" . $job_jobno . "'>".$workshop."</a></td>";

        }

    } else {

      echo "<tr><td colspan='10'>No jobs to show</td></tr>";

    }
    ?>
    </tbody>
  </table>

        
        <?php //include "inc_table_all_nav.php"; ?>

      </div>
  
    </div>
    </div>
  
    <!-- jQuery (necessary for Bootstrap's JavaScript plugins) -->
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.0/jquery.min.js"></script>
    <!-- Include all compiled plugins (below), or include individual files as needed -->
    <script src="js/bootstrap.min.js"></script>
  </body>
</html>

