<?php 
require_once('include/db_access.php');
require_once('include/functions.php');
require_once("../newlib/index.php");
$sqlUpdate="SELECT * 
					FROM JobUpdateWeb
					WHERE Job='".$_GET['Job']."'
					AND RejectQuote=1
				";
			$db = IOC::make('database', array());
			list($affect_rows, $datad) = $db->selectquerys($sqlUpdate);
		
		//echo "<br/>num".mysql_num_rows($resultsUpdate);
		
		if ($affect_rows > 0 ){
			redirect("current_job.php","Rejected");
		}
		else{
			redirect("current_job.php","Not Rejected, Something Went Wrong!");
		}		
?>
