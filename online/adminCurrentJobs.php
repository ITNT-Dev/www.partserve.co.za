<?php
 //session_start();
 //require_once('include/functions.php');
 
 error_reporting(E_ALL);
ini_set('display_errors', '1');
require_once("../newlib/index.php");
?><!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="X-UA-Compatible" content="IE=EmulateIE7" />
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Quoted Jobs</title>
<link href="style/style2.css" rel="stylesheet" type="text/css" />
<? include "include/header.php" ?>
<table summary="content" width="965" cellpadding="0" cellspacing="0" >
  	<tr>
  		<td width="31" class="title" headers="nameofpage"><img src="images/titlebg_left.jpg" width="31" height="56" /></td>
		<td  class="titletext" nowrap="nowrap">Quoted Jobs</td>
		<td width="38"><img src="images/titlebg_right.jpg" width="38" height="56" /></td>
		<td width="573" class="titleline">&nbsp;</td></td><td width="13"><a href="contactus.php"><img src="images/titleend_line.jpg" width="154" height="56" /></a></td>
	</tr>
    <tr>
<td>
</table>
<a href="../dashboard.php">Go back to Dashboard</a>

<?php 
 
 require_once('include/functions.php');
 if(!isOnLine() )
redirect ("../onlinejobtracking.php");

 error_reporting(E_ALL);
	ini_set('display_errors', '1');
 
	 if (!(isset($pagenum))) 
	 { 
	 $pagenum = 1; 
	 } 
	 @session_start();
	 //Here we count the number of results 
	 //Edit $data to be your query 
	 $sql ="SELECT * FROM jobinfoweb 
				WHERE Status like '%Quote%'
				ORDER BY QuoteJobDate DESC
				";//
	 $data = $conn->query($sql);
	 //$data = $dbObject->dbQuery($sql);
	 $rows = $data->rowCount();
	 //should table headers be visible or hidden
	 $answer="hidden";
	 $rowCheck = $data->fetch(PDO::FETCH_ASSOC);

	  while($rowCheck = $data->fetch(PDO::FETCH_ASSOC)) 
	 { 
			 $sql ="SELECT * FROM JobUpdateWeb
						WHERE job= '".$rowCheck['Job']."' ";//
				
				$query = $conn->query($sql);
				$res = $query->rowCount();
				if($res ==0 ){ $answer="visible";}
	 }
	 
if($answer=="visible"){
		 //This is the number of results displayed per page 
		 $page_rows =50; 
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
		 $sql ="SELECT * FROM jobinfoweb 
				WHERE Status like '%Quote%'
				ORDER BY QuoteJobDate DESC $max";//
					
					//echo $sql;
		 $data_p = $conn->query($sql);
		
		$string = "
		<form name='joblist' action='' method='post'>
					<p>&nbsp;</p>
						<table id='styled' cellspacing='0' summary='jobList' class='joblist' border='1'  >
							<input type='hidden' name='option' value='save'>
								<thead>
									<tr>
										<th width='120px'>Job No.</th>				
										<th width='120px'>Quote Job Date</th>
										<th width='120px'>Make</th>
										<th width='120px'>Model</th>
										<th width='120px'>Serial No.</th>
										<th width='120px'>Amount</th>
										<th width='120px'>Tax.(VAT)</th>
										<th width='120px'>Total</th>
										<th width='120px'>Details</th>
										<th width='120px'>Status</th>
										<th width='120px'>Accept</th>
										<th width='120px'>Reject</th>

									</tr>
								</thead>
								<tbody>";		
		//This is where you display your query results
		$row = $data_p->fetch(PDO::FETCH_ASSOC);
		if($row)
		{
			extract($row);
		 $sql ="SELECT * FROM JobUpdateWeb
							WHERE job= '".$Job."' ";//
							$query = $conn->query($$sql);
					$res = $query->rowCount();
					$answer="visible";
					if($res > 0 ){ $answer="hidden";}
					
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
										<a href='details-accept-reject.php?Job=".$Job."&FaultDescription=".$FaultDescription."&WorkDone=".$WorkDone."&Item=".$Item."&QuoteTotal=".$QuoteTotal."&QuoteTotalTax=".$QuoteTotalTax."&QuoteGrandTotal=".$QuoteGrandTotal."&Accessories=".$Accessories."&Customer=".$Customer."&AccountContactName=".$AccountContactName."&AccountContactEmail=".$AccountContactEmail."&AccountContactTel=".$AccountContactTel."&AccountContactCell=".$AccountContactCell."&SalesContactName=".$SalesContactName."&SalesContactEmail=".$SalesContactEmail."&SalesContactTel=".$SalesContactTel."&SalesContactCell=".$SalesContactCell." ' id='detail'  >Details</a> 
										
	<!--<a href='#' onClick=window.open('details.php?Job=$Job+FaultDescription=$FaultDescription+WorkDone=$WorkDone+Item=$Item+Accessories=$Accessories ','detailsWindow','width=500,height=500')>Details</a>-->
									
									</td>		
									<td>".$Status."</td>
												
									<td bgcolor='#57ff55' nowrap align='center'>
										<a href='accept.php?Job=".$Job."&Customer=".$Customer."&AccountContactName=".$AccountContactName."&AccountContactEmail=".$AccountContactEmail."&AccountContactTel=".$AccountContactTel."&AccountContactCell=".$AccountContactCell."&SalesContactName=".$SalesContactName."&SalesContactEmail=".$SalesContactEmail."&SalesContactTel=".$SalesContactTel."&SalesContactCell=".$SalesContactCell." ' id='accept' ".@$answer." >Accept</a> 
									</td>
									<td bgcolor='#FF0000' nowrap align='center'>
										<a href='reject.php?Job=".$Job."&Customer=".$Customer."&AccountContactName=".$AccountContactName."&AccountContactEmail=".$AccountContactEmail."&AccountContactTel=".$AccountContactTel."&AccountContactCell=".$AccountContactCell."&SalesContactName=".$SalesContactName."&SalesContactEmail=".$SalesContactEmail."&SalesContactTel=".$SalesContactTel."&SalesContactCell=".$SalesContactCell." ' id='reject' ".@$answer." >Reject</a> 
									</td>								
								</tr>
								";
				}
		}
		 while($row = $data_p->fetch(PDO::FETCH_ASSOC)) 
		 { 
		 	extract($row);
		 $sql ="SELECT * FROM JobUpdateWeb
							WHERE job= '".$Job."' ";//
							$query = $conn->query($$sql);
					$res = $query->rowCount();
					$answer="visible";
					if($res > 0 ){ $answer="hidden";}
					
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
										<a href='details-accept-reject.php?Job=".$Job."&FaultDescription=".$FaultDescription."&WorkDone=".$WorkDone."&Item=".$Item."&QuoteTotal=".$QuoteTotal."&QuoteTotalTax=".$QuoteTotalTax."&QuoteGrandTotal=".$QuoteGrandTotal."&Accessories=".$Accessories."&Customer=".$Customer."&AccountContactName=".$AccountContactName."&AccountContactEmail=".$AccountContactEmail."&AccountContactTel=".$AccountContactTel."&AccountContactCell=".$AccountContactCell."&SalesContactName=".$SalesContactName."&SalesContactEmail=".$SalesContactEmail."&SalesContactTel=".$SalesContactTel."&SalesContactCell=".$SalesContactCell." ' id='detail'  >Details</a> 
										
	<!--<a href='#' onClick=window.open('details.php?Job=$Job+FaultDescription=$FaultDescription+WorkDone=$WorkDone+Item=$Item+Accessories=$Accessories ','detailsWindow','width=500,height=500')>Details</a>-->
									
									</td>		
									<td>".$Status."</td>
												
									<td bgcolor='#57ff55' nowrap align='center'>
										<a href='accept.php?Job=".$Job."&Customer=".$Customer."&AccountContactName=".$AccountContactName."&AccountContactEmail=".$AccountContactEmail."&AccountContactTel=".$AccountContactTel."&AccountContactCell=".$AccountContactCell."&SalesContactName=".$SalesContactName."&SalesContactEmail=".$SalesContactEmail."&SalesContactTel=".$SalesContactTel."&SalesContactCell=".$SalesContactCell." ' id='accept' ".@$answer." >Accept</a> 
									</td>
									<td bgcolor='#FF0000' nowrap align='center'>
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
}
else echo "<br><br>No Jobs to show";


//include "include/footer.php";
?> 