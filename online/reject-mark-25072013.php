<?php 
	require_once('include/db_access.php');
	require_once('include/functions.php');
	$dbObject = new dbObject();
	$dbObject->dbConnect(); 
		
		@extract($_GET);
		
		$sqlUpdate="UPDATE jobinfoweb 
				SET Status='Quote Rejected' WHERE Job='".$Job."'
				";
		$resultsUpdate = $dbObject->dbQuery($sqlUpdate);

	
		//echo "mark".$_SESSION['userId'];	
		$sql="INSERT INTO JobUpdateWeb (Job,Customer,AccountContactName,AccountContactEmail,AccountContactTel,AccountContactCell,SalesContactName,SalesContactEmail,SalesContactTel,SalesContactCell,RejectQuote)
				VALUES
				(
				'".mysql_escape_string($Job)."',
				'".mysql_escape_string($Customer)."',
				'".mysql_escape_string($AccountContactName)."',
				'".mysql_escape_string($AccountContactEmail)."',
				'".mysql_escape_string($AccountContactTel)."',
				'".mysql_escape_string($AccountContactCell)."',
				'".mysql_escape_string($SalesContactName)."',
				'".mysql_escape_string($SalesContactEmail)."',
				'".mysql_escape_string($SalesContactTel)."',
				'".mysql_escape_string($SalesContactCell)."',
				'1'
				)
				";
				
		$results = $dbObject->dbQuery($sql);
		if ($results){
			
			$body = "<BR/>Please Note:<br/><br/>
					<table>
						<tr>
							<td>Job:</td>
							<td>'".$Job."'- </td>
						</tr>
						<tr>
							<td>Customer:</td>
							<td>'".$Customer."'</td>
						</tr>
						<tr>
							<td>Quote has been REJECTED by client</td>
							
						</tr>
						";
			  
		  $body .="	<tr>
						<td><br><br><br>Regards<br>Partserve Online</td>
					</tr>
				</table>";
		  
		  $headers  = 'MIME-Version: 1.0' . "\r\n";
		  $headers .= 'Content-type: text/html; charset=iso-8859-1' . "\r\n";
		  $headers .= "From: ITNT<support@itnt.co.za>" . "\r\n";
		  
		  $firstMail='mark@itnt.co.za';

		  mail($firstMail, 'Quote Rejected', $body, $headers,'-fsupport@itnt.co.za');
			
		redirect("current_job.php","Rejected");
		}
		


?>

</body>
</html>
