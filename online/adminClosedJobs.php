<?php
 //session_start();
 //require_once('include/functions.php');
 
 error_reporting(E_ALL);
ini_set('display_errors', '1');
require_once("../newlib/config.php");
?><!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="X-UA-Compatible" content="IE=EmulateIE7" />
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Accepted/Rejected Jobs</title>
<link href="style/style2.css" rel="stylesheet" type="text/css" />
<? include "include/header.php" ?>
<table summary="content" width="965" cellpadding="0" cellspacing="0" >
  	<tr>
  		<td width="31" class="title" headers="nameofpage"><img src="images/titlebg_left.jpg" width="31" height="56" /></td>
		<td  class="titletext" nowrap="nowrap">Accepted/Rejected Jobs</td>
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
	 // Connects to your Database 
	$conn = new PDO("mysql:host=localhost;port=3306;dbname=$db", $dbUser, $dbPassword); 
	extract($_GET);
	 //This checks to see if there is a page number. If not, it will set it to page 1 
	 if (!(isset($pagenum))) 
	 { 
	 $pagenum = 1; 
	 } 
	 @session_start();
	 //Here we count the number of results 
	 //Edit $data to be your query 
	 $sql ="SELECT * FROM jobinfoweb 
				ORDER BY QuoteJobDate DESC
				";//
	 $data = $conn->query($sql);
	 //$data = $dbObject->dbQuery($sql);
	 $rows = $data->rowCount();
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
				ORDER BY QuoteJobDate DESC $max";//
				
				//echo $sql;
	 //$data_p = $dbObject->dbQuery($sql) or die(mysql_error());
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
									<th width='120px'>Status</th>
									<th width='120px'>Details</th>
									<th width='120px'>Response</th>
								</tr>
							</thead>
							<tbody>";		
	//This is where you display your query results
	$row = $query->fetch(PDO::FETCH_ASSOC);
	if($row)
	{
		extract($row);
	 $sql ="SELECT * FROM JobUpdateWeb
						WHERE job= '".$Job."' ";
				//$res = $dbObject->dbQuery($sql);
				$query = $conn->query($sql);
				$res = $query->rowCount();
				$answer="visible";
				if($res > 0 ){ $answer="hidden";}
				//$line=mysql_fetch_array($res);
				$line= $query->fetch(PDO::FETCH_ASSOC);
				if($line['AcceptQuote']==1){$label='Accepted';} else {$label='Rejected';}
	
		if ($answer=="hidden"){			
			$string .= "	<tr>
								<td>".$Job."</td>
								<td>".$QuoteJobDate."</td>
								<td>".$QuoteMake."</td>
								<td>".$QuoteModel."</td>
								<td>".$QuoteSerialNumber."</td>
								<td>".$QuoteTotal."</td>
								<td>".$QuoteTotalTax."</td>			
								<td>".$QuoteGrandTotal."</td>	
								<td>".$Status."</td>	
								<td align='center'>
									<a href='job_detail.php?Job=".$Job."&FaultDescription=".$FaultDescription."&WorkDone=".$WorkDone."&Item=".$Item."&QuoteTotal=".$QuoteTotal."&QuoteTotalTax=".$QuoteTotalTax."&QuoteGrandTotal=".$QuoteGrandTotal."&Accessories=".$Accessories." ' id='detail'  >Details</a> 
								</td>				
								<td align='center'>
									".$label."
								
								</td>
							</tr>
							";
		}
	}
	 while($row = mysql_fetch_array( $data_p )) 
	 { 
	 	extract($row);
	 $sql ="SELECT * FROM JobUpdateWeb
						WHERE job= '".$Job."' ";
				//$res = $dbObject->dbQuery($sql);
				$query = $conn->query($sql);
				$res = $query->rowCount();
				$answer="visible";
				if($res > 0 ){ $answer="hidden";}
				//$line=mysql_fetch_array($res);
				$line= $query->fetch(PDO::FETCH_ASSOC);
				if($line['AcceptQuote']==1){$label='Accepted';} else {$label='Rejected';}
	
		if ($answer=="hidden"){			
			$string .= "	<tr>
								<td>".$Job."</td>
								<td>".$QuoteJobDate."</td>
								<td>".$QuoteMake."</td>
								<td>".$QuoteModel."</td>
								<td>".$QuoteSerialNumber."</td>
								<td>".$QuoteTotal."</td>
								<td>".$QuoteTotalTax."</td>			
								<td>".$QuoteGrandTotal."</td>	
								<td>".$Status."</td>	
								<td align='center'>
									<a href='job_detail.php?Job=".$Job."&FaultDescription=".$FaultDescription."&WorkDone=".$WorkDone."&Item=".$Item."&QuoteTotal=".$QuoteTotal."&QuoteTotalTax=".$QuoteTotalTax."&QuoteGrandTotal=".$QuoteGrandTotal."&Accessories=".$Accessories." ' id='detail'  >Details</a> 
								</td>				
								<td align='center'>
									".$label."
								
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

//include "include/footer.php";
?> 