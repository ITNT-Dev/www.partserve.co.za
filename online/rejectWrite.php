<?php 
require_once('include/db_access.php');
require_once('include/functions.php');
require_once("../newlib/index.php");
if ( (isset($_GET['answer']) ) && ($_GET['answer']!=='null') ){
		//print_r($_GET);
		@extract($_GET);
		
		$sqlUpdate="UPDATE jobinfoweb 
				SET Status='Quote Accepted' WHERE Job='".$Job."'
				";
		$db = IOC::make('database', array());
		$db->make_query($sqlUpdate);

	
		//echo "mark".$_SESSION['userId'];	
		$sql="INSERT INTO JobUpdateWeb (Job,Customer,AccountContactName,AccountContactEmail,AccountContactTel,AccountContactCell,SalesContactName,SalesContactEmail,SalesContactTel,SalesContactCell,RejectQuote,reason)
				VALUES
				(
				'".$Job."',
				'".$Customer."',
				'".$AccountContactName."',
				'".$AccountContactEmail."',
				'".$AccountContactTel."',
				'".$AccountContactCell."',
				'".$SalesContactName."',
				'".$SalesContactEmail."',
				'".$SalesContactTel."',
				'".$SalesContactCell."',
				'1',
				'".$answer."'
				)
				";
				
		$db = IOC::make('database', array());
		$db->make_query($sql);

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
						<td><br><br>Regards<br>Partserve Online</td>
					</tr>
				</table>";
		  
		  $headers  = 'MIME-Version: 1.0' . "\r\n";
		  $headers .= 'Content-type: text/html; charset=iso-8859-1' . "\r\n";
		  $headers .= "From: ITNT<support@itnt.co.za>" . "\r\n";
		  
		
		
	
	}
	
	redirect("rejectCheck.php?Job=".$_GET['Job'] );
	
?>