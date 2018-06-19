<?php
if (session_id() == "") {
    session_start();
}

require_once dirname(__FILE__) . '/_autoload.php';

if (!TSession_Manager::sessionIsValid()) {
    header('Location: index.php');
    exit();
}

?>
<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <title>ITNT SMS</title>

        <!-- Bootstrap -->
        <link href="css/bootstrap.min.css" rel="stylesheet">
        <link href="css/bootstrap.css" rel="stylesheet">
        <link href="css/style.css" rel="stylesheet">
        <link href="css/font-awesome.min.css" rel="stylesheet">
        <!-- Web Font  -->
        <link href='http://fonts.googleapis.com/css?family=Lato:300,400,700,900' rel='stylesheet' type='text/css'>


        <!-- HTML5 shim and Respond.js for IE8 support of HTML5 elements and media queries -->
        <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
        <!--[if lt IE 9]>
          <script src="https://oss.maxcdn.com/html5shiv/3.7.2/html5shiv.min.js"></script>
          <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
        <![endif]-->
    </head>
    <body>


<?php include_once 'includes/header.php'; ?>
<?php
if (TSession_Manager::getUserType() > 0) {
    include_once 'includes/adminnav.php';
} else {
    include_once 'includes/nav.php';
}



$id= $_SESSION["_SMS_UserId"]; 
$contacts = DBContact::all(array('conditions' => "userId = $id"));
$count=0;
//echo $contacts->contact_name;
?>

        <div class="container">
            <div class="col-lg-12">
                <div class="row">
                    <form class="form-horizontal" role="form" method="post" action="">  
                        <div class="divider clearfix"></div>


                        <br><br>
                        <!--<div class="table-responsive">-->
                       
						<div class="container">
                             
                        </div>
                            <table class="table table-responsive table-condensed">

                                <thead>

                                    <tr>
									   <th>Number</th>

                                        <th>Contact Name</th>

                                        <th>Contact Number</th>

                                        <th>group_Name</th>			
                                        
				<th>&nbsp;</th>
                                    </tr>

                                </thead>

                                <tbody>

                                <?php 
							  //print_r("<pre>"); var_dump($contacts); die();
								
								$counters= 1; foreach ($contacts as $contact) { 
								
								?>
                                        <tr>
											<td><?php echo $counters; ?></td>
                                            <td> <?php echo $contact->contact_name; ?></td>

                                            
											<td><?php echo $contact->contact_number; ?></td>
											<td><?php echo $contact->group_name; ?></td>
											<td>
                                           <a href="subscriber_edit.php?id=<?php echo $contact->contact_id ?>"><span class="glyphicon glyphicon-edit"></span></a>  
                                        </td>
                                           
                                        </tr>
                                <?php $counters++;} ?>             

                                </tbody>

                            </table>


<br>
                            <br>
							       <div class="container">
                            
                        </div>


                        <div class="form-group">

                            <div class="col-sm-offset-4 col-sm-4">
                                <a class="btn btn-primary" name="Back" href="groups.php">Back</a>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
        <!--My Modal to confirm user action starts here-->
        <div class="modal fade" id="confirm-delete" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <label class="modal-title">Delete subscriber</label>
                    </div>
                    <div class="modal-body">
                        <p>Are you sure you want to delete this subscriber?</p>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-default" data-dismiss="modal">Cancel</button>
                        <a class="btn btn-danger btn-ok">Delete</a>
                    </div>
                </div>
            </div>
        </div>


    
    <?php include_once 'includes/footer.php'; ?>
	<?php include_once 'admin_modaljs.php'; ?>
	
	    <script src="https://code.jquery.com/jquery-1.10.2.min.js"></script>
    <!-- jQuery (necessary for Bootstrap's JavaScript plugins) -->
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.1/jquery.min.js"></script>
    <!-- Include all compiled plugins (below), or include individual files as needed -->
    <script src="js/bootstrap.min.js"></script>
  </body>
</html>