<?php
session_start();

include "../library/stdinc.php";
require_once(dirname(__FILE__).'/../config/config.inc.php');

//  error_reporting(0);

date_default_timezone_set('Africa/Johannesburg');

$userId = $_SESSION['userId'];
if ($userId < 1 ) {
  header("Location: onlinejobtracking.php");
  exit();
  // echo "User ID: " . $_SESSION['userId'] . "<br>";
}

// Connect to database
$db_server = mysql_connect(_DB_HOST_, _DB_USER_, _DB_PASS_);
if (!$db_server) die("Unable to connect to mySQL: " . mysql_error());
mysql_select_db(_DB_NAME_) or die ("Unable to select database: " . mysql_error());

$Job   = htmlentities($_GET['qid']);
// echo "Job: $Job<br>";
$icon  = htmlentities($_GET['icon']);
// echo "Icon: $icon<br>";
if ($icon == "") {
  $icon = 1;
}
// echo "Icon $icon <br>";
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
  <div class="span12 centered-pills">
    <ul class="nav nav-pills" style="position:relative;left:-60px;">
      <li <?php if ($icon == 1) {?> class="active"<?php } ?>><a href="../dashboard.php">Global View</a></li>
      <li <?php if ($icon == 2) {?> class="active"<?php } ?> style="background-color:rgb(238,238,238);-moz-border-radius: 4px;-webkit-border-radius: 4px;border-radius: 4px; -khtml-border-radius: 4px;"><a href="assesment_job.php">Under Assessment</a></li>
      <li <?php if ($icon == 3) {?> class="active"<?php } ?> style="background-color:rgb(238,238,238);-moz-border-radius: 4px;-webkit-border-radius: 4px;border-radius: 4px; -khtml-border-radius: 4px;"><a href="collection_job.php">Ready for Collection</a></li>
      <li <?php if ($icon == 4) {?> class="active"<?php } ?> style="background-color:rgb(238,238,238);-moz-border-radius: 4px;-webkit-border-radius: 4px;border-radius: 4px; -khtml-border-radius: 4px;"><a href="closedJobs.php">Accepted and Rejected Jobs</a></li>
      <li style="background-color:rgb(238,238,238);-moz-border-radius: 4px;-webkit-border-radius: 4px;border-radius: 4px; -khtml-border-radius: 4px;"><a href="current_job.php">Quoted Jobs</a></li>
    </ul>
    <div class="span12 pull-right">
      <a href="logout.php"><button type="button" class="btn btn-success">Logout&nbsp;<?php echo $_SESSION['name'] ?></button></a>
            </div>
        </div>
      </div>

      <!--<div class="row">
        <div class="span12 pull-right">

          <a href="logout.php"><button type="button" class="btn btn-success">Logout&nbsp;<?php echo $_SESSION['name'] ?></button></a>

        </div>
      </div>-->

      <div class="row">
        <div class="span2">&nbsp;</div>

        <div class="span8">

        <p>&nbsp;</p>

        <!-- Show Quote Data -->
        <?php
        // Get 
        $query = "SELECT * FROM JobUpdateWeb ";
        $query .= "WHERE Job = '" . $Job . "' ";
        // echo "Query: $query <br>";
        $result = mysql_query($query);
        if (!$result) die ("Database access failed: " . mysql_error());

        $query_data = mysql_fetch_array($result);

        $Customer              = $query_data['Customer'];
         echo "Customer: $customer <br>";
        $AccountContactName    = $query_data['AccountContactName'];
        $AccountContactEmail   = $query_data['AccountContactEmail'];
        $AccountContactTel     = $query_data['AccountContactTel'];
        $AccountContactCell    = $query_data['AccountContactCell'];
        $SalesContactName      = $query_data['SalesContactName'];
        $SalesContactEmail     = $query_data['SalesContactEmail'];
        $SalesContactTel       = $query_data['SalesContactTel'];
        $SalesContactCell      = $query_data['SalesContactCell'];
        $AcceptQuote           = $query_data['AcceptQuote'];
        $RejectQuote           = $query_data['RejectQuote'];
        $Reason                = $query_data['Reason'];


        // Get Job Information
        $query = "SELECT * FROM jobinfoweb ";
        $query .= "WHERE Job = '" . $Job . "' ";
        // echo "Query: $query <br>";
        $result = mysql_query($query);
        if (!$result) die ("Database access failed: " . mysql_error());

        $query_data = mysql_fetch_array($result);

        $QuoteAccountNumber     = $query_data['QuoteAccountNumber'];
        $QuoteJobDate           = $query_data['QuoteJobDate'];
        $QuoteMake              = $query_data['QuoteMake'];
        $QuoteModel             = $query_data['QuoteModel'];
        $QuoteSerialNumber      = $query_data['QuoteSerialNumber'];
        $QuoteTotal             = $query_data['QuoteTotal'];
        $QuoteTotalTax          = $query_data['QuoteTotalTax'];
        $QuoteGrandTotal        = $query_data['QuoteGrandTotal'];

        $FaultDescription       = $query_data['FaultDescription'];
        $WorkDone               = $query_data['WorkDone'];
        $workList               = explode('|', $WorkDone);
        $Item                   = $query_data['Item'];
        $itemList               = explode('|', $Item);
        $Accessories            = $query_data['Accessories'];
        $AccessoriesList        = explode('|', $Accessories);
        $Status                 = $query_data['Status'];

        $cTemp = "List job " . $Job . " for customer " . $Customer . " ";
        ?>

          <table width=100%>
            <tr>
              <td><strong>Job No</strong></td>
              <td><?php echo $Job ?></td>
            </tr>
            <tr>
              <td><strong>Fault Description</strong></td>
              <td><?php echo $FaultDescription ?></td>
            </tr>
            <tr>
              <td valign='top'><strong>Work Done</strong></td>
              <td>
              <?php 
              foreach ($workList as $job){ 
              	echo $job . "<br>";
              }
              ?>
              </td>
            </tr>
            <tr>
              <td valign='top'><strong>Items</strong></td>
              <td>
              <?php
              $string = "<table class='table table-striped table-condensed table-hover'><th style='text-align:center;'>Store</th><th style='text-align:center;'>Part Number</th><th style='text-align:center;'>Description</th><th style='text-align:center;'>QTY</th><th style='text-align:center;'>Price</th><th style='text-align:center;'>Part ETA</th><tr>";

              foreach ($itemList as $items) {  
                $itemDetails=explode('~', $items);
                foreach ($itemDetails as $itemDesc){ 
                  $string .= "<td align='center'>" . $itemDesc . "</td>";
                }
         			  $string .= "</tr>";
              }

              $string .= "<tr><td></td><td></td><td></td><td align='center'>Total</td><td align='center'>" . $QuoteTotal . "</td><td>&nbsp;</td></tr>";
              $string .= "<tr><td></td><td></td><td></td><td align='center'>VAT</td><td align='center'>" . $QuoteTotalTax . "</td><td>&nbsp;</td></tr>";
              $string .= "<tr><td></td><td></td><td></td><td align='center'><b>Grand Total</b></td><td align='center'><b>" . $QuoteGrandTotal . "</b></td><td>&nbsp;</td></tr>";
              $string .= "</table>";

              echo $string;

              ?>
              </td>
            </tr>
            <tr>
              <td valign='top'><strong>Accessories</strong></td>
              <td>
              <?php 
              foreach ($AccessoriesList as $accessory){ 
              	echo $accessory . "<br>";
              }
              ?>
              </td>
            </tr>
            <tr>
              <td colspan='2'>&nbsp;</td>
            </tr>
            <?php if ($Status == "Quote") { ?>
              <tr>
                <td>&nbsp;</td>
                <td>
                  <a href='accept.php?Job=<?php echo $Job ?>&Customer=<?php echo $Customer ?>&AccountContactName=<?php echo $AccountContactName ?>&AccountContactEmail=<?php echo $AccountContactEmail ?>&AccountContactTel=<?php echo $AccountContactTel ?>&AccountContactCell=<?php echo $AccountContactCell ?>&SalesContactName=<?php echo $SalesContactName ?>&SalesContactEmail=<?php echo $SalesContactEmail ?>&SalesContactTel=<?php echo $SalesContactTel ?>&SalesContactCell=<?php echo $SalesContactCell ?>' id='accept' <?php echo @$answer ?>><button class="btn btn-success">Accept</button></a>
                  &nbsp;
                  <a href='reject.php?Job=<?php echo $Job ?>&Customer=<?php echo $Customer ?>&AccountContactName=<?php echo $AccountContactName ?>&AccountContactEmail=<?php echo $AccountContactEmail ?>&AccountContactTel=<?php echo $AccountContactTel ?>&AccountContactCell=<?php echo $AccountContactCell ?>&SalesContactName=<?php echo $SalesContactName ?>&SalesContactEmail=<?php echo $SalesContactEmail ?>&SalesContactTel=<?php echo $SalesContactTel ?>&SalesContactCell=<?php echo $SalesContactCell ?>' id='accept' <?php echo @$answer ?>><button class="btn btn-danger">Reject</button></a>
                </td>
              </tr>
              <tr>
                <td colspan='2'>&nbsp;</td>
              </tr>
            <?php } ?>
            <tr>
              <td>&nbsp;</td>
              <td><a href="javascript:history.go(-1)"><button type="button" class="btn btn-primary btn">Back</button></a></td>
            </tr>
          </table>

        <p>&nbsp;</p>

        <div class="span2">&nbsp;</div>
      </div>
  
    </div>
  
    <!-- jQuery (necessary for Bootstrap's JavaScript plugins) -->
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.0/jquery.min.js"></script>
    <!-- Include all compiled plugins (below), or include individual files as needed -->
    <script src="js/bootstrap.min.js"></script>

  </body>
</html>


