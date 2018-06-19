<?php 
require_once("../newlib/config.php");
require_once('include/functions.php');
	
if ( (isset($_GET['answer']) ) && ($_GET['answer']!=='null') ){
		//print_r($_GET);
		@extract($_GET);
		
		$conn = new PDO("mysql:host=localhost;port=3306;dbname=$db", $dbUser, $dbPassword); 
		
		$sqlUpdate="UPDATE jobinfoweb 
				SET Status='Quote Accepted' WHERE Job='".$Job."'
				";
				$query = $conn->query($sqlUpdate);
		//$resultsUpdate = $dbObject->dbQuery($sqlUpdate);

	
		//echo "mark".$_SESSION['userId'];	
		$sql="INSERT INTO JobUpdateWeb (Job,Customer,AccountContactName,AccountContactEmail,AccountContactTel,AccountContactCell,SalesContactName,SalesContactEmail,SalesContactTel,SalesContactCell,AcceptQuote,reason)
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
			$results = $conn->query($sql);	
		//$results = $dbObject->dbQuery($sql);
		
		
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
							<td>Quote has been ACCEPTED by client</td>
							
						</tr>
						";
			  
		  $body .="	<tr>
						<td><br><br>Regards<br>Partserve Online</td>
					</tr>
				</table>";
		  
		  $headers  = 'MIME-Version: 1.0' . "\r\n";
		  $headers .= 'Content-type: text/html; charset=iso-8859-1' . "\r\n";
		  $headers .= "From: ITNT<support@itnt.co.za>" . "\r\n";
		  
		  //$firstMail='mark@itnt.co.za';

		  //mail($firstMail, 'Quote Accepted', $body, $headers,'-fsupport@itnt.co.za');
		  
		}
	
	}
	
	redirect("acceptCheck.php?Job=".$_GET['Job'] );
	
?>