<?php

if (session_id() == "") { session_start(); }

require_once dirname(dirname(__FILE__)) . '/bootstrap.php';

$pagename = "invoiced_jobs.php";

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

$sort_column = "QuoteJobDate";

    switch ($sort) {
        case 1:
            $sort_column = "InvoiceDate";
            break;

        case 2:
            $sort_column = "InvoiceMake";
            break;

        case 3:
            $sort_column = "InvoiceModel";
            break;

        case 4:
            $sort_column = "InvoiceSerialNumber";
            break;

        case 5:
            $sort_column = "InvoiceTotal";
            break;

        case 6:
            $sort_column = "InvoiceTotalTax";
            break;

        case 7:
            $sort_column = "InvoiceGrandTotal";
            break;

        default:
            $sort_column = "InvoiceDate";
            break;
    }

    $sort_method = isset($sort_order) && trim(strtoupper($sort_order)) == "DESC" ? "DESC" : "ASC";

    //$jobs = JobInvoice::all(array('order' => $sort_column . " " . $sort_method));

    $jobs = TOnlineJobTracking::getInvoicedJobs($_SESSION['userId']);

?>
<!DOCTYPE html>
<html>
    <head>
        <meta charset="UTF-8">
        <title>Partserve Online Job Tracking</title>      
        
        <!-- Latest compiled and minified CSS -->
        <link href="css/bootstrap.min.css" rel="stylesheet">
    <link href="css/style2.css" rel="stylesheet">
    <link href="css/custom.css" rel="stylesheet">

        <!-- Latest compiled and minified JavaScript -->
        <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.5/js/bootstrap.min.js"></script>
    </head>
    <body>
        <?php
        // put your code here
        ?>
        
        <div class="container">            
            <div class="row"></div>
            
            <?php require_once ((dirname(__FILE__)) . "/header.php"); ?>
            
            <p>&nbsp;</p>
            
            <table class="table table-striped table-condensed table-hover">
    <thead>
      <tr>
        <th>&nbsp;</th>
        <th>Account</a></th>
        <th>Name</a></th>
        <th>Job No</a></th>
        <th>Invoice&nbsp;Date 
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
    
    if (count($jobs) > 0) {

      $counter = 0;
      foreach ($jobs as $job)
      {
          $counter++;
          
          echo "<tr>";
          echo "<td><a href='invoiced_job.php?jobid=" . $job->id . "'>" . $counter . "</a></td>"; // invoiced_job.php?jobid=<?php echo $job->id; 
          echo "<td><a href='invoiced_job.php?jobid=" . $job->id . "'>" . $job->customer . "</a></td>";
          echo "<td><a href='invoiced_job.php?jobid=" . $job->id . "'>" . $job->customername . "</a></td>";
          echo "<td><a href='invoiced_job.php?jobid=" . $job->id . "'>" . $job->job . "</a></td>";
          echo "<td><a href='invoiced_job.php?jobid=" . $job->id . "'>" . date('Y-m-d', strtotime($job->invoicedate)) . "</a></td>";
          echo "<td><a href='invoiced_job.php?jobid=" . $job->id . "'>" . $job->invoicemake . "</a></td>";
          echo "<td><a href='invoiced_job.php?jobid=" . $job->id . "'>" . $job->invoicemodel . "</a></td>";
          echo "<td><a href='invoiced_job.php?jobid=" . $job->id . "'>" . $job->invoiceserialnumber . "</a></td>";
          echo "<td><a href='invoiced_job.php?jobid=" . $job->id . "'>" . $job->invoicetotal . "</a></td>";
          echo "<td><a href='invoiced_job.php?jobid=" . $job->id . "'>" . $job->status . "</a></td>";
          echo "<td><a href='invoiced_job.php?jobid=" . $job->id . "'>" . $job->storerefno . "</a></td>";
          echo "<td><a href='invoiced_job.php?jobid=" . $job->id . "'>" . $job->vendorrefno . "</a></td>";
          echo "<td><a href='invoiced_job.php?jobid=" . $job->id . "'>Details</a></td>";
	  echo "<td><a href='invoiced_job.php?jobid=" . $job->id . "'>" . $job->deliveryaddress . "</a></td>";
	  echo "<td><a href='invoiced_job.php?jobid=" . $job->id . "'>" . $job->workshop . "</a></td>";

        }

    } else {

      echo "<tr><td colspan='10'>No jobs to show</td></tr>";

    }
    ?>
    </tbody>
  </table>
        
<!--            <div class="row">
                <table class="table table-condensed table-striped table-hover table-responsive">
                    <thead>
                        <tr>
                            <th>Job #</th>
                            <th>Customer</th>
                            <th>Customer Name</th>
                            <th>Status</th>
                            <th>Invoice #</th>
                            <th>Date</th>
                            <th>Make</th>
                            <th>Model</th>
                            <th>Total</th>
                            <th></th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($jobs as $job) { ?>
                        <tr>
                            <td> <?php echo $job->job; ?> </td>
                            <td> <?php echo $job->customer; ?> </td>
                            <td> <?php echo $job->customername; ?> </td>
                            <td> <?php echo $job->status; ?> </td>
                            <td> <?php echo $job->invoicenumber; ?> </td>
                            <td> <?php echo $job->invoicedate; ?> </td>
                            <td> <?php echo $job->invoicemake; ?> </td>
                            <td> <?php echo $job->invoicemodel; ?> </td>
                            <td> <?php echo is_numeric($job->invoicetotal) ? ('R ' . number_format($job->invoicetotal, 2)) : 'R 0.00'; ?> </td>
                            <td> <a href="invoiced_job.php?jobid=<?php echo $job->id; ?>" title="View invoice details"><span class="label label-success">Details</span></a> </td>
                        </tr>
                        <?php } ?>
                    </tbody>
                </table>
            </div>-->
        </div>
    </body>
</html>
