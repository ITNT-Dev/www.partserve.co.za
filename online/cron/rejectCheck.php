<?php 
require_once('include/db_access.php');
require_once('include/functions.php');

	//echo $_GET['Job'];
	$dbObject = new dbObject();
	$dbObject->dbConnect(); 
		
		$sqlUpdate="SELECT * 
					FROM JobUpdateWeb
					WHERE Job='".$_GET['Job']."'
					AND RejectQuote=1
				";
		$resultsUpdate = $dbObject->dbQuery($sqlUpdate);
		
		//echo "<br/>num".mysql_num_rows($resultsUpdate);
		
		if (mysql_num_rows($resultsUpdate)>0 ){
			redirect("current_job.php","Rejected");
		}
		else{
			redirect("current_job.php","Not Rejected, Something Went Wrong!");
		}		
?>
