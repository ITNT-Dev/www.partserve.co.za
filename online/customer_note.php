<?php

if (session_id() == "") { session_start(); }

require_once dirname(dirname(__FILE__)) . '/bootstrap.php';

$pagename = "awaitingcustomer_jobs.php";

$qid = isset($_REQUEST['qid']) ? $_REQUEST['qid'] : 0;
$error = "";
$success = "";

$job = JobInfoWeb::find_by_job($qid);

if ($job == NULL) {
    $error = "Failed to load the selected job.";
    $job = new JobInfoWeb(array('job' => $qid));
}

$notification = JobNotifyCustomer::find_by_job_and_customer_and_status_and_awaitingnote_and_synched($qid, $job->customer, $job->status, $job->lastcontactnotes, 0);

//$results = JobInfoWeb::all(array('select' => 'distinct customer'));
//
//TMy_Utils::print_Array($results);

if ($notification == NULL) {
    $notification = new JobNotifyCustomer(array('id' => 0));
}

if (isset($_POST['submit'])) {    
    if (trim($_POST['customernote']) != "") {    
        $attributes = array(        
            'job' => trim($_POST['qid']),
            'customer' => trim($_POST['customer']),
            'status' => trim($_POST['status']),
            'awaitingnote' => trim($_POST['lastcontactnotes']),
            'customernote' => trim($_POST['customernote']),
            'synched' => 0,
            'timesynched' => '0000-00-00 00:00:00'
        );

        if (isset($_POST['attachment']['name']) && trim($_POST['attachment']['name']) != "") {
            // upload file
        }

        if ($notification == NULL) { // create
            $notification = JobNotifyCustomer::create($attributes);
        }
        else {
            // update exisiting
            $notification->update_attributes($attributes);
        }

        if ($notification == NULL) {
            $notification = new JobNotifyCustomer(array('job' => ''));
            $error = "Error in saving your feedback.";
        }
        else {
            // attempt to send out an email
            $success = "Successfully saved your feedback and an email was sent to Parserve.";
        }
    } else {
        $error = "Please provide your feedback first.";
        $notification->customernote = "";
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
            
            <h1>Provide Customer Feedback</h1>
            
            <?php if (trim($error) != "") { ?>
                <div class="alert alert-danger" role="alert"> <?php echo $error; ?> </div>
            <?php } else if (trim($success) != "") { ?>
                <div class="alert alert-success" role="alert"> <?php echo $success; ?> </div>
            <?php } ?>
            
            <p>This job is currently waiting for your feedback. Please provide the necessary information for job processing to resume.</p>
            
            <form class="form-horizontal" method="post" action="" enctype="multipart/form-data">
                <input type="hidden" name="qid" value="<?php echo $job->job; ?>" />        
                <input type="hidden" name="customer" value="<?php echo $job->customer; ?>" /> 
                
                
                <div class="form-group">
                  <label for="status">Job Status</label>
                  <input type="text" class="form-control" id="status" name="status" placeholder="" value="<?php echo $job->status; ?>" readonly />
                </div>
                
                <div class="form-group">
                  <label for="lastcontactnotes">Partserve Says...</label>
                  <input type="text" class="form-control" id="lastcontactnotes" name="lastcontactnotes" placeholder="" value="<?php echo $job->lastcontactnotes; ?>" readonly />
                </div>
                
                <div class="form-group">
                  <label for="customernote">Customer Response</label>
                  <textarea class="form-control" id="customernote" name="customernote"><?php echo $notification->customernote; ?></textarea>
                </div>
                
<!--                <div class="form-group">
                  <label for="attachment">Attach File...</label>
                  <input type="file" id="attachment" name="attachment" />
                  <p class="help-block">Allowed file extensions: <em>*.pdf, *.png, *.jpg, *.jpeg</em></p>
                </div>-->
                
                <div class="form-group">
                    <a href="quote.php?qid=<?php echo $qid; ?>" class="btn btn-default"> Close </a> <button type="submit" name="submit" class="btn btn-primary">Submit</button>
                </div>
            </form>
        </div>
    </body>
</html>

