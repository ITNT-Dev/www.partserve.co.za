 <?php 
 error_reporting(E_ALL);
	ini_set('display_errors', '1');
	require_once("../newlib/index.php");
  require_once('include/functions.php');
 if(!isOnLine() )
redirect ("../onlinejobtracking.php");
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
			AND j.job IN (SELECT job FROM JobUpdateWeb)
			AND Status like '%Quote%'
			ORDER BY QuoteJobDate DESC
				";//
	 $db = IOC::make('database', array());
	 list($affect_rows, $datad) = $db->selectquerys($sql);
	 $rows = $affect_rows;
	 if ($rows<1){echo "<br><br>No Jobs to show"; exit(); }
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
			AND j.job IN (SELECT job FROM JobUpdateWeb)
			AND Status like '%Quote%'
			ORDER BY QuoteJobDate DESC $max";//
				
	 $db = IOC::make('database', array());
	 list($affect_rows, $data_p) = $db->selectquerys($$sql);	
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
	 while($row = $data_p->fetch(PDO::FETCH_ASSOC)) 
	 { 
	 extract($row);
	 $sql ="SELECT * FROM JobUpdateWeb
						WHERE job= '".$Job."' ";
				$res = $dbObject->dbQuery($sql);
				$res = $conn->query($sql);
				//$answer="visible";
				//if(mysql_num_rows($res)>0 ){ $answer="hidden";}
				//$line=mysql_fetch_array($res);
				$line = $res->fetch(PDO::FETCH_ASSOC);
				if($line['AcceptQuote']==1){$label='Accepted';} else {$label='Rejected';}
	
		//if ($answer=="hidden"){			
			$string .= "	<tr>
								<td nowrap>".$Job."</td>
								<td nowrap>".$QuoteJobDate."</td>
								<td nowrap>".$QuoteMake."</td>
								<td nowrap>".$QuoteModel."</td>
								<td nowrap>".$QuoteSerialNumber."</td>
								<td nowrap>".$QuoteTotal."</td>
								<td nowrap>".$QuoteTotalTax."</td>			
								<td nowrap>".$QuoteGrandTotal."</td>	
								<td nowrap>".$Status."</td>	
								<td nowrap align='center'>
									<a href='job_detail.php?Job=".$Job."&FaultDescription=".$FaultDescription."&WorkDone=".$WorkDone."&Item=".$Item."&QuoteTotal=".$QuoteTotal."&QuoteTotalTax=".$QuoteTotalTax."&QuoteGrandTotal=".$QuoteGrandTotal."&Accessories=".$Accessories." ' id='detail'  >Details</a> 
								</td>				
								<td nowrap align='center'>
									".$label."
								
								</td>
							</tr>
							"; 
		//}
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