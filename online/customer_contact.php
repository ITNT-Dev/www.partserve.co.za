<?php

if (session_id() == "") { session_start(); }

require_once dirname(dirname(__FILE__)) . '/bootstrap.php';

$pagename = "invoiced_jobs.php";

$jobid = isset($_REQUEST['jobid']) ? $_REQUEST['jobid'] : 0;
$contactid = isset($_REQUEST['contactid']) ? $_REQUEST['contactid'] : 0;
$error = "";

$contact = CustomerContact::find_by_id($contactid);

if ($contact == NULL) {
    $contact = new CustomerContact(array('id' => 0));
    // redirect
    header("Location: invoiced_job.php?jobid=" . $jobid);
    exit();
}

if (isset($_POST['submit'])) {    
    $contact->customer = trim($_POST['customer']);
    $contact->customername = trim($_POST['customername']);
    $contact->contactperson = trim($_POST['contactperson']);
    $contact->customertelephone = trim($_POST['customertelephone']);
    $contact->customercellphone = trim($_POST['customercellphone']);
    $contact->customeremail = trim($_POST['customeremail']);
    $contact->customeraddress1 = trim($_POST['customeraddress1']);
    $contact->customeraddress2 = trim($_POST['customeraddress2']);
    $contact->customeraddress3 = trim($_POST['customeraddress3']);
    $contact->customeraddress4 = trim($_POST['customeraddress4']);
    $contact->customeraddress5 = trim($_POST['customeraddress5']);
    
    if ($contact->is_valid()) {        
        $contact->synched = 0;
        $contact->timesynched = "0000-00-00 00:00:00";
        $contact->datevalid2 = date('Y-m-d H:i:s');
        
        $contact->save(TRUE);
        
        header("Location: invoiced_job.php?jobid=" . $jobid);
        exit();
    }
    else {
        $error = "Model is invalid.";
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
            <div class="row"></div>
            
            <?php require_once ((dirname(__FILE__)) . "/header.php"); ?>
            
            <h1>Update Customer Contact Details</h1>
            
            <?php if (trim($error) != "") { ?>
                <div class="alert alert-danger" role="alert"> <?php echo $error; ?> </div>
            <?php } ?>
            
            <p>Please update customer's contact details in the spaces below:</p>
            
            <p>
            <form class="form-horizontal" method="post" action="">
                <input type="hidden" name="contactid" value="<?php echo $contact->id; ?>" />
                <input type="hidden" name="jobid" value="<?php echo $jobid; ?>" />

                  <div class="form-group">
                    <label for="customer" class="col-sm-2 control-label">Customer</label>
                    <div class="col-sm-10">
                        <input type="text" name="customer" class="form-control" id="customer" placeholder="" value="<?php echo $contact->customer; ?>" readonly>
                    </div>
                  </div>
                
                <div class="form-group">
                    <label for="customername" class="col-sm-2 control-label">Customer Name</label>
                    <div class="col-sm-10">
                      <input type="text" name="customername" class="form-control" id="description" placeholder="" value="<?php echo $contact->customername; ?>" >
                    </div>
                  </div>
                
                <div class="form-group">
                    <label for="contactperson" class="col-sm-2 control-label">Contact Person</label>
                    <div class="col-sm-10">
                      <input type="text" name="contactperson" class="form-control" id="description" placeholder="" value="<?php echo $contact->contactperson; ?>" >
                    </div>
                  </div>
                
                <div class="form-group">
                    <label for="customertelephone" class="col-sm-2 control-label">Telephone</label>
                    <div class="col-sm-10">
                      <input type="text" name="customertelephone" class="form-control" id="customertelephone" placeholder="" value="<?php echo $contact->customertelephone; ?>" >
                    </div>
                  </div>
                
                <div class="form-group">
                    <label for="customercellphone" class="col-sm-2 control-label">Cell Phone</label>
                    <div class="col-sm-10">
                      <input type="text" name="customercellphone" class="form-control" id="customercellphone" placeholder="" value="<?php echo $contact->customercellphone; ?>" >
                    </div>
                  </div>
                
                <div class="form-group">
                    <label for="customeremail" class="col-sm-2 control-label">Email</label>
                    <div class="col-sm-10">
                      <input type="text" name="customeremail" class="form-control" id="customeremail" placeholder="" value="<?php echo $contact->customeremail; ?>" >
                    </div>
                  </div>
                
                <div class="form-group">
                    <label for="customeraddress1" class="col-sm-2 control-label">Address 1</label>
                    <div class="col-sm-10">
                      <input type="text" name="customeraddress1" class="form-control" id="customeraddress1" placeholder="" value="<?php echo $contact->customeraddress1; ?>" >
                    </div>
                  </div>
                
                <div class="form-group">
                    <label for="customeraddress2" class="col-sm-2 control-label">Address 2</label>
                    <div class="col-sm-10">
                      <input type="text" name="customeraddress2" class="form-control" id="customeraddress2" placeholder="" value="<?php echo $contact->customeraddress2; ?>" >
                    </div>
                  </div>
                
                <div class="form-group">
                    <label for="customeraddress3" class="col-sm-2 control-label">Address 3</label>
                    <div class="col-sm-10">
                      <input type="text" name="customeraddress3" class="form-control" id="customeraddress3" placeholder="" value="<?php echo $contact->customeraddress3; ?>" >
                    </div>
                  </div>
                
                <div class="form-group">
                    <label for="customeraddress4" class="col-sm-2 control-label">Address 4</label>
                    <div class="col-sm-10">
                      <input type="text" name="customeraddress4" class="form-control" id="customeraddress4" placeholder="" value="<?php echo $contact->customeraddress4; ?>" >
                    </div>
                  </div>
                
                <div class="form-group">
                    <label for="customeraddress5" class="col-sm-2 control-label">Address 5</label>
                    <div class="col-sm-10">
                      <input type="text" name="customeraddress5" class="form-control" id="customeraddress5" placeholder="" value="<?php echo $contact->customeraddress5; ?>" >
                    </div>
                  </div>

                  <div class="form-group">
                    <div class="col-sm-offset-2 col-sm-10">
                        <a class="btn btn-default" href="invoiced_job.php?jobid=<?php echo $jobid; ?>"> Back </a> <button type="submit" name="submit" class="btn btn-primary" type=""> Submit </button>
                    </div>
                  </div>
            </form>
            </p>
        </div>
    </body>
</html>
