<?php

if (session_id() == "") { session_start(); }

require_once dirname(dirname(__FILE__)) . '/bootstrap.php';

$pagename = "invoiced_jobs.php";

$jobid = isset($_REQUEST['jobid']) ? $_REQUEST['jobid'] : 0;
$error = "";

$job = new JobInvoice(array('id' => 0));

if ($jobid > 0) {
     $job = JobInvoice::find_by_id($jobid);
     
     if ($job == NULL) {
         $job = new JobInvoice(array('id' => 0));
     }
}

$contact = CustomerContact::find_by_customer($job->customer);
$proofofdelivery = JobInvoiceProofOfDelivery::find_by_jobinvoiceid($jobid);

if ($proofofdelivery == NULL) {
    $proofofdelivery = new JobInvoiceProofOfDelivery(array('id' => 0));
}

if ($job->id < 1) {
    $error = "The requested job invoice could not be found.";
}

if ($job->id > 0 && $contact == NULL) {
    $contact = CustomerContact::create(array(
        'customer' => $job->customer,
        'customername' => $job->customername
    ));
}

?>
<!DOCTYPE html>
<html>
    <head>
        <meta charset="UTF-8">
        <title>Partserve Online Job Tracking</title>
                
        <!-- Latest compiled and minified CSS -->
        <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.5/css/bootstrap.min.css">

        <!-- Optional theme -->
        <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.5/css/bootstrap-theme.min.css">
        <link href="css/custom.css" rel="stylesheet">

        <!-- Latest compiled and minified JavaScript -->
        <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.5/js/bootstrap.min.js"></script>
    </head>
    <body>
        <div class="container">
            <div class="row"></div>
            
            <?php require_once ((dirname(__FILE__)) . "/header.php"); ?>
            
            <h1>Full Details of Invoice <?php echo $job->invoicenumber != "" ? ('# ' . $job->invoicenumber) : ""; ?></h1>
            
            <?php if (trim($error) != "") { ?>
                <div class="alert alert-danger" role="alert"> <?php echo $error; ?> </div>
            <?php } ?>
            
            <p>
            <table class="table">
                <tbody>
                    
                    <tr>
                        <td colspan="2" align='left'><strong>DETAILS</strong> <span class="pull-right"><a href="invoiced_jobs.php" title="Back" class="btn btn-sm btn-default" > Back </a></span></td>
                    </tr>
                    
                    <tr>
                        <td>Invoice #</td>
                        <td><span class="pull-right"><?php echo $job->invoicenumber != "" ? $job->invoicenumber : "N/A"; ?></span></td>
                    </tr>
                    
                    <tr>
                        <td>Invoice Date</td>
                        <td><span class="pull-right"><?php echo date('Y-m-d', strtotime($job->invoicedate)); ?></span></td>
                    </tr>
                    
                    <tr>
                        <td>JOB #</td>
                        <td><span class="pull-right"><?php echo $job->job; ?></span></td>
                    </tr>
                    
                    <tr>
                        <td>Customer</td>
                        <td><span class="pull-right"><?php echo $job->customer; ?></span></td>
                    </tr>
                    
                    <tr>
                        <td>Customer Name</td>
                        <td><span class="pull-right"><?php echo $job->customername; ?></span></td>
                    </tr>
                    
                    <tr>
                        <td colspan="3">&nbsp;  </td>
                    </tr>
                    
                    <tr>
                        <td colspan="2" align='left'><strong>CUSTOMER CONTACT DETAILS</strong> <span class="pull-right"> <a class="btn btn-sm btn-warning" title="Update Contact Details" href="customer_contact.php?jobid=<?php echo $job->id; ?>&contactid=<?php echo $contact->id; ?>"> Update Contact Details </a></span></td>
                    </tr>
                    
                    <tr>
                        <td>Contact Person</td>
                        <td><span class="pull-right"><?php echo $contact->contactperson; ?></span></td>
                    </tr>
                    
                    <tr>
                        <td>Address</td>
                        <td><span class="pull-right"><?php echo rtrim(implode(', ', array($contact->customeraddress1, $contact->customeraddress2, $contact->customeraddress3, $contact->customeraddress4, $contact->customeraddress5)), ", "); ?></span></td>
                    </tr>
                    
                    <tr>
                        <td>Contact Details</td>
                        <td><span class="pull-right"><?php echo $contact->customertelephone . " " . $contact->customercellphone; ?></span></td>
                    </tr>
                    
                    <tr>
                        <td>Customer Email</td>
                        <td><span class="pull-right"><?php echo $contact->customeremail; ?></span></td>
                    </tr>                    
                    
                    <tr>
                        <td colspan="3">&nbsp;  </td>
                    </tr>
                    
                    <tr>
                        <td colspan="2" align='left'><strong>PHYSICAL ADDRESS</strong></td>
                    </tr>
                    
                    <tr>
                        <td>Physical Address</td>
                        <td><span class="pull-right"><?php echo rtrim(implode(", ", array($job->physicaladdress1, $job->physicaladdress2, $job->physicaladdress3, $job->physicaladdress4, $job->physicaladdress5)), ", "); ?></span></td>
                    </tr>
                    
                    <tr>
                        <td colspan="3">&nbsp;  </td>
                    </tr>
                    
                    <tr>
                        <td colspan="2" align='left'><strong>ACCOUNTS</strong></td>
                    </tr>
                    
                    <tr>
                        <td>Account Contact</td>
                        <td><span class="pull-right"><?php echo $job->accountcontactname; ?></span></td>
                    </tr>
                    
                    <tr>
                        <td>Account Contact Details</td>
                        <td>
                            <span class="pull-right">
                            <?php 
                                echo $job->accountcontacttel != "" ? ($job->accountcontacttel . ' (Tel) &nbsp; ') : "";
                                echo  $job->accountcontactcell != "" ? ($job->accountcontactcell . ' (Cell)') : ""; 
                            ?>
                            </span>
                        </td>
                    </tr>
                    
                    <tr>
                        <td>Account Contact Email</td>
                        <td><span class="pull-right"><?php echo $job->accountcontactemail; ?></span></td>
                    </tr>
                    
                    <tr>
                        <td colspan="3">&nbsp;  </td>
                    </tr>
                    
                    <tr>
                        <td colspan="2" align='left'><strong>SALES</strong></td>
                    </tr>
                    
                    <tr>
                        <td>Sales Contact</td>
                        <td><span class="pull-right"><?php echo $job->salescontactname; ?></span></td>
                    </tr>
                    
                    <tr>
                        <td>Sales Contact Email</td>
                        <td><span class="pull-right"><?php echo $job->salescontactemail; ?></span></td>
                    </tr>
                    
                    <tr>
                        <td>Sales Contact Details</td>
                        <td>
                            <span class="pull-right">
                            <?php 
                                echo $job->salescontacttel != "" ? ($job->salescontacttel . " (Tel) &nbsp; ") : "";
                                echo $job->salescontactcell != "" ? ($job->salescontactcell . " (Cell)") : "";
                            ?>
                            </span>
                        </td>
                    </tr>
                    
                    <tr>
                        <td colspan="3">&nbsp;  </td>
                    </tr>
                    
                    <tr>
                        <td colspan="2" align='left'><strong>LAST CONTACT NOTES</strong></td>
                    </tr>
                    
                    <tr>
                        <td colspan="2" align='left'><span class="pull-left"><?php echo $job->lastcontactnotes; ?></span></td>
                    </tr>
                    
                    <tr>
                        <td colspan="3"><hr>  </td>
                    </tr>
                    
                    <tr>
                        <td colspan="2" align='left'><strong>INVOICE DETAILS</strong></td>
                    </tr>
                    
                    <tr>
                        <td>Invoice Account #</td>
                        <td><span class="pull-right"><?php echo $job->invoiceaccountnumber; ?></span></td>
                    </tr>
                    
                    <tr>
                        <td>Invoice Date</td>
                        <td><span class="pull-right"><?php echo $job->invoicedate; ?></span></td>
                    </tr>
                    
                    <tr>
                        <td>Invoice DR Ref.</td>
                        <td><span class="pull-right"><?php echo $job->invoicedrref; ?></span></td>
                    </tr>
                    
                    <tr>
                        <td>Invoice Make</td>
                        <td><span class="pull-right"><?php echo $job->invoicemake; ?></span></td>
                    </tr>
                    
                    <tr>
                        <td>Invoice Model</td>
                        <td><span class="pull-right"><?php echo $job->invoicemodel; ?></span></td>
                    </tr>
                    
                    <tr>
                        <td>Invoice Serial #</td>
                        <td><span class="pull-right"><?php echo $job->invoiceserialnumber; ?></span></td>
                    </tr>
                    
                    <tr>
                        <td colspan="3">&nbsp;  </td>
                    </tr>
                    
                    <tr>
                        <td colspan="2" align='left'><strong>ACTION REQUIRED</strong></td>
                    </tr>
                    
                    <tr>
                        <td colspan="2"><span class="pull-left"><?php echo $job->invoiceactionrequired; ?></span></td>
                    </tr>
                    
                    <tr>
                        <td colspan="3">&nbsp;  </td>
                    </tr>
                    
                    <tr>
                        <td colspan="2" align='left'><strong>INVOICE AMOUNT</strong></td>
                    </tr>
                    
                    <tr>
                        <td>Invoice Total</td>
                        <td><span class="pull-right"><?php echo 'R ' . number_format($job->invoicetotal, 2); ?></span></td>
                    </tr>
                    
                    <tr>
                        <td>Invoice Discount</td>
                        <td><span class="pull-right"><?php echo 'R ' . number_format($job->invoicediscount, 2); ?></span></td>
                    </tr>
                    
                    <tr>
                        <td>Invoice Total Tax</td>
                        <td><span class="pull-right"><?php echo 'R ' . number_format($job->invoicetotaltax, 2); ?></span></td>
                    </tr>
                    
                    <tr>
                        <td>Invoice Grand Total</td>
                        <td><span class="pull-right"><strong><?php echo 'R ' . number_format($job->invoicegrandtotal, 2); ?></strong></span></td>
                    </tr>
                    
                    <tr>
                        <td colspan="3"><hr> </td>
                    </tr>
                    
                    <tr>
                        <td colspan="2" align='left'><strong>FAULT DESCRIPTION</strong></td>
                    </tr>
                    
                    <tr>
                        <td colspan="2" align="left">
                            <span class="pull-left">
                                <?php 
                                    $faults = explode("|", $job->faultdescription);
                                    
                                    foreach ($faults as $fault) {
                                        if (trim($fault) != "") {
                                            echo "- " . $fault . "<br>";
                                        }
                                    }
                                ?>
                            </span>
                        </td>
                    </tr>
                    
                    <tr>
                        <td colspan="3">&nbsp;  </td>
                    </tr>
                    
                    <tr>
                        <td colspan="2" align='left'><strong>ACCESSORIES</strong></td>
                    </tr>
                    
                    <tr>
                        <td colspan="2" align="left">
                            <span class="pull-left">
                                <?php 
                                    $accessories = explode("|", $job->accessories); 
                                    
                                    foreach ($accessories as $acc) {
                                        if (trim($acc) != "") {
                                            echo "- " . $acc . "<br>";
                                        }
                                    }
                                ?>
                            </span>
                        </td>
                    </tr>
                    
                    <tr>
                        <td colspan="3">&nbsp;  </td>
                    </tr>
                    
                    <tr>
                        <td colspan="2" align='left'><strong>WORK DONE</strong></td>
                    </tr>
                    
                    <tr>
                        <td colspan="2">
                            <span class="pull-left">
                                <?php 
                                    $workDone = explode("|", $job->workdone); 
                                    
                                    foreach ($workDone as $wd) {
                                        if (trim($wd) != "") {
                                            echo "- " . $wd . "<br>";
                                        }
                                    }
                                ?>
                            </span>
                        </td>
                    </tr>
                    
                    <tr>
                        <td colspan="3">&nbsp;  </td>
                    </tr>
                    
                    <tr>
                        <td colspan="2" align='left'><strong>ITEMS</strong></td>
                    </tr>
                    
                    <tr>
                        <td colspan="2">
                            <span class="pull-left">
                                <?php 
                                    $items = explode("|", $job->item); 
                                    
                                    if (count($items) > 0) { 
                                        ?>
                                <table class="table table-hover table-condensed table-bordered table-responsive table-striped">
                                    <thead>
                                        <tr>
                                            <td>Store</td>
                                            <td>Part Number</td>
                                            <td>Description</td>
                                            <td>QTY</td>
                                            <td>Price</td>
                                            <td>Part ETA</td>
                                        </tr>
                                    </thead>
                                        <?php
                                        
                                        foreach ($items as $item) {
                                            if (trim($item) != "") {                                                
                                                ?>
                                    <tr>
                                        <?php
                                        foreach (explode("~", $item) as $desc) {
                                            echo "<td>" . $desc . "</td>";
                                        }
                                        ?>
                                    </tr>
                                <?php
                                            }
                                        }
                                        
                                        ?>
                                </table>
                                <?php
                                    }
                                    else {
                                        echo "N/A";
                                    }
                                ?>
                            </span>
                        </td>
                    </tr>
                    
                    <tr>
                        <td colspan="3"><HR>  </td>
                    </tr>
                    
                    <tr>
                        <td colspan="2" align='left'><strong>DELIVERY</strong></td>
                    </tr>
                    
                    <tr>
                        <td colspan="2" align="left">
                            <a class="btn btn-xs btn-warning" href="upload_proof_of_delivery.php?jobid=<?php echo $job->id; ?>"><span class="glyphicon glyphicon-upload"></span> Upload Proof Of Delivery</a>
                            
                            <?php if (file_exists($proofofdelivery->file)) { ?>
                            <a class="btn btn-xs btn-success" href="<?php echo $proofofdelivery->file; ?>" target="_blank"><span class="glyphicon glyphicon-download-alt"></span> Download Proof Of Delivery</a>
                            <!--<a class="btn btn-xs btn-primary" href=" "><span class="glyphicon glyphicon-envelope"></span> Email Proof Of Delivery</a>-->
                            
                            <?php } else { ?>
                            &nbsp; <small><em> No file yet / file does not exist.</em></small>
                            <?php } ?>
                        </td>
                    </tr>
                    
                    <tr>
                        <td>Store Ref. #</td>
                        <td><span class="pull-right"><?php echo $job->storerefno; ?></span></td>
                    </tr>
                    
                    <tr>
                        <td>Vendor Ref. #</td>
                        <td><span class="pull-right"><?php echo $job->vendorrefno; ?></span></td>
                    </tr>
                    
                    <tr>
                        <td>Delivery Address</td>
                        <td><span class="pull-right"><?php echo $job->deliveryaddress; ?></span></td>
                    </tr>
                    
                    <tr>
                        <td>Workshop</td>
                        <td><span class="pull-right"><?php echo $job->workshop; ?></span></td>
                    </tr>
                    
                    <tr>
                        <td colspan="2" align="center"><a class="btn btn-default btn-large" href="invoiced_jobs.php" title="Go to Invoiced Jobs">Close</a></td>
                    </tr>
                    
                </tbody>
            </table>
            </p>
        </div>
    </body>
</html>
