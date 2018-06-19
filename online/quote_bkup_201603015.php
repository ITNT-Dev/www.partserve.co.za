<?php
session_start();

include "../library/stdinc.php";
require_once(dirname(__FILE__).'/../config/config.inc.php');

require_once '../bootstrap.php'; // load my required files

//  error_reporting(0);

$pagename = "";

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
$icon  = isset($_GET['icon']) ? htmlentities($_GET['icon']) : "";
// echo "Icon: $icon<br>";
if ($icon == "") {
  $icon = 1;
}
// echo "Icon $icon <br>";
$browser    = $_SERVER['HTTP_USER_AGENT'];
$ipAddress  = $_SERVER['REMOTE_ADDR'];
?>

<?php
$comment = "";
$proofOfPurchase = JobProofOfPurchase::find_by_job($Job);
if ($proofOfPurchase == NULL) {
    $proofOfPurchase = new JobProofOfPurchase();
}

$purchaseOrder = JobPurchaseOrder::find_by_job($Job);
if ($purchaseOrder == NULL) {
    $purchaseOrder = new JobPurchaseOrder();
}

$customer = "";
$contactPerson = "";
$contactPersonPhone = "";
$contactPersonEmail = "";
if (isset($_POST['submitComment'])) {
    //TMy_Utils::print_Post();
    $comment = trim($_POST['comment']);
    $job = trim($_POST['job']);
    $customer = trim($_POST['customer']);
    $contactPerson = trim($_POST['contact_person']);
    $contactPersonPhone = trim($_POST['phone']);
    $contactPersonEmail = trim($_POST['email']);
    
    if (trim($job) == "") {
        echo "<script>alert('The job number has not been set');</script>";
    }
    else if ($comment == "") {
        echo "<script>alert('You may not submit a blank comment / query');</script>";
    }
    else if (strlen($comment) > 250) {
        echo "<script>alert('Your comment / query cannot be more than 250 characters long');</script>";
    }
    else if ($contactPerson == "") {
        echo "<script>alert('Enter the name of a person to contact in relation to this query');</script>";
    }
    else {
        $customerQuery = new JobCustomerQuery();
        $customerQuery->job = $Job;
        $customerQuery->customer = $customer;
        $customerQuery->date = date('Y-m-d');
        $customerQuery->time = date('H:i');
        $customerQuery->query = $comment;
        $customerQuery->contactperson = $contactPerson;
        $customerQuery->synched = 0;
        $customerQuery->contactpersonphone = $contactPersonPhone;
        $customerQuery->contactpersonemail = $contactPersonEmail;
        
        $customerQuery->save();
        
        // send a notification email
        $isTest = FALSE;
        
        $to = "csteam@partserve.co.za";
        
        if ($isTest) {
            $to = "gavin@itnt.co.za";
        }
        
        $subject = "Online Job Tracking Customer Query";
        $body = "<html>"
                . "<head>"
                . "<title>Customer Query</title>"
                . "</head>"
                . "<body>"
                . "<h1>Online Job Tracking Customer Query (" . strtoupper(trim($Job)) . ") </h1>"
                . "<p><strong>Job:</strong> " . $Job . "</p>"
                . "<p><strong>Customer:</strong> " . ($customer == "" ? "N/A" : $customer) . "</p>"
                . "<p><strong>Comment / Comment:</strong> </p>"
                . "<p>" . $comment . "</p>"
                . "</body>"
                . "</html>";
        
        if (TMy_Utils::sendEmail($to, $subject, $body)) {
            echo "<script>alert('An email has been sent to Customer Support.');</script>";
        }
        else {
            echo "<script>alert('ERROR: Failed to send an email to Customer Support.');</script>";
        }
    }
}
else if (isset($_GET['downloadProofOfPurchase']) && $_GET['downloadProofOfPurchase'] == 1) {
    $file = $proofOfPurchase->file;
    if (file_exists($file)) {
        header('Content-Description: File Transfer');
        header('Content-Type: application/octet-stream');
        header("Content-Type: application/force-download");
        header('Content-Disposition: attachment; filename=' . urlencode(basename($file)));
        // header('Content-Transfer-Encoding: binary');
        header('Expires: 0');
        header('Cache-Control: must-revalidate, post-check=0, pre-check=0');
        header('Pragma: public');
        header('Content-Length: ' . filesize($file));
        ob_clean();
        flush();
        readfile($file);
        exit();
    }
    else {
        echo "<script>alert('File not found (broken file link)');</script>";
    }
    
    header('Location: quote.php?qid=' . $Job);
    exit();
}
else if (isset ($_GET['downloadPurchaseOrder']) && $_GET['downloadPurchaseOrder'] == 1) {
    $file = $purchaseOrder->file;
    
    if (file_exists($file)) {
        header('Content-Description: File Transfer');
        header('Content-Type: application/octet-stream');
        header("Content-Type: application/force-download");
        header('Content-Disposition: attachment; filename=' . urlencode(basename($file)));
        // header('Content-Transfer-Encoding: binary');
        header('Expires: 0');
        header('Cache-Control: must-revalidate, post-check=0, pre-check=0');
        header('Pragma: public');
        header('Content-Length: ' . filesize($file));
        ob_clean();
        flush();
        readfile($file);
        exit();
    }
    else {
        echo "<script>alert('File not found (broken file link)');</script>";
    }
    
    header('Location: quote.php?qid=' . $Job);
    exit();
}
else if (isset($_GET['downloadDateAudit']) && $_GET['downloadDateAudit'] == 1) {
    $dateAudit = JobDateAudit::find_by_job($Job);

    if (count($dateAudit) == NULL) {
        $dateAudit = new JobDateAudit(array(
            'logdate' => '0000-00-00 00:00:00',
            'quotedate' => '0000-00-00 00:00:00',
            'acceptdate' => '0000-00-00 00:00:00',
            'invoicedate' => '0000-00-00 00:00:00',
            'storedate' => '0000-00-00 00:00:00',
            'job' => $Job,
            'collectionref' => ''
        ));
    }
    
    if ($dateAudit != NULL) {
        try {
            $filename = "files/tmp/" . $Job . "_Date_Audit_" . date('Ymd_His') . ".csv";
            $csv = fopen($filename, "w");
            $fields = array(
                array(
                    'Job', $dateAudit->job
                ),
                array(
                    'Log Date', $dateAudit->logdate == '0000-00-00 00:00:00' ? 'N/A' : $dateAudit->logdate
                ),
                array(
                    'Quote Date', $dateAudit->quotedate == '0000-00-00 00:00:00' ? 'N/A' : $dateAudit->quotedate
                ),
                array(
                    'Accept Date', $dateAudit->acceptdate == '0000-00-00 00:00:00' ? 'N/A' : $dateAudit->acceptdate
                ),
                array(
                    'Invoice Date', $dateAudit->invoicedate == '0000-00-00 00:00:00' ? 'N/A' : $dateAudit->invoicedate
                ),
                array(
                    'Store Date', $dateAudit->storedate == '0000-00-00 00:00:00' ? 'N/A' : $dateAudit->storedate
                ),
                array(
                    'Collection Ref', $dateAudit->collectionref
                )
            );
            foreach ($fields as $line) {
                fputcsv($csv, $line);
            }
            
            fclose($csv);

            header('Content-Type: application/octet-stream');
            header('Content-Disposition: attachment; filename='.basename($filename));
            header('Expires: 0');
            header('Cache-Control: must-revalidate');
            header('Pragma: public');
            header('Content-Length: ' . filesize($filename));
            readfile($filename);

            exit(); // so that you do not download rest of html code
        }
        catch (Exception $ex) {
            echo "<script>alert('" . $ex->getMessage() . "');</script>";
        }
    }
}
else if (isset($_POST['submitProofOfPurchase'])) {
//    TMy_Utils::print_Post();    
//    TMy_Utils::print_Files();
    
    $job = trim($_POST['job']);
    
    if ($job == "") {
        echo "<script>alert('The job number has not been set');</script>";
    }
    else if (!isset($_FILES['proofOfPurchasePdf'])) {
        echo "<script>alert('Nothing to upload');</script>";
    }
    else if (strpos(strtolower($_FILES['proofOfPurchasePdf']['name']), ".pdf") === FALSE) {
        echo "<script>alert('You may only upload pdf files');</script>";
    }
    else {
        // start upload
        $filename = "files/proof_of_purchase/" . $job . "_" . "Proof_of_Payment.pdf";
        if (!move_uploaded_file($_FILES['proofOfPurchasePdf']['tmp_name'], $filename)) {
            echo "<script>alert('File upload failed');</script>";
        }
        else {
            $proofOfPurchase->job = $job;
            $proofOfPurchase->file = $filename;
            $proofOfPurchase->date = date('Y-m-d H:i:s');
            $proofOfPurchase->synched = 0;
            $proofOfPurchase->timesynched = '0000-00-00 00:00:00';
            $proofOfPurchase->save();
            echo "<script>alert('File upload successful');</script>";
        }
    }
}

?>

<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>PartServe</title>
    
    <link href="css/bootstrap.min.css" rel="stylesheet">
    <link href="css/style2.css" rel="stylesheet">
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

<script src="../scripts/jquery.js" type="text/javascript"></script>
    <script type="text/javascript">  
        $(document).ready(function(){
            $("#report tr:odd").addClass("odd");
            $("#report tr:not(.odd)").hide();
            $("#report tr:first-child").show();
            
            $("#report tr.odd").click(function(){
                $(this).next("tr").toggle();
                $(this).find(".arrow").toggleClass("up");
            });
            //$("#report").jExpand();
        });
    </script> 
    
    <script type="text/javascript">  
        $(document).ready(function(){
            $("#report2 tr:odd").addClass("odd");
            $("#report2 tr:not(.odd)").hide();
            $("#report2 tr:first-child").show();
            
            $("#report2 tr.odd").click(function(){
                $(this).next("tr").toggle();
                $(this).find(".arrow").toggleClass("up");
            });
            //$("#report2").jExpand();
        });
    </script></head>
  <body>

  
    <div class="container">
    <div class="row"></div>
      
      <?php require_once ((dirname(__FILE__)) . "/header.php"); ?>

      <div class="row">
        <!--<div class="span2">&nbsp;</div>-->
        <div class="col-md-1">&nbsp;</div>

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
       // echo "Customer: $Customer <br>";
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
        $Reason                = $query_data['reason'];


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
        $JobNotes               = trim($query_data['JobNotes']);
        
        $LastContactNotes = trim($query_data['LastContactNotes']);

        $cTemp = "List job " . $Job . " for customer " . $Customer . " ";
        ?>

          <table width=100%>
          <tr>
            <td><strong>CUSTOMER</strong></td><td><?php echo $Customer; ?> </td></tr>
            <tr>
              <td><strong>JOB NO.</strong></td>
              <td><?php echo $Job ?></td>
            </tr>
            <tr>
              <td><strong>STATUS</strong></td>
              <td><?php echo strtoupper($Status); ?>  
              <?php
              if (strtolower($Status) != "quote" && strtolower($Status) != "quote rejected") {
                if ($proofOfPurchase->id > 0) {
                    // download
                    echo '&nbsp; &nbsp; <a href="?qid=' . $Job . '&downloadProofOfPurchase=1" class="btn btn-success btn-xs" title="Download Proof of Purchase"><span class="glyphicon glyphicon-download-alt"></span> Download proof of purchase</a>';
                }
              
              ?>
                  
              <?php
              }
              ?>
                  
              <?php
              // Purchase Order
              if (strtolower($Status) != "quote" && strtolower($Status) != "quote rejected") {
                if ($purchaseOrder->id > 0) {
                    // download
                    echo '&nbsp; &nbsp; <a href="?qid=' . $Job . '&downloadPurchaseOrder=1" class="btn btn-success btn-xs" title="Download Purchase Order"><span class="glyphicon glyphicon-download-alt"></span> Download Purchase Order</a>';
                }
              
              ?>
                  
              <?php
              }
              ?>              </td>
            </tr>
            
            <?php if (strtoupper(trim($Status)) == strtoupper("Awaiting Customer")) { ?>
            
            <tr>
              <td><strong>AWAITING NOTES</strong></td>
              <td><span class="alert-danger2"> <?php echo $LastContactNotes; ?></span>  &nbsp;&nbsp;&nbsp;&nbsp;<a class="btn btn-xs btn-primary" title="Provide Feedback" href="customer_note.php?qid=<?php echo $Job; ?>"> Provide Feedback </a> </td>
            </tr>
            
            <?php } ?>
            
            <?php
            if (strtolower($Status) == "awaiting customer") {
                ?>
            <tr>
                    <td><strong>NOTES</strong></td>
                    <td><?php echo trim($JobNotes); ?>  </td>
            </tr>
            <?php
            }
            ?>
            
            <tr>
              <td><strong>FAULT DESC.</strong></td>
              <td><?php echo $FaultDescription ?></td>
            </tr>
            <tr>
              <td valign='top'><strong>WORK DONE</strong></td>
              <td>
              <?php 
              foreach ($workList as $job){ 
              	echo $job . "<br>";
              }
              ?>              </td>
            </tr>
            <tr>
              <td valign='top'>&nbsp;</td>
              <td>&nbsp;</td>
            </tr>
            <tr>
              <td valign='top'><strong>ITEMS</strong></td>
              <td>
              <?php
              $string = "<table class='table table-striped table-condensed table-hover'>"
                      . "<th style='text-align:center;'>Store</th>"
                      . "<th style='text-align:center;'>Part Number</th>"
                      . "<th style='text-align:center;'>Description</th>"
                      . "<th style='text-align:center;'>QTY</th>"
                      . "<th style='text-align:center;'>Price</th>"
                      . "<th style='text-align:center;'>Part ETA</th>"
                      . "<tr>";

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

              ?>              </td>
            </tr>
            <tr>
              <td valign='top'><strong>ACCESSORIES</strong></td>
              <td>
              <?php 
              foreach ($AccessoriesList as $accessory){ 
              	echo $accessory . "<br>";
              }
              ?>              </td>
            </tr>
            
            <?php if ($Status == "Quote") { ?>
            <tr><td>&nbsp;</td><td>&nbsp;</td></tr>  
            <tr>
                <td>&nbsp;</td>
                <td>
                  <a href='accept.php?Job=//<?php echo $Job ?>&Customer=<?php echo $Customer ?>&AccountContactName=<?php echo $AccountContactName ?>&AccountContactEmail=<?php echo $AccountContactEmail ?>&AccountContactTel=<?php echo $AccountContactTel ?>&AccountContactCell=<?php echo $AccountContactCell ?>&SalesContactName=<?php echo $SalesContactName ?>&SalesContactEmail=<?php echo $SalesContactEmail ?>&SalesContactTel=<?php echo $SalesContactTel ?>&SalesContactCell=<?php echo $SalesContactCell ?>' id='accept' <?php echo @$answer ?>><button class="btn btn-success">Accept</button></a>
                  &nbsp;
                  <a href='reject.php?Job=//<?php echo $Job ?>&Customer=<?php echo $Customer ?>&AccountContactName=<?php echo $AccountContactName ?>&AccountContactEmail=<?php echo $AccountContactEmail ?>&AccountContactTel=<?php echo $AccountContactTel ?>&AccountContactCell=<?php echo $AccountContactCell ?>&SalesContactName=<?php echo $SalesContactName ?>&SalesContactEmail=<?php echo $SalesContactEmail ?>&SalesContactTel=<?php echo $SalesContactTel ?>&SalesContactCell=<?php echo $SalesContactCell ?>' id='accept' <?php echo @$answer ?>><button class="btn btn-danger">Reject</button></a>                </td>
              </tr>
              <tr>
                <td colspan='2'>&nbsp;</td>
              </tr>
            <?php } ?>
            
            
            <!-- JOB DATE AUDIT -->
            
            <?php
            
            $dateAuditList = JobDateAudit::find_all_by_job($Job);
            
            if (count($dateAuditList) == 0) {
                $dateAuditList[] = new JobDateAudit(array(
                    'logdate' => '0000-00-00 00:00:00',
                    'quotedate' => '0000-00-00 00:00:00',
                    'acceptdate' => '0000-00-00 00:00:00',
                    'invoicedate' => '0000-00-00 00:00:00',
                    'storedate' => '0000-00-00 00:00:00'
                ));
            }
            
            if (count($dateAuditList) > 0) {
                ?>
            <tr><td>&nbsp;</td><td>&nbsp;</td></tr>
            <tr>
                <td valign='top'><strong>DATE AUDIT</strong></td>
              <td>
                  <table id="report" width="100%">
                      <tbody>
                        <tr class="odd">
                            <td>
                            <!--+ Click to view the date audit for this job <div class="arrow"></div>--->
                            
                            <div class="panel-heading">
                <h4 class="panel-title">
                    <a class="" aria-expanded="true" data-toggle="collapse" data-parent="#accordion" href="#collapseOne">+ Click to view the date audit for this job <span class=" glyphicon glyphicon-chevron-down pull-right"></span></a>
                </h4>
            </div>
			
			
			
                            </td>

                            <!--<td align="right"><div class="arrow"></div></td>-->
                        </tr>
              <?php 
              foreach ($dateAuditList as $date){ 
                ?>
                <tr style="display: none;">
                    <td> 
                    <div class="panel-body">
                    <p><strong>Received from Customer:</strong> <?php if ($date->logdate != '0000-00-00 00:00:00') { ?>  <?php echo date('d M Y', strtotime($date->logdate)); ?> <?php } else { echo "<span class='label label-danger'>N/A</span>"; } ?></p>
                          <p><strong>Date Quoted</strong>: <?php if ($date->quotedate != '0000-00-00 00:00:00') { ?>  <?php echo date('d M Y', strtotime($date->quotedate)); ?> <?php } else { echo "<span class='label label-danger'>N/A</span>"; } ?></p>
                          <p><strong>Date Quote Accepted:</strong> <?php if ($date->acceptdate != '0000-00-00 00:00:00') { ?>  <?php echo date('d M Y', strtotime($date->acceptdate)); ?> <?php } else { echo "<span class='label label-danger'>N/A</span>"; } ?></p>
                          <p><strong>Date ready for collection:</strong> 
                          <?php if ($date->invoicedate != '0000-00-00 00:00:00') { ?>  <?php echo date('d M Y', strtotime($date->invoicedate)); ?> <?php } else { echo "<span class='label label-danger'>N/A</span>"; } ?> </p>
                          <p><strong>Date when unit was collected / delivered back to customer:</strong> <?php if ($date->storedate != '0000-00-00 00:00:00') { ?> <?php echo date('d M Y', strtotime($date->storedate)); ?> ( <em>Collection Ref. <?php $date->collectionref; ?> </em> ) <?php } else { echo "<span class='label label-danger'>N/A</span>"; } ?></p>
                          <p><br><a class="btn btn-success btn-xs" href="?qid=<?php echo $Job . "&downloadDateAudit=1"; ?>"><span class="glyphicon glyphicon-download-alt"></span> Download Date Audit</a></p>
                </div>
			</div>
                    
                    
                    
                        <!------<div class='well'>
                          <p><strong>Received from Customer:</strong> <?php if ($date->logdate != '0000-00-00 00:00:00') { ?>  <?php echo date('d M Y', strtotime($date->logdate)); ?> <?php } else { echo "<span class='label label-danger'>N/A</span>"; } ?></p>
                          <p><strong>Date Quoted</strong>: <?php if ($date->quotedate != '0000-00-00 00:00:00') { ?>  <?php echo date('d M Y', strtotime($date->quotedate)); ?> <?php } else { echo "<span class='label label-danger'>N/A</span>"; } ?></p>
                          <p><strong>Date Quote Accepted:</strong> <?php if ($date->acceptdate != '0000-00-00 00:00:00') { ?>  <?php echo date('d M Y', strtotime($date->acceptdate)); ?> <?php } else { echo "<span class='label label-danger'>N/A</span>"; } ?></p>
                          <p><strong>Date ready for collection:</strong> 
                          <?php if ($date->invoicedate != '0000-00-00 00:00:00') { ?>  <?php echo date('d M Y', strtotime($date->invoicedate)); ?> <?php } else { echo "<span class='label label-danger'>N/A</span>"; } ?> </p>
                          <p><strong>Date when unit was collected / delivered back to customer:</strong> <?php if ($date->storedate != '0000-00-00 00:00:00') { ?> <?php echo date('d M Y', strtotime($date->storedate)); ?> ( <em>Collection Ref. <?php $date->collectionref; ?> </em> ) <?php } else { echo "<span class='label label-danger'>N/A</span>"; } ?></p>
                          <p><br><a class="btn btn-success btn-xs" href="?qid=<?php echo $Job . "&downloadDateAudit=1"; ?>"><span class="glyphicon glyphicon-download-alt"></span> Download Date Audit</a></p>
                        </div>  ------->                   </td>
                </tr>
                  <?php
                
                break;
              }
              ?>
                  </table>              </td>
            </tr>
            <?php
            }
            ?>
            
            <!-- END JOB DATE AUDIT -->
            
            <?php
            //$queries = JobCustomerQuery::find_all_by_job($Job);
            
            ?>
            <tr><td>&nbsp;</td><td>&nbsp;</td></tr>
            
            
            <!-- JOB CALL HISTORY -->
            
            <?php
            
            $jobCallHistory = JobCallHistory::find('all', array('order' => 'date desc, time desc'/*, 'limit' => 10*/, 'offset' => 0, 'conditions' => array('Job LIKE ?', array($Job))));
            
            //$jobCallHistory = JobCallHistory::find('all', array('order' => 'date desc, time desc', 'limit' => 10, 'offset' => 0));
            
            if (count($jobCallHistory) == 0) {
                $jobCallHistory[] = new JobCallHistory();
            }
            
            if (count($jobCallHistory) > 0) {
                ?>
            <tr><td>&nbsp;</td><td>&nbsp;</td></tr>
            <tr>
                <td valign='top'><strong>CALL HISTORY</strong></td>
              <td>
                  <table id="report2" width="100%">
                      <tbody>
                        <tr class="odd">
                            <td><div class="panel-heading">
                <h4 class="panel-title">
                    <a class="" aria-expanded="true" data-toggle="collapse" data-parent="#accordion" href="#collapseOne">+ Click to view the call history for this job  <span class="glyphicon glyphicon-chevron-down pull-right"></span></a>
                </h4>
            </div> </td>

                            <!--<td align="right"><div class="arrow"></div></td>-->
                        </tr>
              <?php 
              $string_callhistory = "<tr style='display: none;'><td>";
              
              $queryForm = <<<HEREDOC

			<div class="panel-body">
                    <form method="post" action="" class="form-horizontal content-text">
            <div class="form-group">
                          <label for="comment">Customer Query</label>
                <input type="hidden" name="job" value="$Job" />
                <input type="hidden" name="customer" value="$Customer" />
                <textarea class="form-control" rows="2" cols="200" name="comment" id="comment" required >$comment</textarea>
            </div>                                
            <div class="form-group">
                <label for="contact_person">Contact Person</label> 
                <input id="contact_person" class="form-control" type="text" maxlength="148" name="contact_person" required value="$contactPerson" /> 
            </div>
            <div class="form-group">
                <label for="phone">Phone No.</label> 
                <input class="form-control" type="text" maxlength="148" name="phone" id="phone" value="" /> 
            </div>
            <div class="form-group">
                <label for="email">Email</label> <input type="text" class="form-control" maxlength="148" name="email" id="email" value="" /> 
            </div>
            <input type="submit" name="submitComment" value="Submit Query / Comment" class="btn btn-xs btn-success " />
        </form>  
                </div>
			






                      
HEREDOC;
              
              //$string_callhistory .= $queryForm;
              foreach ($jobCallHistory as $call){ 
                  if ($call->id > 0) {
                    $string_callhistory .= 
                      "<div class='well'>"
                      . "<p><strong>Partserve Operator:</strong> " . $call->user . "</p>"
                      . "<p><strong>Date:</strong> " . $call->date . " </p>"
                      . "<p><strong>Time:</strong> " . $call->time . " </p>"
                      . "<p><strong>Notes:</strong> " . $call->notes . "</p> "
                      . "<p> <strong>Contact Person:</strong> " . $call->contactperson . "</p>"
                      . "</div>";
                  }
                ?>
                  <?php
              }
              
              $string_callhistory .= $queryForm;
              
              $string_callhistory .= "</td></tr>";
              
              print $string_callhistory;
              ?>
                  </table>              </td>
            </tr>
            <?php
            }
            ?>
            
            <!-- END JOB CALL HISTORY -->
            
            <?php if (strtolower($Status) != "quote" && strtolower($Status) != "quote rejected") { ?>
            <tr><td>&nbsp;</td><td>&nbsp;</td></tr>
<!--           <tr>
                    <td><p><strong>CUSTOMER</strong></p>
                    <p><strong>QUERY</strong></p>
                    <p>&nbsp;</p>
                    <p>&nbsp;</p>
                    <p>&nbsp;</p>
                    <p><strong>CUSTOMER </strong></p>
                    <p><strong>CONTACT</strong></p>
                    <p>&nbsp;</p>
                    <p>&nbsp;</p>
                    <p>&nbsp;</p></td>
                        <td>
                            <form method="post" action="">
                                <input type="hidden" name="job" value="<?php echo $Job; ?>" />
                                <input type="hidden" name="customer" value="<?php echo $Customer; ?>" />
                                <textarea rows="2" cols="200" name="comment"><?php echo $comment; ?></textarea> &nbsp; <br><br>                                
                                Contact Person (<em> and preferrably contact details</em>): &nbsp; <input type="text" size="148" maxlength="148" name="contact_person" value="" /> <br><br>
                                <input type="submit" name="submitComment" value="Submit Query / Comment" class="btn btn-warning btn-sm-right" />
                            </form>                    </td>
            </tr>-->
            <tr>
                    <td><p><strong>PROOF OF PURCHASE</strong></p></td>
                        <td id="uploadProofOfPurchase">
                            <form method="post" action="" onSubmit="return validateProofOfPurchaseForm(this);" enctype="multipart/form-data">
                                <p><strong> <?php if ($proofOfPurchase->id > 0) { echo 'Re-Upload'; } else { echo ''; } ?></strong></p>
                                <p>&nbsp;</p>
                                <input type="hidden" name="job" value="<?php echo $Job; ?>" />
                                <input type="file" name="proofOfPurchasePdf" id="proofOfPurchasePdf" />  <br> <input type="submit" class="btn btn-xs btn-primary" name="submitProofOfPurchase" value="Upload Proof Of Purchase" /> &nbsp; <em>( *.pdf ) files only</em>
                            </form>
                            <script>
                                    function validateProofOfPurchaseForm(form) {
                                        if (form.proofOfPurchasePdf.value === "") {
                                            alert('No file selected');
                                            return false;
                                        }
                                        
                                        if ((form.proofOfPurchasePdf.value.indexOf(".pdf") < 0) && (form.proofOfPurchasePdf.value.indexOf(".PDF") < 0)) {
                                            alert('Only PDF files may be uploaded');
                                            return false;
                                        }
                                        return true;
                                    }
                            </script>                    </td>
            </tr>
            <tr><td>&nbsp;</td><td>&nbsp;</td></tr>
            <?php } ?>
            
            <tr>
              <td colspan='2'>&nbsp;</td>
            </tr>
            <tr>
              <td>&nbsp;</td>
              <td><a href="javascript:history.go(-1)"><button type="button" class="btn btn-warning btn">Back</button></a></td>
            </tr>
          </table>

        <p>&nbsp;</p>
        <p><center><small><a href="files/terms_and_conditions.pdf" target="_blank" title="Terms and Conditions">Terms and Conditions </a></small></center></p>

        <div class="span2">&nbsp;</div>
      </div>
  
    </div>
    </div>
  
    <!-- jQuery (necessary for Bootstrap's JavaScript plugins) -->
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.0/jquery.min.js"></script>
    <!-- Include all compiled plugins (below), or include individual files as needed -->
    <script src="js/bootstrap.min.js"></script>

  </body>
</html>


