<?php
require_once("../newlib/index.php");
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);

error_reporting(E_ALL);

if (session_id() == "") { session_start(); }

require_once dirname(dirname(__FILE__)) . '/bootstrap.php';

$pagename = "awaitingcustomer_jobs.php";

$userId = $_SESSION['userId'];
if ($userId < 1 ) {
  header("Location: ../onlinejobtracking.php");
  exit();
}

$sort        = isset($_GET['sort']) ? htmlentities($_GET['sort']) : 0;
if ($sort < 1) {
  $sort = 1;
}
// echo "Sort: $sort <br>";

$sort_order  = isset($_GET['sort_order']) ? htmlentities($_GET['sort_order']) : "";
if ($sort == "") {
  $sort = 'A';
}
// echo "Sort: $sort <br>";

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
    <link href="css/custom.css" rel="stylesheet">

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
    

<?php require_once (dirname(__FILE__) . "/header.php"); ?>
      </div>

      <div class="row">

        <p>&nbsp;</p>
        
    <?php
  
    $sort_column = "QuoteJobDate";

    switch ($sort) {
        case 1:
            $sort_column = "QuoteJobDate";
            break;

        case 2:
            $sort_column = "QuoteMake";
            break;

        case 3:
            $sort_column = "QuoteModel";
            break;

        case 4:
            $sort_column = "QuoteSerialNumber";
            break;

        case 5:
            $sort_column = "QuoteTotal";
            break;

        case 6:
            $sort_column = "QuoteTotalTax";
            break;

        case 7:
            $sort_column = "QuoteGrandTotal";
            break;

        default:
            $sort_column = "QuoteJobDate";
            break;
    }

    $sort_method = isset($sort_order) && trim(strtoupper($sort_order)) == "DESC" ? "DESC" : "ASC";

    $awaitingCustomerJobs = TOnlineJobTracking::getAwaitingCustomerJobs($_SESSION['userId'], array('order' => $sort_column . " " . $sort_method));
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

    if (count($awaitingCustomerJobs) > 0) {

      $counter = 0;
      foreach ($awaitingCustomerJobs as $job)
      {
          $counter++;
          
          echo "<tr>";
          echo "<td><a href='quote.php?qid=" . $job->job . "'>" . $counter . "</a></td>";
          echo "<td><a href='quote.php?qid=" . $job->job . "'>" . $job->customer . "</a></td>";
          echo "<td><a href='quote.php?qid=" . $job->job . "'>" . $job->customername . "</a></td>";
          echo "<td><a href='quote.php?qid=" . $job->job . "'>" . $job->job . "</a></td>";
          echo "<td><a href='quote.php?qid=" . $job->job . "'>" . $job->quotejobdate . "</a></td>";
          echo "<td><a href='quote.php?qid=" . $job->job . "'>" . $job->quotemake . "</a></td>";
          echo "<td><a href='quote.php?qid=" . $job->job . "'>" . $job->quotemodel . "</a></td>";
          echo "<td><a href='quote.php?qid=" . $job->job . "'>" . $job->quoteserialnumber . "</a></td>";
          echo "<td><a href='quote.php?qid=" . $job->job . "'>" . $job->quotetotal . "</a></td>";
          echo "<td><a href='quote.php?qid=" . $job->job . "'>" . $job->status . "</a></td>";
          echo "<td><a href='quote.php?qid=" . $job->job . "'>" . $job->storerefno . "</a></td>";
          echo "<td><a href='quote.php?qid=" . $job->job . "'>" . $job->vendorrefno . "</a></td>";
          echo "<td><a href='quote.php?qid=" . $job->job . "'>Details</a></td>";
	  echo "<td><a href='quote.php?qid=" . $job->job . "'>" . $job->deliveryaddress . "</a></td>";
	  echo "<td><a href='quote.php?qid=" . $job->job . "'>" . $job->workshop . "</a></td>";

        }

    } else {

      echo "<tr><td colspan='10'>No jobs to show</td></tr>";

    }
    ?>
    </tbody>
  </table>

      </div>
  
    </div>
  
    <!-- jQuery (necessary for Bootstrap's JavaScript plugins) -->
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.0/jquery.min.js"></script>
    <!-- Include all compiled plugins (below), or include individual files as needed -->
    <script src="js/bootstrap.min.js"></script>
  </body>
</html>

