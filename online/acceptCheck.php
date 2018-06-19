<?php 
require_once("../newlib/config.php");
require_once('include/functions.php');

	$conn = new PDO("mysql:host=localhost;port=3306;dbname=$db", $dbUser, $dbPassword); 
		
		$sqlUpdate="SELECT *
					FROM JobUpdateWeb
					WHERE Job='".$_GET['Job']."'
					AND AcceptQuote=1
				";
				$query = $conn->query($sqlUpdate);
		//$resultsUpdate = $dbObject->dbQuery($sqlUpdate);
		
		//echo "<br/>num".mysql_num_rows($resultsUpdate);
		
		if ($query->rowCount() > 0 ){
			redirect("current_job.php","Accepted");
			exit();
		}
		else{
			redirect("current_job.php","Not Accepted, Something Went Wrong!");
			exit();
		}		
?>
