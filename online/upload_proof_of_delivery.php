<?php
error_reporting(E_ALL);
ini_set( 'display_errors','1'); 
include "../library/stdinc.php";
require_once(dirname(__FILE__).'/../config/config.inc.php');
require_once("newlib/index.php");
session_start();
if (session_id() == "") { session_start(); }
require_once dirname(dirname(__FILE__)) . '/bootstrap.php';

$pagename = "invoiced_jobs.php";

$jobid = isset($_REQUEST['jobid']) ? $_REQUEST['jobid'] : 0;
$error = "";
$db = IOC::make('database', array());
list($affect_rows, $datad) = $db->selectWhere("JobInvoice", "id",$jobid);
$sql ="select * from JobInvoice where id = $jobid";
if ($affected_rows == 0) {
    header('Location: invoiced_jobs.php');
    exit();
}
$db = IOC::make('database', array());
list($affect_rows, $datad) = $db->selectWhere("JobInvoiceProofOfDelivery", "JobInvoiceId",$jobid);
if ($affected_rows == 0) {
$no_records = 0;
$sql ="insert into JobInvoiceProofOfDelivery (jobinvoiceid, invoicenumber)
VALUES (".$results['id'].", ".$results['InvoiceNumber'].")";


$query = $conn->query($sql);
	/*
    $proofofdelivery = JobInvoiceProofOfDelivery::create(array(
        'invoicenumber' => $job->invoicenumber,
        'jobinvoiceid' => $job->id
    ));
	*/
	
	
	
}

if (isset($_POST['submit'])) {    
    $extension = ".pdf";
    $target_dir = "files/proof_of_delivery/";
    $target_file = str_replace(" ", "_", $target_dir . "" . $results['id']. "_proof_of_delivery_" . $results['InvoiceNumber'] . $extension);
    
    if (move_uploaded_file($_FILES['proofofdelivery']['tmp_name'], $target_file)) {
        $proofofdelivery->update_attributes(array(
            'file' => $target_file,
            'invoicenumber' => $job->invoicenumber,
            'jobinvoiceid' => $job->id
        ));
        
        header("Location: invoiced_job.php?jobid=" . $results['id']);
        exit();
    }
    else {
        $error = "Failed to upload the selected file. Make sure that you upload a file that matches the allowed extensions.";
    }
}

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
        <div class="container">
            
            <?php require_once ((dirname(__FILE__)) . "/header.php"); ?>
            
            <h1>Upload Proof Of Delivery</h1>
            
            <?php if (trim($error) != "") { ?>
                <div class="alert alert-danger" role="alert"> <?php echo $error; ?> </div>
            <?php } ?>
            
            <p>Select a document for the proof of delivery and upload.</p>
            
            <form class="form-horizontal" method="post" action="" enctype="multipart/form-data">
                <input type="hidden" name="jobid" value="<?php echo $job->id; ?>" />                
                
                <?php if (file_exists($proofofdelivery->file)) { ?>
                <div class="form-group">
                    <span class="pull-right">
                        <a class="btn btn-xs btn-warning" href="<?php echo $proofofdelivery->file; ?>" target="_blank"> 
                            <span class="glyphicon glyphicon-download-alt"></span> Download Existing Proof Of Delivery
                        </a>                            
                    </span>
                </div>
                <?php } ?>
                
                <div class="form-group">
                  <label for="customer">Customer</label>
                  <input type="text" class="form-control" id="customer" placeholder="" value="<?php echo trim($job->customer) != "" ? $job->customer : 'N/A'; ?>" readonly>
                </div>
                
                <div class="form-group">
                  <label for="invoicenumber">Invoice Number</label>
                  <input type="text" class="form-control" id="invoicenumber" placeholder="" value="<?php echo trim($job->invoicenumber) != "" ? $job->invoicenumber : 'N/A'; ?>" readonly>
                </div>
                
                <div class="form-group">
                  <label for="proofofdelivery">Browse Files...</label>
                  <input type="file" id="proofofdelivery" name="proofofdelivery" required />
                  <p class="help-block">Allowed file extensions: <em>*.pdf, *.png, *.jpg, *.jpeg</em></p>
                </div>
                
                <div class="form-group">
                    <a href="invoiced_job.php?jobid=<?php echo $job->id; ?>" class="btn btn-default"> Cancel </a> <button type="submit" name="submit" class="btn btn-primary">Submit</button>
                </div>
            </form>
        </div>
    </body>
</html>
