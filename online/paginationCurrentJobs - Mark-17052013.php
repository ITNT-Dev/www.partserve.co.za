<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Untitled Document</title>
</head>

 <?php 
 
 require_once('include/functions.php');
 if(!isOnLine() )
redirect ("../onlinejobtracking.php");

 error_reporting(E_ALL);
	ini_set('display_errors', '1');
	 // Connects to your Database 
	require_once('include/db_access.php');
	$dbObject = new dbObject();
	$dbObject->dbConnect(); 
	extract($_GET);
	 //This checks to see if there is a page number. If not, it will set it to page 1 
	 if (!(isset($pagenum))) 
	 { 
	 $pagenum = 1; 
	 } 
	 @session_start();
	 //Here we count the number of results 
	 //Edit $data to be your query 
	 $sql ="SELECT * FROM users u
				LEFT JOIN jobinfoweb j ON (u.customer=j.customer)
				WHERE userId= '".$_SESSION['userId']."' 
				ORDER BY QuoteJobDate DESC
				";//
	 $data = $dbObject->dbQuery($sql);
	 $rows = mysql_num_rows($data); 
	 
	
	 //This is the number of results displayed per page 
	 $page_rows =20; 
	//This tells us the page number of our last page 
	 $last = ceil($rows/$page_rows); 
	 //this makes sure the page number isn't below one, or more than our maximum pages 
	 if ($pagenum < 1) 
	 { 
	 $pagenum = 1; 
	 } 
	 elseif ($pagenum > $last) 
	 { 
	 $pagenum = $last; 
	 } 
	 //This sets the range to display in our query 
	 $max = 'limit ' .($pagenum - 1) * $page_rows .',' .$page_rows; 
	 //This is your query again, the same one... the only difference is we add $max into it
	 $sql ="SELECT * FROM users u
				LEFT JOIN jobinfoweb j ON (u.customer=j.customer)
				WHERE userId= '".$_SESSION['userId']."' 
				ORDER BY QuoteJobDate DESC $max";//
				
				//echo $sql;
	 $data_p = $dbObject->dbQuery($sql) or die(mysql_error());
	
	$string = "
	<form name='joblist' action='' method='post'>
				<p>&nbsp;</p>
					<table id='styled' cellspacing='25' summary='jobList' class='joblist' border='0'  >
						<input type='hidden' name='option' value='save'>
							<thead>
								<tr>
									<th>Job No.</th>				
									<th>Quote Job Date</th>
									<th>Make</th>
									<th>Model</th>
									<th>Serial No.</th>
									<th>Amount</th>
									<th>Tax.(VAT)</th>
									<th>Total</th>
									<th>Details</th>
									<th>Status</th>
									<th>Accept</th>
									<th>Reject</th>
									
									
								</tr>
							</thead>
							<tbody>";		
	//This is where you display your query results
	 while($row = mysql_fetch_array( $data_p )) 
	 { 
	 extract($row);
	 $sql ="SELECT * FROM JobUpdateWeb
						WHERE job= '".$Job."' ";//
				$res = $dbObject->dbQuery($sql);
				$answer="visible";
				if(mysql_num_rows($res)>0 ){ $answer="hidden";}
				
				//$details=array("Job"=>$Job,"FaultDescription"=>$FaultDescription,"WorkDone"=>$WorkDone,"Item"=>$Item,"Accessories"=>$Accessories);
			if ($answer=="visible")	{
			$string .= "	<tr>
								<td>".$Job."</td>
								<td>".$QuoteJobDate."</td>
								<td>".$QuoteMake."</td>
								<td>".$QuoteModel."</td>
								<td>".$QuoteSerialNumber."</td>
								<td>".$QuoteTotal."</td>
								<td>".$QuoteTotalTax."</td>			
								<td>".$QuoteGrandTotal."</td>
								<td align='center'>
									<a href='job_detail.php?Job=".$Job."&FaultDescription=".$FaultDescription."&WorkDone=".$WorkDone."&Item=".$Item."&Accessories=".$Accessories." ' id='detail'  >Details</a> 
									
<!--<a href='#' onClick=window.open('details.php?Job=$Job+FaultDescription=$FaultDescription+WorkDone=$WorkDone+Item=$Item+Accessories=$Accessories ','detailsWindow','width=500,height=500')>Details</a>-->
								
								</td>		
								<td>".$Status."</td>
											
								<td align='center'>
									<a href='accept.php?Job=".$Job."&Customer=".$Customer."&AccountContactName=".$AccountContactName."&AccountContactEmail=".$AccountContactEmail."&AccountContactTel=".$AccountContactTel."&AccountContactCell=".$AccountContactCell."&SalesContactName=".$SalesContactName."&SalesContactEmail=".$SalesContactEmail."&SalesContactTel=".$SalesContactTel."&SalesContactCell=".$SalesContactCell." ' id='accept' ".@$answer." >Accept</a> 
								</td>
								<td align='center'>
									<a href='reject.php?Job=".$Job."&Customer=".$Customer."&AccountContactName=".$AccountContactName."&AccountContactEmail=".$AccountContactEmail."&AccountContactTel=".$AccountContactTel."&AccountContactCell=".$AccountContactCell."&SalesContactName=".$SalesContactName."&SalesContactEmail=".$SalesContactEmail."&SalesContactTel=".$SalesContactTel."&SalesContactCell=".$SalesContactCell." ' id='reject' ".@$answer." >Reject</a> 
								</td>								
							</tr>
							";
			}

	 } 
	 echo $string;
	 echo "<p>";
	 // This shows the user what page they are on, and the total number of pages
	 echo " Page $pagenum of $last </p>";
	// First we check if we are on page one. If we are then we don't need a link to the previous page or the first page so we do nothing. If we aren't then we generate links to the first page, and to the previous page.
	 if ($pagenum == 1) 
	 {
	 } 
	 else 
	 {
	 echo " <a href='{$_SERVER['PHP_SELF']}?pagenum=1'> <<-First</a> ";
	 echo " ";
	 $previous = $pagenum-1;
	 echo " <a href='{$_SERVER['PHP_SELF']}?pagenum=$previous'> <-Previous</a> ";
	 } 
	//just a spacer
	// echo " ---- ";
	 //This does the same as above, only checking if we are on the last page, and then generating the Next and Last links
	 if ($pagenum == $last) 
	 {
	 } 
	 else {
	 $next = $pagenum+1;
	 echo " <a href='{$_SERVER['PHP_SELF']}?pagenum=$next'>Next -></a> ";
	 echo " ";
	 echo " <a href='{$_SERVER['PHP_SELF']}?pagenum=$last'>Last ->></a> ";
	 } 
 ?> 

<body>
</body>
</html>
