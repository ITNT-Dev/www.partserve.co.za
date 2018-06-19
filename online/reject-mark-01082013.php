<?php 
	require_once('include/db_access.php');
	require_once('include/functions.php');
	
	echo '<div id="myDiv"></div>
			<script language="javascript" > 
			
			var answer= window.prompt("Please Enter Reason For Rejection:");
						
			var xmlhttp;
			if (window.XMLHttpRequest)
			  {// code for IE7+, Firefox, Chrome, Opera, Safari
			  xmlhttp=new XMLHttpRequest();
			  }
			else
			  {// code for IE6, IE5
			  xmlhttp=new ActiveXObject("Microsoft.XMLHTTP");
			  }
			xmlhttp.onreadystatechange=function()
			  {
			  if (xmlhttp.readyState==4 && xmlhttp.status==200)
				{
				document.getElementById("myDiv").innerHTML=xmlhttp.responseText;
				}
			  }
			  
			xmlhttp.open("GET","?answer="+answer+"&Job='.$_GET['Job'].'&FaultDescription='.$_GET['FaultDescription'].'&WorkDone='.$_GET['WorkDone'].'&Item='.$_GET['Item'].'&QuoteTotal='.$_GET['QuoteTotal'].'&QuoteTotalTax='.$_GET['QuoteTotalTax'].'&QuoteGrandTotal='.$_GET['QuoteGrandTotal'].'&Accessories='.$_GET['Accessories'].'&Customer='.$_GET['Customer'].'&AccountContactName='.$_GET['AccountContactName'].'&AccountContactEmail='.$_GET['AccountContactEmail'].'&AccountContactTel='.$_GET['AccountContactTel'].'&AccountContactCell='.$_GET['AccountContactCell'].'&SalesContactName='.$_GET['SalesContactName'].'&SalesContactEmail='.$_GET['SalesContactEmail'].'&SalesContactTel='.$_GET['SalesContactTel'].'&SalesContactCell='.$_GET['SalesContactCell'].'",true);
		
			xmlhttp.send();
			
		</script>';
	
	
	
if (isset($_GET['answer']) && $_GET['answer']!="" ){
	$dbObject = new dbObject();
	$dbObject->dbConnect(); 
		
		@extract($_GET);
		
		$sqlUpdate="UPDATE jobinfoweb 
				SET Status='Quote Rejected' WHERE Job='".$Job."'
				";
		$resultsUpdate = $dbObject->dbQuery($sqlUpdate);

	
		//echo "mark".$_SESSION['userId'];	
		$sql="INSERT INTO JobUpdateWeb (Job,Customer,AccountContactName,AccountContactEmail,AccountContactTel,AccountContactCell,SalesContactName,SalesContactEmail,SalesContactTel,SalesContactCell,RejectQuote,reason)
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
				'1',
				'".mysql_escape_string($answer)."'
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
		}		
}

redirect("current_job.php","Rejected");


?>

</body>
</html>
